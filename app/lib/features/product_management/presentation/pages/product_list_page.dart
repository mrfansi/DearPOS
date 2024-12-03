import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';
import 'package:app/features/product_management/presentation/widgets/product_search_bar.dart';
import 'package:app/features/product_management/presentation/widgets/product_filter.dart';
import 'package:app/features/product_management/presentation/widgets/bulk_upload_dialog.dart';
import 'package:app/features/product_management/presentation/widgets/product_list_item.dart';
import 'package:app/features/product_management/presentation/widgets/product_filter_dialog.dart';
import 'product_detail_page.dart';

class ProductListPage extends StatelessWidget {
  const ProductListPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Products'),
        actions: [
          IconButton(
            icon: const Icon(Icons.upload_file),
            onPressed: () {
              showDialog(
                context: context,
                builder: (context) => const BulkUploadDialog(),
              );
            },
          ),
          IconButton(
            icon: const Icon(Icons.filter_list),
            onPressed: () {
              showDialog(
                context: context,
                builder: (context) => const ProductFilterDialog(),
              );
            },
          ),
          IconButton(
            icon: const Icon(Icons.add),
            onPressed: () => _navigateToAddProduct(context),
          ),
        ],
      ),
      body: Column(
        children: [
          const ProductSearchBar(),
          const ProductFilter(),
          Expanded(
            child: BlocBuilder<ProductBloc, ProductState>(
              builder: (context, state) {
                if (state is ProductInitial) {
                  context.read<ProductBloc>().add(const GetProductsEvent());
                  return const Center(child: CircularProgressIndicator());
                }
                if (state is ProductLoading) {
                  return const Center(child: CircularProgressIndicator());
                }
                if (state is ProductsLoadSuccess) {
                  return ListView.builder(
                    itemCount: state.products.length,
                    itemBuilder: (context, index) {
                      final product = state.products[index];
                      return ProductListItem(
                        product: product,
                        onTap: () => _navigateToProductDetail(context, product),
                      );
                    },
                  );
                }
                if (state is ProductError) {
                  return Center(child: Text(state.message));
                }
                return const SizedBox();
              },
            ),
          ),
        ],
      ),
    );
  }

  void _navigateToAddProduct(BuildContext context) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => const ProductDetailPage(isEditing: false),
      ),
    );
  }

  void _navigateToProductDetail(BuildContext context, Product product) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => ProductDetailPage(
          isEditing: true,
          product: product,
        ),
      ),
    );
  }
}
