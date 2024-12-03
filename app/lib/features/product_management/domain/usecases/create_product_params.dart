import 'package:equatable/equatable.dart';
import 'package:meta/meta.dart';
import 'package:app/features/product_management/domain/entities/product.dart';

@immutable
class CreateProductParams extends Equatable {
  final Product product;

  const CreateProductParams({required this.product});

  @override
  List<Object> get props => [product];
}
