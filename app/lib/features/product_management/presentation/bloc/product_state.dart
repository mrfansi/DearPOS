part of 'product_bloc.dart';

@immutable
abstract class ProductState extends Equatable {
  const ProductState();

  @override
  List<Object?> get props => [];
}

class ProductInitial extends ProductState {
  const ProductInitial();
}

class ProductLoading extends ProductState {
  const ProductLoading();
}

class ProductError extends ProductState {
  final String message;

  const ProductError({required this.message});

  @override
  List<Object?> get props => [message];
}

class ProductsLoadSuccess extends ProductState {
  final List<Product> products;
  final bool hasReachedMax;

  const ProductsLoadSuccess({
    required this.products,
    this.hasReachedMax = false,
  });

  @override
  List<Object?> get props => [products, hasReachedMax];

  ProductsLoadSuccess copyWith({
    List<Product>? products,
    bool? hasReachedMax,
  }) {
    return ProductsLoadSuccess(
      products: products ?? this.products,
      hasReachedMax: hasReachedMax ?? this.hasReachedMax,
    );
  }
}

class ProductLoadSuccess extends ProductState {
  final Product product;

  const ProductLoadSuccess({required this.product});

  @override
  List<Object?> get props => [product];
}

class ProductOperationSuccess extends ProductState {
  final Product? product;
  final String message;

  const ProductOperationSuccess({
    this.product,
    required this.message,
  });

  @override
  List<Object?> get props => [product, message];
}

class BundlesLoadSuccess extends ProductState {
  final List<ProductBundle> bundles;
  final bool hasReachedMax;

  const BundlesLoadSuccess({
    required this.bundles,
    this.hasReachedMax = false,
  });

  @override
  List<Object?> get props => [bundles, hasReachedMax];

  BundlesLoadSuccess copyWith({
    List<ProductBundle>? bundles,
    bool? hasReachedMax,
  }) {
    return BundlesLoadSuccess(
      bundles: bundles ?? this.bundles,
      hasReachedMax: hasReachedMax ?? this.hasReachedMax,
    );
  }
}

class BundleLoadSuccess extends ProductState {
  final ProductBundle bundle;

  const BundleLoadSuccess({required this.bundle});

  @override
  List<Object?> get props => [bundle];
}

class BundleOperationSuccess extends ProductState {
  final ProductBundle? bundle;
  final String message;

  const BundleOperationSuccess({
    this.bundle,
    required this.message,
  });

  @override
  List<Object?> get props => [bundle, message];
}
