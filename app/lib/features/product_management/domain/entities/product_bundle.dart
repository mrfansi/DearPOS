import 'package:equatable/equatable.dart';
import 'package:app/features/product_management/domain/entities/product.dart';

class ProductBundle extends Equatable {
  final String id;
  final String name;
  final String description;
  final double bundlePrice;
  final List<Product> products;
  final DateTime createdAt;
  final DateTime updatedAt;
  final bool isActive;

  const ProductBundle({
    required this.id,
    required this.name,
    this.description = '',
    required this.bundlePrice,
    required this.products,
    required this.createdAt,
    required this.updatedAt,
    this.isActive = true,
  });

  @override
  List<Object?> get props => [
    id, 
    name, 
    description, 
    bundlePrice, 
    products, 
    createdAt, 
    updatedAt, 
    isActive
  ];
}
