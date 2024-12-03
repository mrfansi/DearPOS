part of 'product_bloc.dart';

abstract class ProductState extends Equatable {
  const ProductState();
  
  @override
  List<Object> get props => [];
}

class ProductInitial extends ProductState {}

class ProductLoading extends ProductState {}

class ProductLoaded extends ProductState {
  final List<Product> products;
  final List<ProductBundle> bundles;

  const ProductLoaded({
    required this.products,
    this.bundles = const [],
  });

  @override
  List<Object> get props => [products, bundles];
}

class ProductError extends ProductState {
  final String message;

  const ProductError(this.message);

  @override
  List<Object> get props => [message];
}

class ProductOperationSuccess extends ProductState {
  final String message;

  const ProductOperationSuccess(this.message);

  @override
  List<Object> get props => [message];
}

class BundleOperationSuccess extends ProductState {
  final String message;

  const BundleOperationSuccess(this.message);

  @override
  List<Object> get props => [message];
}

class ProductCreated extends ProductState {
  final Product product;

  const ProductCreated(this.product);

  @override
  List<Object> get props => [product];
}

class ProductUpdated extends ProductState {
  final Product product;

  const ProductUpdated(this.product);

  @override
  List<Object> get props => [product];
}

class ProductDeleted extends ProductState {
  final String id;

  const ProductDeleted(this.id);

  @override
  List<Object> get props => [id];
}

class ProductsSearched extends ProductState {
  final List<Product> products;

  const ProductsSearched(this.products);

  @override
  List<Object> get props => [products];
}

class ProductsByCategoryLoaded extends ProductState {
  final List<Product> products;

  const ProductsByCategoryLoaded(this.products);

  @override
  List<Object> get props => [products];
}

class ProductsBulkUploaded extends ProductState {
  final int count;

  const ProductsBulkUploaded(this.count);

  @override
  List<Object> get props => [count];
}
