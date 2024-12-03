import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:app/features/product_management/domain/usecases/get_products.dart';
import 'package:app/features/product_management/domain/usecases/create_product.dart';
import 'package:app/features/product_management/domain/usecases/update_product.dart';
import 'package:app/features/product_management/domain/usecases/delete_product.dart';
import 'package:app/features/product_management/domain/usecases/search_products.dart';
import 'package:app/features/product_management/domain/usecases/get_products_by_category.dart';
import 'package:app/features/product_management/domain/usecases/bulk_upload_products.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:equatable/equatable.dart';
import 'dart:io';

part 'product_event.dart';
part 'product_state.dart';

class ProductBloc extends Bloc<ProductEvent, ProductState> {
  final GetProducts getProducts;
  final CreateProduct createProduct;
  final UpdateProduct updateProduct;
  final DeleteProduct deleteProduct;
  final SearchProducts searchProducts;
  final GetProductsByCategory getProductsByCategory;
  final BulkUploadProducts bulkUploadProducts;
  final GetBundles getBundles;
  final CreateBundle createBundle;
  final UpdateBundle updateBundle;
  final DeleteBundle deleteBundle;

  ProductBloc({
    required this.getProducts,
    required this.createProduct,
    required this.updateProduct,
    required this.deleteProduct,
    required this.searchProducts,
    required this.getProductsByCategory,
    required this.bulkUploadProducts,
    required this.getBundles,
    required this.createBundle,
    required this.updateBundle,
    required this.deleteBundle,
  }) : super(ProductInitial()) {
    on<GetProductsEvent>(_onGetProducts);
    on<CreateProductEvent>(_onCreateProduct);
    on<UpdateProductEvent>(_onUpdateProduct);
    on<DeleteProductEvent>(_onDeleteProduct);
    on<SearchProductEvent>(_onSearchProducts);
    on<GetProductsByCategoryEvent>(_onGetProductsByCategory);
    on<BulkUploadProductsEvent>(_onBulkUploadProducts);
    on<FilterProducts>(_onFilterProducts);
    on<GetBundlesEvent>(_onGetBundles);
    on<CreateBundleEvent>(_onCreateBundle);
    on<UpdateBundleEvent>(_onUpdateBundle);
    on<DeleteBundleEvent>(_onDeleteBundle);
  }

  Future<void> _onGetProducts(
      GetProductsEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final result = await getProducts(NoParams());
    result.fold(
      (failure) => emit(ProductError(failure.toString())),
      (products) => emit(ProductsLoaded(products)),
    );
  }

  Future<void> _onCreateProduct(
      CreateProductEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final result =
        await createProduct(CreateProductParams(product: event.product));
    result.fold(
      (failure) => emit(ProductError(failure.toString())),
      (product) => emit(ProductCreated(product)),
    );
  }

  Future<void> _onUpdateProduct(
      UpdateProductEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final result =
        await updateProduct(UpdateProductParams(product: event.product));
    result.fold(
      (failure) => emit(ProductError(failure.toString())),
      (product) => emit(ProductUpdated(product)),
    );
  }

  Future<void> _onDeleteProduct(
      DeleteProductEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final result = await deleteProduct(DeleteProductParams(id: event.id));
    result.fold(
      (failure) => emit(ProductError(failure.toString())),
      (success) => emit(ProductDeleted(event.id)),
    );
  }

  Future<void> _onSearchProducts(
      SearchProductEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final result =
        await searchProducts(SearchProductsParams(query: event.query));
    result.fold(
      (failure) => emit(ProductError(failure.toString())),
      (products) => emit(ProductsSearched(products)),
    );
  }

  Future<void> _onGetProductsByCategory(
      GetProductsByCategoryEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final result = await getProductsByCategory(
        GetProductsByCategoryParams(category: event.categoryId));
    result.fold(
      (failure) => emit(ProductError(failure.toString())),
      (products) => emit(ProductsByCategoryLoaded(products)),
    );
  }

  Future<void> _onBulkUploadProducts(
      BulkUploadProductsEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final file = File(event.filePath);
    final result = await bulkUploadProducts(file);
    result.fold(
      (failure) => emit(ProductError(failure.toString())),
      (_) => emit(const ProductsBulkUploaded(
          0)), // Anda mungkin ingin menghitung jumlah produk yang diunggah
    );
  }

  void _onFilterProducts(
      FilterProducts event, Emitter<ProductState> emit) async {
    try {
      emit(ProductLoading());

      // Fetch all products first
      final result = await getProducts(NoParams());

      result.fold(
        (failure) => emit(ProductError(failure.toString())),
        (allProducts) {
          // Apply filters
          final filteredProducts = allProducts.where((product) {
            // Price filter
            if (event.minPrice != null && product.price < event.minPrice!) {
              return false;
            }
            if (event.maxPrice != null && product.price > event.maxPrice!) {
              return false;
            }

            // Stock filter
            if (event.minStock != null && product.stock < event.minStock!) {
              return false;
            }
            if (event.maxStock != null && product.stock > event.maxStock!) {
              return false;
            }

            // Category filter
            if (event.category != null && product.category != event.category) {
              return false;
            }

            // Low stock filter
            if (event.lowStockOnly && product.stock > 20) {
              return false; // Assuming low stock is <= 20
            }

            // Out of stock filter
            if (event.outOfStockOnly && product.stock > 0) {
              return false;
            }

            // Expiry date filter
            if (event.expiryDateFrom != null &&
                (product.expiryDate == null ||
                    product.expiryDate!.isBefore(event.expiryDateFrom!))) {
              return false;
            }

            if (event.expiryDateTo != null &&
                (product.expiryDate == null ||
                    product.expiryDate!.isAfter(event.expiryDateTo!))) {
              return false;
            }

            return true;
          }).toList();

          emit(ProductsLoaded(filteredProducts));
        },
      );
    } catch (e) {
      emit(ProductError('Gagal memfilter produk: ${e.toString()}'));
    }
  }

  void _onGetBundles(GetBundlesEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final result = await getBundles(NoParams());
    result.fold(
      (failure) => emit(ProductError('Gagal memuat bundle produk')),
      (bundles) => emit(ProductLoaded(products: const [], bundles: bundles)),
    );
  }

  void _onCreateBundle(CreateBundleEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final result = await createBundle(CreateBundleParams(bundle: event.bundle));
    result.fold(
      (failure) => emit(ProductError('Gagal membuat bundle produk')),
      (bundle) => emit(BundleOperationSuccess('Bundle berhasil dibuat')),
    );
  }

  void _onUpdateBundle(UpdateBundleEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final result = await updateBundle(UpdateBundleParams(bundle: event.bundle));
    result.fold(
      (failure) => emit(ProductError('Gagal mengupdate bundle produk')),
      (bundle) => emit(BundleOperationSuccess('Bundle berhasil diupdate')),
    );
  }

  void _onDeleteBundle(DeleteBundleEvent event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    final result = await deleteBundle(DeleteBundleParams(id: event.id));
    result.fold(
      (failure) => emit(ProductError('Gagal menghapus bundle produk')),
      (success) => emit(BundleOperationSuccess('Bundle berhasil dihapus')),
    );
  }
}
