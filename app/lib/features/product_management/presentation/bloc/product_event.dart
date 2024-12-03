part of 'product_bloc.dart';

abstract class ProductEvent extends Equatable {
  const ProductEvent();

  @override
  List<Object> get props => [];
}

class GetProductsEvent extends ProductEvent {}

class CreateProductEvent extends ProductEvent {
  final Product product;

  const CreateProductEvent(this.product);

  @override
  List<Object> get props => [product];
}

class UpdateProductEvent extends ProductEvent {
  final Product product;

  const UpdateProductEvent(this.product);

  @override
  List<Object> get props => [product];
}

class DeleteProductEvent extends ProductEvent {
  final String id;

  const DeleteProductEvent(this.id);

  @override
  List<Object> get props => [id];
}

class SearchProductEvent extends ProductEvent {
  final String query;

  const SearchProductEvent({required this.query});

  @override
  List<Object> get props => [query];
}

class GetProductsByCategoryEvent extends ProductEvent {
  final String categoryId;

  const GetProductsByCategoryEvent({required this.categoryId});

  @override
  List<Object> get props => [categoryId];
}

class BulkUploadProductsEvent extends ProductEvent {
  final String filePath;

  const BulkUploadProductsEvent({required this.filePath});

  @override
  List<Object> get props => [filePath];
}

class LoadProducts extends ProductEvent {
  @override
  List<Object> get props => [];
}

// New event for advanced filtering
class FilterProducts extends ProductEvent {
  final double? minPrice;
  final double? maxPrice;
  final int? minStock;
  final int? maxStock;
  final String? category;
  final bool lowStockOnly;
  final bool outOfStockOnly;
  final DateTime? expiryDateFrom;
  final DateTime? expiryDateTo;

  const FilterProducts({
    this.minPrice,
    this.maxPrice,
    this.minStock,
    this.maxStock,
    this.category,
    this.lowStockOnly = false,
    this.outOfStockOnly = false,
    this.expiryDateFrom,
    this.expiryDateTo,
  });

  @override
  List<Object> get props => [
        minPrice,
        maxPrice,
        minStock,
        maxStock,
        category,
        lowStockOnly,
        outOfStockOnly,
        expiryDateFrom,
        expiryDateTo,
      ];
}

class GetBundlesEvent extends ProductEvent {}

class CreateBundleEvent extends ProductEvent {
  final ProductBundle bundle;

  const CreateBundleEvent(this.bundle);

  @override
  List<Object> get props => [bundle];
}

class UpdateBundleEvent extends ProductEvent {
  final ProductBundle bundle;

  const UpdateBundleEvent(this.bundle);

  @override
  List<Object> get props => [bundle];
}

class DeleteBundleEvent extends ProductEvent {
  final String id;

  const DeleteBundleEvent(this.id);

  @override
  List<Object> get props => [id];
}
