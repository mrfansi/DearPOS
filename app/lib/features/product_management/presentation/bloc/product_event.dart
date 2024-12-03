part of 'product_bloc.dart';

@immutable
abstract class ProductEvent extends Equatable {
  const ProductEvent();

  @override
  List<Object?> get props => [];
}

class GetProductsEvent extends ProductEvent {
  const GetProductsEvent();
}

class CreateProductEvent extends ProductEvent {
  final Product product;

  const CreateProductEvent(this.product);

  @override
  List<Object?> get props => [product];
}

class UpdateProductEvent extends ProductEvent {
  final Product product;

  const UpdateProductEvent(this.product);

  @override
  List<Object?> get props => [product];
}

class DeleteProductEvent extends ProductEvent {
  final String productId;
  final Product product;

  const DeleteProductEvent({
    required this.productId,
    required this.product,
  });

  @override
  List<Object?> get props => [productId, product];
}

class SearchProductEvent extends ProductEvent {
  final String query;

  const SearchProductEvent(this.query);

  @override
  List<Object?> get props => [query];
}

class GetProductsByCategoryEvent extends ProductEvent {
  final String categoryId;
  final int? limit;
  final int? offset;

  const GetProductsByCategoryEvent({
    required this.categoryId,
    this.limit,
    this.offset,
  });

  @override
  List<Object?> get props => [categoryId, limit, offset];
}

class BulkUploadProductsEvent extends ProductEvent {
  final String filePath;

  const BulkUploadProductsEvent(this.filePath);

  @override
  List<Object?> get props => [filePath];
}

class FilterProductsEvent extends ProductEvent {
  final String? categoryId;
  final double? minPrice;
  final double? maxPrice;
  final bool? isActive;

  const FilterProductsEvent({
    this.categoryId,
    this.minPrice,
    this.maxPrice,
    this.isActive,
  });

  @override
  List<Object?> get props => [categoryId, minPrice, maxPrice, isActive];
}

class CreateBundleEvent extends ProductEvent {
  final ProductBundle bundle;

  const CreateBundleEvent(this.bundle);

  @override
  List<Object?> get props => [bundle];
}

class UpdateBundleEvent extends ProductEvent {
  final ProductBundle bundle;

  const UpdateBundleEvent(this.bundle);

  @override
  List<Object?> get props => [bundle];
}

class DeleteBundleEvent extends ProductEvent {
  final String bundleId;
  final ProductBundle bundle;

  const DeleteBundleEvent({
    required this.bundleId,
    required this.bundle,
  });

  @override
  List<Object?> get props => [bundleId, bundle];
}

class GetBundleEvent extends ProductEvent {
  final String bundleId;

  const GetBundleEvent(this.bundleId);

  @override
  List<Object?> get props => [bundleId];
}

class GetBundlesEvent extends ProductEvent {
  final int? limit;
  final int? offset;
  final bool? isActive;

  const GetBundlesEvent({
    this.limit,
    this.offset,
    this.isActive,
  });

  @override
  List<Object?> get props => [limit, offset, isActive];
}
