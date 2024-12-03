import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';
import 'package:app/features/product_management/presentation/pages/bundle_form_page.dart';

class BundleListPage extends StatefulWidget {
  const BundleListPage({super.key});

  @override
  State<BundleListPage> createState() => _BundleListPageState();
}

class _BundleListPageState extends State<BundleListPage> {
  final ScrollController _scrollController = ScrollController();
  bool _isLoading = false;
  static const _itemsPerPage = 20;

  @override
  void initState() {
    super.initState();
    _loadBundles();
    _scrollController.addListener(_onScroll);
  }

  @override
  void dispose() {
    _scrollController.dispose();
    super.dispose();
  }

  void _loadBundles() {
    if (!_isLoading) {
      setState(() => _isLoading = true);
      context.read<ProductBloc>().add(
            const GetBundlesEvent(
              offset: 0,
              limit: _itemsPerPage,
            ),
          );
    }
  }

  void _onScroll() {
    if (_scrollController.position.pixels >=
            _scrollController.position.maxScrollExtent * 0.8 &&
        !_isLoading) {
      final state = context.read<ProductBloc>().state;
      if (state is BundlesLoadSuccess) {
        setState(() => _isLoading = true);
        context.read<ProductBloc>().add(
              GetBundlesEvent(
                offset: state.bundles.length,
                limit: _itemsPerPage,
              ),
            );
      }
    }
  }

  void _onEditBundle(ProductBundle bundle) async {
    final result = await Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => BundleFormPage(bundle: bundle),
      ),
    );
    if (result == true && mounted) {
      context.read<ProductBloc>().add(const GetBundlesEvent());
    }
  }

  void _onDeleteBundle(ProductBundle bundle) {
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
              context.read<ProductBloc>().add(DeleteBundleEvent(
                    bundleId: bundle.id,
                    bundle: bundle,
                  ));
              Navigator.pop(context);
            },
            child: const Text('Hapus'),
          ),
        ],
      ),
    );
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
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => const BundleFormPage(),
                ),
              );
            },
          ),
        ],
      ),
      body: BlocConsumer<ProductBloc, ProductState>(
        listener: (context, state) {
          if (state is BundlesLoadSuccess || state is ProductError) {
            setState(() => _isLoading = false);
          }
          if (state is ProductError) {
            ScaffoldMessenger.of(context).showSnackBar(
              SnackBar(content: Text(state.message)),
            );
          }
          if (state is BundleOperationSuccess) {
            _loadBundles(); // Reload the list after successful operation
          }
        },
        builder: (context, state) {
          if (state is ProductInitial ||
              (state is ProductLoading && !_isLoading)) {
            return const Center(child: CircularProgressIndicator());
          }

          if (state is BundlesLoadSuccess) {
            final bundles = state.bundles;
            if (bundles.isEmpty) {
              return const Center(
                child: Text('Belum ada bundle produk'),
              );
            }
            return ListView.builder(
              controller: _scrollController,
              itemCount: bundles.length + (_isLoading ? 1 : 0),
              itemBuilder: (context, index) {
                if (index == bundles.length) {
                  return const Center(
                    child: Padding(
                      padding: EdgeInsets.all(8.0),
                      child: CircularProgressIndicator(),
                    ),
                  );
                }
                final bundle = bundles[index];
                return _BundleListItem(
                  bundle: bundle,
                  onEdit: () => _onEditBundle(bundle),
                  onDelete: () => _onDeleteBundle(bundle),
                );
              },
            );
          }

          if (state is ProductError && !_isLoading) {
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
  final VoidCallback onEdit;
  final VoidCallback onDelete;

  const _BundleListItem({
    required this.bundle,
    required this.onEdit,
    required this.onDelete,
  });

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
            if (bundle.description.isNotEmpty)
              Text(
                bundle.description,
                maxLines: 2,
                overflow: TextOverflow.ellipsis,
              ),
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
                onEdit();
                break;
              case 'delete':
                onDelete();
                break;
            }
          },
        ),
      ),
    );
  }
}
