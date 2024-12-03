import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';

class BundleManagementCard extends StatefulWidget {
  final Product product;

  const BundleManagementCard({
    Key? key,
    required this.product,
  }) : super(key: key);

  @override
  State<BundleManagementCard> createState() => _BundleManagementCardState();
}

class _BundleManagementCardState extends State<BundleManagementCard> {
  final _bundleNameController = TextEditingController();
  final _bundlePriceController = TextEditingController();
  final List<Product> _selectedProducts = [];

  @override
  void dispose() {
    _bundleNameController.dispose();
    _bundlePriceController.dispose();
    super.dispose();
  }

  void _createBundle() {
    if (_bundleNameController.text.isEmpty ||
        _bundlePriceController.text.isEmpty ||
        _selectedProducts.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Mohon lengkapi semua field')),
      );
      return;
    }

    final bundle = ProductBundle(
      id: DateTime.now().toString(),
      name: _bundleNameController.text,
      bundlePrice: double.parse(_bundlePriceController.text),
      products: _selectedProducts,
      createdAt: DateTime.now(),
      updatedAt: DateTime.now(),
    );

    context.read<ProductBloc>().add(CreateBundleEvent(bundle));
  }

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Manajemen Bundle',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 16),
            TextField(
              controller: _bundleNameController,
              decoration: const InputDecoration(
                labelText: 'Nama Bundle',
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height: 16),
            TextField(
              controller: _bundlePriceController,
              keyboardType: TextInputType.number,
              decoration: const InputDecoration(
                labelText: 'Harga Bundle',
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height: 16),
            const Text(
              'Produk dalam Bundle:',
              style: TextStyle(fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 8),
            Wrap(
              spacing: 8,
              children: _selectedProducts
                  .map(
                    (product) => Chip(
                      label: Text(product.name),
                      onDeleted: () {
                        setState(() {
                          _selectedProducts.remove(product);
                        });
                      },
                    ),
                  )
                  .toList(),
            ),
            const SizedBox(height: 16),
            ElevatedButton.icon(
              onPressed: () {
                // Tampilkan dialog untuk memilih produk
                showDialog(
                  context: context,
                  builder: (context) => _ProductSelectionDialog(
                    onProductSelected: (product) {
                      if (!_selectedProducts.contains(product)) {
                        setState(() {
                          _selectedProducts.add(product);
                        });
                      }
                    },
                  ),
                );
              },
              icon: const Icon(Icons.add),
              label: const Text('Tambah Produk ke Bundle'),
            ),
            const SizedBox(height: 16),
            ElevatedButton(
              onPressed: _createBundle,
              child: const Text('Buat Bundle'),
            ),
          ],
        ),
      ),
    );
  }
}

class _ProductSelectionDialog extends StatelessWidget {
  final Function(Product) onProductSelected;

  const _ProductSelectionDialog({
    Key? key,
    required this.onProductSelected,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title: const Text('Pilih Produk'),
      content: BlocBuilder<ProductBloc, ProductState>(
        builder: (context, state) {
          if (state is ProductLoading) {
            return const CircularProgressIndicator();
          } else if (state is ProductLoaded) {
            return SizedBox(
              width: double.maxFinite,
              child: ListView.builder(
                shrinkWrap: true,
                itemCount: state.products.length,
                itemBuilder: (context, index) {
                  final product = state.products[index];
                  return ListTile(
                    title: Text(product.name),
                    subtitle: Text('Rp ${product.price}'),
                    onTap: () {
                      onProductSelected(product);
                      Navigator.pop(context);
                    },
                  );
                },
              ),
            );
          } else {
            return const Text('Gagal memuat produk');
          }
        },
      ),
      actions: [
        TextButton(
          onPressed: () => Navigator.pop(context),
          child: const Text('Tutup'),
        ),
      ],
    );
  }
}
