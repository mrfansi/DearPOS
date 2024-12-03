import 'package:equatable/equatable.dart';
import 'package:app/features/product_management/data/models/product_model.dart';

class ProductBundleModel extends Equatable {
  final String id;
  final String name;
  final String description;
  final double bundlePrice;
  final List<ProductModel> products;
  final DateTime createdAt;
  final DateTime updatedAt;
  final bool isActive;

  const ProductBundleModel({
    required this.id,
    required this.name,
    this.description = '',
    required this.bundlePrice,
    required this.products,
    required this.createdAt,
    required this.updatedAt,
    this.isActive = true,
  });

  Map<String, dynamic> toJson() => {
    'id': id,
    'name': name,
    'description': description,
    'bundlePrice': bundlePrice,
    'products': products.map((p) => p.toJson()).toList(),
    'createdAt': createdAt.toIso8601String(),
    'updatedAt': updatedAt.toIso8601String(),
    'isActive': isActive,
  };

  factory ProductBundleModel.fromJson(Map<String, dynamic> json) => ProductBundleModel(
    id: json['id'],
    name: json['name'],
    description: json['description'] ?? '',
    bundlePrice: (json['bundlePrice'] as num).toDouble(),
    products: (json['products'] as List)
        .map((p) => ProductModel.fromJson(p))
        .toList(),
    createdAt: DateTime.parse(json['createdAt']),
    updatedAt: DateTime.parse(json['updatedAt']),
    isActive: json['isActive'] ?? true,
  );

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
