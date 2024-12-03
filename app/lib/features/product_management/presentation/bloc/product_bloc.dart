import 'dart:io';

import 'package:bloc/bloc.dart';
import 'package:equatable/equatable.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:app/core/error/failures.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/domain/usecases/bulk_upload_products.dart';
import 'package:app/features/product_management/domain/usecases/create_bundle.dart';
import 'package:app/features/product_management/domain/usecases/create_product.dart';
import 'package:app/features/product_management/domain/usecases/delete_bundle.dart';
import 'package:app/features/product_management/domain/usecases/delete_product.dart';
import 'package:app/features/product_management/domain/usecases/get_bundle.dart' as get_bundle_usecase;
import 'package:app/features/product_management/domain/usecases/get_bundles.dart';
import 'package:app/features/product_management/domain/usecases/get_products.dart';
import 'package:app/features/product_management/domain/usecases/get_products_by_category.dart';
import 'package:app/features/product_management/domain/usecases/search_products.dart';
import 'package:app/features/product_management/domain/usecases/update_bundle.dart';
import 'package:app/features/product_management/domain/usecases/update_product.dart';
import 'package:app/features/product_management/domain/usecases/bundle_params.dart';

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
  final CreateBundle createBundle;
  final UpdateBundle updateBundle;
  final DeleteBundle deleteBundle;
  final get_bundle_usecase.GetBundle getBundle;
  final GetBundles getBundles;

  ProductBloc({
    required this.getProducts,
    required this.createProduct,
    required this.updateProduct,
    required this.deleteProduct,
    required this.searchProducts,
    required this.getProductsByCategory,
    required this.bulkUploadProducts,
    required this.createBundle,
    required this.updateBundle,
    required this.deleteBundle,
    required this.getBundle,
    required this.getBundles,
  }) : super(const ProductInitial()) {
    on<GetProductsEvent>(_onGetProducts);
    on<CreateProductEvent>(_onCreateProduct);
    on<UpdateProductEvent>(_onUpdateProduct);
    on<DeleteProductEvent>(_onDeleteProduct);
    on<SearchProductEvent>(_onSearchProducts);
    on<GetProductsByCategoryEvent>(_onGetProductsByCategory);
    on<BulkUploadProductsEvent>(_onBulkUploadProducts);
    on<CreateBundleEvent>(_onCreateBundle);
    on<UpdateBundleEvent>(_onUpdateBundle);
    on<DeleteBundleEvent>(_onDeleteBundle);
    on<GetBundlesEvent>(_onGetBundles);
    on<GetBundleEvent>(_onGetBundle);
    on<FilterProductsEvent>(_onFilterProducts);
  }

  Future<void> _onCreateBundle(
      CreateBundleEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final params = CreateBundleParams(
        name: event.bundle.name,
        description: event.bundle.description,
        bundlePrice: event.bundle.bundlePrice,
        productIds: event.bundle.products.map((p) => p.id).toList(),
      );
      
      final result = await createBundle(params);
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (bundle) => emit(BundleOperationSuccess(
          message: 'Bundle created successfully',
          bundle: bundle,
        )),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onUpdateBundle(
      UpdateBundleEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final params = UpdateBundleParams(
        id: event.bundle.id,
        name: event.bundle.name,
        description: event.bundle.description,
        bundlePrice: event.bundle.bundlePrice,
        productIds: event.bundle.products.map((p) => p.id).toList(),
        isActive: event.bundle.isActive,
      );
      
      final result = await updateBundle(params);
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (bundle) => emit(BundleOperationSuccess(
          message: 'Bundle updated successfully',
          bundle: bundle,
        )),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onDeleteBundle(
      DeleteBundleEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final result = await deleteBundle(DeleteBundleParams(id: event.bundleId));
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (_) => emit(BundleOperationSuccess(
          message: 'Bundle deleted successfully',
          bundle: event.bundle,
        )),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onGetBundles(
      GetBundlesEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final params = GetBundlesParams(
        limit: event.limit,
        offset: event.offset,
        isActive: event.isActive,
      );
      
      final result = await getBundles(params);
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (bundles) => emit(BundlesLoadSuccess(
          bundles: bundles,
          hasReachedMax: bundles.length < (event.limit ?? 10),
        )),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onGetBundle(
      GetBundleEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final result = await getBundle(get_bundle_usecase.GetBundleParams(id: event.bundleId));
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (bundle) => emit(BundleLoadSuccess(bundle: bundle)),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onGetProducts(
      GetProductsEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final result = await getProducts(NoParams());
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (products) => emit(ProductsLoadSuccess(products: products)),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onCreateProduct(
      CreateProductEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final params = CreateProductParams(product: event.product);
      final result = await createProduct(params);
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (product) => emit(ProductOperationSuccess(
          message: 'Product created successfully',
          product: product,
        )),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onUpdateProduct(
      UpdateProductEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final params = UpdateProductParams(product: event.product);
      final result = await updateProduct(params);
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (product) => emit(ProductOperationSuccess(
          message: 'Product updated successfully',
          product: product,
        )),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onDeleteProduct(
      DeleteProductEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final params = DeleteProductParams(id: event.productId);
      final result = await deleteProduct(params);
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (_) => emit(ProductOperationSuccess(
          message: 'Product deleted successfully',
          product: event.product,
        )),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onSearchProducts(
      SearchProductEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final params = SearchProductsParams(query: event.query);
      final result = await searchProducts(params);
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (products) => emit(ProductsLoadSuccess(products: products)),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onGetProductsByCategory(
      GetProductsByCategoryEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final params = GetProductsByCategoryParams(category: event.categoryId);
      final result = await getProductsByCategory(params);
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (products) => emit(ProductsLoadSuccess(products: products)),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onBulkUploadProducts(
      BulkUploadProductsEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final file = File(event.filePath);
      final result = await bulkUploadProducts(file);
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (_) => emit(const ProductOperationSuccess(
          message: 'Products uploaded successfully',
          product: null,
        )),
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  Future<void> _onFilterProducts(
      FilterProductsEvent event, Emitter<ProductState> emit) async {
    try {
      emit(const ProductLoading());
      final params = SearchProductsParams(
        query: '',
      );

      final result = await searchProducts(params);
      
      result.fold(
        (failure) => emit(ProductError(message: _mapFailureToMessage(failure))),
        (products) {
          final filteredProducts = products.where((product) {
            bool matchesCategory = event.categoryId == null ||
                product.categoryId == event.categoryId;
            bool matchesPrice = event.minPrice == null ||
                event.maxPrice == null ||
                (product.price >= event.minPrice! &&
                    product.price <= event.maxPrice!);
            bool matchesActive =
                event.isActive == null || product.isActive == event.isActive;

            return matchesCategory && matchesPrice && matchesActive;
          }).toList();

          emit(ProductsLoadSuccess(products: filteredProducts));
        },
      );
    } catch (e) {
      emit(ProductError(message: e.toString()));
    }
  }

  String _mapFailureToMessage(Failure failure) {
    switch (failure) {
      case ServerFailure serverFailure:
        return serverFailure.message ?? 'Server failure';
      case CacheFailure cacheFailure:
        return cacheFailure.message ?? 'Cache failure';
      default:
        return 'Unexpected error';
    }
  }
}
