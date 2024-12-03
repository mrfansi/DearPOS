import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/domain/entities/product_variant.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';

class VariantManagementCard extends StatefulWidget {
  final Product product;

  const VariantManagementCard({super.key, required this.product});

  @override
  State<VariantManagementCard> createState() => _VariantManagementCardState();
}

class _VariantManagementCardState extends State<VariantManagementCard> {
  final Map<String, TextEditingController> _optionControllers = {};
  final Map<String, List<String>> _variantOptions = {};

  @override
  void initState() {
    super.initState();
    _variantOptions.addAll(widget.product.variantOptions);
  }

  @override
  void dispose() {
    for (var controller in _optionControllers.values) {
      controller.dispose();
    }
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildHeader(),
            const SizedBox(height: 16),
            if (widget.product.hasVariants) ...[
              _buildVariantOptions(),
              const SizedBox(height: 16),
              _buildVariantList(),
            ],
          ],
        ),
      ),
    );
  }

  Widget _buildHeader() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        const Text(
          'Product Variants',
          style: TextStyle(
            fontSize: 18,
            fontWeight: FontWeight.bold,
          ),
        ),
        Switch(
          value: widget.product.hasVariants,
          onChanged: (value) {
            if (value) {
              _showAddVariantOptionDialog();
            } else {
              _showDisableVariantsConfirmation();
            }
          },
        ),
      ],
    );
  }

  Widget _buildVariantOptions() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            const Text(
              'Variant Options',
              style: TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.w500,
              ),
            ),
            TextButton.icon(
              icon: const Icon(Icons.add),
              label: const Text('Add Option'),
              onPressed: _showAddVariantOptionDialog,
            ),
          ],
        ),
        const SizedBox(height: 8),
        ..._variantOptions.entries.map((entry) => _buildOptionChips(entry.key)),
      ],
    );
  }

  Widget _buildOptionChips(String optionName) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Text(
              optionName,
              style: const TextStyle(fontWeight: FontWeight.w500),
            ),
            IconButton(
              icon: const Icon(Icons.delete_outline),
              onPressed: () => _removeOption(optionName),
            ),
          ],
        ),
        Wrap(
          spacing: 8,
          children: [
            ..._variantOptions[optionName]!.map(
              (value) => Chip(
                label: Text(value),
                onDeleted: () => _removeOptionValue(optionName, value),
              ),
            ),
            ActionChip(
              avatar: const Icon(Icons.add, size: 16),
              label: const Text('Add Value'),
              onPressed: () => _showAddOptionValueDialog(optionName),
            ),
          ],
        ),
        const Divider(),
      ],
    );
  }

  Widget _buildVariantList() {
    if (widget.product.variants.isEmpty) {
      return const Center(
        child: Text('No variants created yet'),
      );
    }

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Variants',
          style: TextStyle(
            fontSize: 16,
            fontWeight: FontWeight.w500,
          ),
        ),
        const SizedBox(height: 8),
        ListView.builder(
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          itemCount: widget.product.variants.length,
          itemBuilder: (context, index) {
            final variant = widget.product.variants[index];
            return _buildVariantTile(variant);
          },
        ),
      ],
    );
  }

  Widget _buildVariantTile(ProductVariant variant) {
    return ListTile(
      title: Text(variant.name),
      subtitle: Text(
        variant.attributes.entries
            .map((e) => '${e.key}: ${e.value}')
            .join(', '),
      ),
      trailing: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(
            '\$${variant.price.toStringAsFixed(2)}',
            style: const TextStyle(fontWeight: FontWeight.bold),
          ),
          const SizedBox(width: 16),
          IconButton(
            icon: const Icon(Icons.edit),
            onPressed: () => _showEditVariantDialog(variant),
          ),
        ],
      ),
    );
  }

  void _showAddVariantOptionDialog() {
    final controller = TextEditingController();
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Add Variant Option'),
        content: TextField(
          controller: controller,
          decoration: const InputDecoration(
            labelText: 'Option Name',
            hintText: 'e.g., Size, Color',
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () {
              if (controller.text.isNotEmpty) {
                setState(() {
                  _variantOptions[controller.text] = [];
                });
                Navigator.pop(context);
                _showAddOptionValueDialog(controller.text);
              }
            },
            child: const Text('Add'),
          ),
        ],
      ),
    );
  }

  void _showAddOptionValueDialog(String optionName) {
    final controller = TextEditingController();
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text('Add Value for $optionName'),
        content: TextField(
          controller: controller,
          decoration: const InputDecoration(
            labelText: 'Value',
            hintText: 'e.g., Small, Red',
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () {
              if (controller.text.isNotEmpty) {
                setState(() {
                  _variantOptions[optionName]!.add(controller.text);
                });
                _updateProductVariantOptions();
                Navigator.pop(context);
              }
            },
            child: const Text('Add'),
          ),
        ],
      ),
    );
  }

  void _showEditVariantDialog(ProductVariant variant) {
    final nameController = TextEditingController(text: variant.name);
    final priceController = TextEditingController(text: variant.price.toString());
    final stockController = TextEditingController(text: variant.stock.toString());
    final minStockController = TextEditingController(text: variant.minStock.toString());
    final skuController = TextEditingController(text: variant.sku ?? '');
    final barcodeController = TextEditingController(text: variant.barcode ?? '');

    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Edit Variant'),
        content: SingleChildScrollView(
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              TextField(
                controller: nameController,
                decoration: const InputDecoration(labelText: 'Name'),
              ),
              const SizedBox(height: 8),
              TextField(
                controller: priceController,
                decoration: const InputDecoration(labelText: 'Price'),
                keyboardType: const TextInputType.numberWithOptions(decimal: true),
              ),
              const SizedBox(height: 8),
              TextField(
                controller: stockController,
                decoration: const InputDecoration(labelText: 'Stock'),
                keyboardType: TextInputType.number,
              ),
              const SizedBox(height: 8),
              TextField(
                controller: minStockController,
                decoration: const InputDecoration(labelText: 'Minimum Stock'),
                keyboardType: TextInputType.number,
              ),
              const SizedBox(height: 8),
              TextField(
                controller: skuController,
                decoration: const InputDecoration(labelText: 'SKU'),
              ),
              const SizedBox(height: 8),
              TextField(
                controller: barcodeController,
                decoration: const InputDecoration(labelText: 'Barcode'),
              ),
              const SizedBox(height: 16),
              Text('Attributes:', style: Theme.of(context).textTheme.titleSmall),
              ...variant.attributes.entries.map(
                (entry) => Padding(
                  padding: const EdgeInsets.only(left: 16, top: 8),
                  child: Text('${entry.key}: ${entry.value}'),
                ),
              ),
            ],
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          TextButton(
            onPressed: () {
              final updatedVariant = ProductVariant(
                id: variant.id,
                productId: variant.productId,
                name: nameController.text,
                attributes: variant.attributes,
                price: double.tryParse(priceController.text) ?? variant.price,
                stock: int.tryParse(stockController.text) ?? variant.stock,
                minStock: int.tryParse(minStockController.text) ?? variant.minStock,
                sku: skuController.text.isEmpty ? null : skuController.text,
                barcode: barcodeController.text.isEmpty ? null : barcodeController.text,
                isActive: variant.isActive,
                createdAt: variant.createdAt,
                updatedAt: DateTime.now(),
              );

              final updatedVariants = widget.product.variants.map(
                (v) => v.id == variant.id ? updatedVariant : v,
              ).toList();

              final updatedProduct = widget.product.copyWith(
                variants: updatedVariants,
                updatedAt: DateTime.now(),
              );

              context.read<ProductBloc>().add(UpdateProductEvent(updatedProduct));

              Navigator.pop(context);
            },
            child: const Text('Save'),
          ),
        ],
      ),
    ).then((_) {
      // Dispose controllers
      nameController.dispose();
      priceController.dispose();
      stockController.dispose();
      minStockController.dispose();
      skuController.dispose();
      barcodeController.dispose();
    });
  }

  void _showDisableVariantsConfirmation() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Disable Variants'),
        content: const Text(
          'Are you sure you want to disable variants? This will delete all existing variants.',
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () {
              context.read<ProductBloc>().add(
                    UpdateProductEvent(
                      widget.product.copyWith(
                        hasVariants: false,
                        variants: [],
                        variantOptions: {},
                      ),
                    ),
                  );
              Navigator.pop(context);
            },
            style: ElevatedButton.styleFrom(
              backgroundColor: Colors.red,
            ),
            child: const Text('Disable'),
          ),
        ],
      ),
    );
  }

  void _removeOption(String optionName) {
    setState(() {
      _variantOptions.remove(optionName);
    });
    _updateProductVariantOptions();
  }

  void _removeOptionValue(String optionName, String value) {
    setState(() {
      _variantOptions[optionName]!.remove(value);
    });
    _updateProductVariantOptions();
  }

  void _updateProductVariantOptions() {
    context.read<ProductBloc>().add(
          UpdateProductEvent(
            widget.product.copyWith(
              variantOptions: _variantOptions,
            ),
          ),
        );
  }
}
