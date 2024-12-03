import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';
import 'package:app/features/product_management/presentation/widgets/product_form.dart';
import 'package:app/features/product_management/presentation/widgets/stock_management_card.dart';
import 'package:app/features/product_management/presentation/widgets/variant_management_card.dart';
import 'package:app/features/product_management/presentation/widgets/barcode_management_card.dart';
import 'package:app/features/product_management/presentation/widgets/bundle_management_card.dart';

class ProductDetailPage extends StatefulWidget {
  final Product? product;
  final bool isEditing;

  const ProductDetailPage({
    super.key,
    this.product,
    this.isEditing = false,
  });

  @override
  State<ProductDetailPage> createState() => _ProductDetailPageState();
}

class _ProductDetailPageState extends State<ProductDetailPage> {
  @override
  Widget build(BuildContext context) {
    return BlocBuilder<ProductBloc, ProductState>(
      builder: (context, state) {
        if (state is ProductLoading) {
          return const Center(child: CircularProgressIndicator());
        }

        return Scaffold(
          appBar: AppBar(
            title: Text(widget.isEditing ? 'Edit Product' : 'Add Product'),
            actions: widget.isEditing
                ? [
                    IconButton(
                      icon: const Icon(Icons.delete),
                      onPressed: () => _showDeleteConfirmation(context),
                    ),
                  ]
                : null,
          ),
          body: SingleChildScrollView(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                ProductForm(
                  product: widget.product,
                  isEditing: widget.isEditing,
                  onSubmit: (Product product) {
                    if (widget.isEditing && widget.product != null) {
                      context
                          .read<ProductBloc>()
                          .add(UpdateProductEvent(widget.product!));
                    } else {
                      context
                          .read<ProductBloc>()
                          .add(CreateProductEvent(product));
                    }

                    Navigator.pop(context);
                  },
                ),
                if (widget.isEditing) ...[
                  const SizedBox(height: 16),
                  StockManagementCard(product: widget.product!),
                  const SizedBox(height: 16),
                  VariantManagementCard(product: widget.product!),
                  const SizedBox(height: 16),
                  BarcodeManagementCard(product: widget.product!),
                  const SizedBox(height: 16),
                  BundleManagementCard(product: widget.product!),
                ],
              ],
            ),
          ),
        );
      },
    );
  }

  void _showDeleteConfirmation(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Delete Product'),
        content: const Text('Are you sure you want to delete this product?'),
        actions: [
          TextButton(
            child: const Text('Cancel'),
            onPressed: () => Navigator.pop(context),
          ),
          TextButton(
            child: const Text('Delete'),
            onPressed: () {
              context.read<ProductBloc>().add(
                    DeleteProductEvent(widget.product!.id),
                  );
              Navigator.pop(context); // Close dialog
              Navigator.pop(context); // Return to list
            },
          ),
        ],
      ),
    );
  }
}
