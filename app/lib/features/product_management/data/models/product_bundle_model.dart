import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/data/models/product_model.dart';

class ProductBundleModel extends ProductBundle {
  @override
  final String id;
  @override
  final String name;
  @override
  final String description;
  @override
  final double bundlePrice;
  @override
  final List<Product> products;
  @override
  final bool isActive;
  @override
  final DateTime createdAt;
  @override
  final DateTime updatedAt;

  const ProductBundleModel({
    required this.id,
    required this.name,
    this.description = '',
    required this.bundlePrice,
    required this.products,
    required this.isActive,
    required this.createdAt,
    required this.updatedAt,
  }) : super(
          id: id,
          name: name,
          description: description,
          bundlePrice: bundlePrice,
          products: products,
          isActive: isActive,
          createdAt: createdAt,
          updatedAt: updatedAt,
        );

  @override
  void validate() {
    if (name.isEmpty) {
      throw ArgumentError('Name cannot be empty');
    }
    if (bundlePrice < 0) {
      throw ArgumentError('Bundle price cannot be negative');
    }
    if (products.isEmpty) {
      throw ArgumentError('Bundle must have at least one product');
    }
  }

  @override
  List<Object?> get props => [
        id,
        name,
        description,
        bundlePrice,
        products,
        isActive,
        createdAt,
        updatedAt
      ];

  @override
  ProductBundle copyWith({
    String? id,
    String? name,
    String? description,
    double? bundlePrice,
    List<Product>? products,
    bool? isActive,
    DateTime? createdAt,
    DateTime? updatedAt,
  }) {
    return ProductBundleModel(
      id: id ?? this.id,
      name: name ?? this.name,
      description: description ?? this.description,
      bundlePrice: bundlePrice ?? this.bundlePrice,
      products: products ?? this.products,
      isActive: isActive ?? this.isActive,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
    );
  }

  factory ProductBundleModel.fromJson(Map<String, dynamic> json) {
    return ProductBundleModel(
      id: json['id'] as String,
      name: json['name'] as String,
      description: json['description'] as String? ?? '',
      bundlePrice: (json['bundlePrice'] as num).toDouble(),
      products: (json['products'] as List)
          .map((p) => ProductModel.fromJson(p as Map<String, dynamic>))
          .toList(),
      isActive: json['isActive'] as bool,
      createdAt: DateTime.parse(json['createdAt'] as String),
      updatedAt: DateTime.parse(json['updatedAt'] as String),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'bundlePrice': bundlePrice,
      'products': products.map((p) => (p as ProductModel).toJson()).toList(),
      'isActive': isActive,
      'createdAt': createdAt.toIso8601String(),
      'updatedAt': updatedAt.toIso8601String(),
    };
  }

  factory ProductBundleModel.fromEntity(ProductBundle bundle) {
    return ProductBundleModel(
      id: bundle.id,
      name: bundle.name,
      description: bundle.description,
      bundlePrice: bundle.bundlePrice,
      products: bundle.products.map((p) => ProductModel.fromEntity(p)).toList(),
      isActive: bundle.isActive,
      createdAt: bundle.createdAt,
      updatedAt: bundle.updatedAt,
    );
  }

  @override
  ProductBundle toEntity() {
    return ProductBundle(
      id: id,
      name: name,
      description: description,
      bundlePrice: bundlePrice,
      products: products.map((p) => (p as ProductModel).toEntity()).toList(),
      isActive: isActive,
      createdAt: createdAt,
      updatedAt: updatedAt,
    );
  }
}
