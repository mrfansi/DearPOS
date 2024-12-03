import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';

class BundleFormPage extends StatefulWidget {
  final ProductBundle? bundle;

  const BundleFormPage({
    super.key,
    this.bundle,
  });

  @override
  State<BundleFormPage> createState() => _BundleFormPageState();
}

class _BundleFormPageState extends State<BundleFormPage> {
  final _formKey = GlobalKey<FormState>();
  final _nameController = TextEditingController();
  final _descriptionController = TextEditingController();
  final _priceController = TextEditingController();
  final List<Product> _selectedProducts = [];

  @override
  void initState() {
    super.initState();
    if (widget.bundle != null) {
      _nameController.text = widget.bundle!.name;
      _descriptionController.text = widget.bundle!.description;
      _priceController.text = widget.bundle!.bundlePrice.toString();
      _selectedProducts.addAll(widget.bundle!.products);
    }
  }

  @override
  void dispose() {
    _nameController.dispose();
    _descriptionController.dispose();
    _priceController.dispose();
    super.dispose();
  }

  void _submitForm() {
    if (!_formKey.currentState!.validate()) return;

    final bundle = ProductBundle(
      id: widget.bundle?.id ?? DateTime.now().toString(),
      name: _nameController.text,
      description: _descriptionController.text,
      bundlePrice: double.parse(_priceController.text),
      products: _selectedProducts,
      createdAt: widget.bundle?.createdAt ?? DateTime.now(),
      updatedAt: DateTime.now(),
      isActive: widget.bundle?.isActive ?? true,
    );

    try {
      bundle.validate();
      if (widget.bundle == null) {
        context.read<ProductBloc>().add(CreateBundleEvent(bundle));
      } else {
        context.read<ProductBloc>().add(UpdateBundleEvent(bundle));
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(e.toString())),
      );
      return;
    }

    Navigator.pop(context);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(widget.bundle == null ? 'Tambah Bundle' : 'Edit Bundle'),
      ),
      body: BlocListener<ProductBloc, ProductState>(
        listener: (context, state) {
          if (state is BundleOperationSuccess) {
            ScaffoldMessenger.of(context).showSnackBar(
              SnackBar(content: Text(state.message)),
            );
            Navigator.pop(context);
          } else if (state is ProductError) {
            ScaffoldMessenger.of(context).showSnackBar(
              SnackBar(content: Text(state.message)),
            );
          }
        },
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16.0),
          child: Form(
            key: _formKey,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                TextFormField(
                  controller: _nameController,
                  decoration: const InputDecoration(
                    labelText: 'Nama Bundle',
                    border: OutlineInputBorder(),
                  ),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Nama bundle tidak boleh kosong';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16),
                TextFormField(
                  controller: _descriptionController,
                  decoration: const InputDecoration(
                    labelText: 'Deskripsi',
                    border: OutlineInputBorder(),
                  ),
                  maxLines: 3,
                ),
                const SizedBox(height: 16),
                TextFormField(
                  controller: _priceController,
                  decoration: const InputDecoration(
                    labelText: 'Harga Bundle',
                    border: OutlineInputBorder(),
                    prefixText: 'Rp ',
                  ),
                  keyboardType: TextInputType.number,
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Harga bundle tidak boleh kosong';
                    }
                    if (double.tryParse(value) == null) {
                      return 'Harga harus berupa angka';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 24),
                Text(
                  'Produk dalam Bundle',
                  style: Theme.of(context).textTheme.titleMedium,
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
                    showDialog(
                      context: context,
                      builder: (context) => _ProductSelectionDialog(
                        bundle: widget.bundle,
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
                const SizedBox(height: 24),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                    onPressed: _submitForm,
                    child: Text(
                      widget.bundle == null
                          ? 'Buat Bundle'
                          : 'Simpan Perubahan',
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}

class _ProductSelectionDialog extends StatelessWidget {
  final ProductBundle? bundle;
  final Function(Product) onProductSelected;

  const _ProductSelectionDialog({
    required this.bundle,
    required this.onProductSelected,
  });

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
