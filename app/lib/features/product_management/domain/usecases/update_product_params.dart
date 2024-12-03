import 'package:equatable/equatable.dart';
import 'package:meta/meta.dart';
import 'package:app/features/product_management/domain/entities/product.dart';

@immutable
class UpdateProductParams extends Equatable {
  final Product product;

  const UpdateProductParams({required this.product});

  @override
  List<Object> get props => [product];
}
