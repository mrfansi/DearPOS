import 'package:equatable/equatable.dart';
import 'package:meta/meta.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';

@immutable
class ProductParams extends Equatable {
  final String? id;
  final Product? product;
  final ProductBundle? bundle;

  const ProductParams({this.id, this.product, this.bundle});

  @override
  List<Object?> get props => [id, product, bundle];
}
