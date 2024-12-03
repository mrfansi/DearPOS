import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';

class BundleListPage extends StatefulWidget {
  const BundleListPage({Key? key}) : super(key: key);

  @override
  State<BundleListPage> createState() => _BundleListPageState();
}

class _BundleListPageState extends State<BundleListPage> {
  @override
  void initState() {
    super.initState();
    context.read<ProductBloc>().add(GetBundlesEvent());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Daftar Bundle Produk'),
        actions: [
          IconButton(
            icon: const Icon(Icons.add),
            onPressed: () {
              // Navigasi ke halaman tambah bundle
            },
          ),
        ],
      ),
      body: BlocBuilder<ProductBloc, ProductState>(
        builder: (context, state) {
          if (state is ProductLoading) {
            return const Center(child: CircularProgressIndicator());
          } else if (state is ProductLoaded) {
            final bundles = state.bundles;
            if (bundles.isEmpty) {
              return const Center(
                child: Text('Belum ada bundle produk'),
              );
            }
            return ListView.builder(
              itemCount: bundles.length,
              itemBuilder: (context, index) {
                final bundle = bundles[index];
                return _BundleListItem(bundle: bundle);
              },
            );
          } else if (state is ProductError) {
            return Center(child: Text(state.message));
          }
          return const SizedBox();
        },
      ),
    );
  }
}

class _BundleListItem extends StatelessWidget {
  final ProductBundle bundle;

  const _BundleListItem({
    Key? key,
    required this.bundle,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      child: ListTile(
        title: Text(bundle.name),
        subtitle: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('Rp ${bundle.bundlePrice}'),
            Text('${bundle.products.length} produk'),
          ],
        ),
        trailing: PopupMenuButton(
          itemBuilder: (context) => [
            const PopupMenuItem(
              value: 'edit',
              child: Text('Edit'),
            ),
            const PopupMenuItem(
              value: 'delete',
              child: Text('Hapus'),
            ),
          ],
          onSelected: (value) {
            switch (value) {
              case 'edit':
                // Navigasi ke halaman edit bundle
                break;
              case 'delete':
                showDialog(
                  context: context,
                  builder: (context) => AlertDialog(
                    title: const Text('Hapus Bundle'),
                    content: const Text(
                      'Apakah Anda yakin ingin menghapus bundle ini?',
                    ),
                    actions: [
                      TextButton(
                        onPressed: () => Navigator.pop(context),
                        child: const Text('Batal'),
                      ),
                      TextButton(
                        onPressed: () {
                          context
                              .read<ProductBloc>()
                              .add(DeleteBundleEvent(bundle.id));
                          Navigator.pop(context);
                        },
                        child: const Text('Hapus'),
                      ),
                    ],
                  ),
                );
                break;
            }
          },
        ),
        onTap: () {
          // Navigasi ke halaman detail bundle
        },
      ),
    );
  }
}
