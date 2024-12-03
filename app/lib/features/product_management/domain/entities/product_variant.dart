import 'package:equatable/equatable.dart';

class ProductVariant extends Equatable {
  final String id;
  final String productId;
  final String name;
  final Map<String, String> attributes; // e.g., {'size': 'XL', 'color': 'Red'}
  final double price;
  final int stock;
  final int minStock;
  final String? sku;
  final String? barcode;
  final bool isActive;
  final DateTime createdAt;
  final DateTime updatedAt;

  const ProductVariant({
    required this.id,
    required this.productId,
    required this.name,
    required this.attributes,
    required this.price,
    required this.stock,
    this.minStock = 0,
    this.sku,
    this.barcode,
    this.isActive = true,
    required this.createdAt,
    required this.updatedAt,
  });

  @override
  List<Object?> get props => [
        id,
        productId,
        name,
        attributes,
        price,
        stock,
        minStock,
        sku,
        barcode,
        isActive,
        createdAt,
        updatedAt,
      ];

  bool get isLowStock => stock <= minStock;

  ProductVariant copyWith({
    String? id,
    String? productId,
    String? name,
    Map<String, String>? attributes,
    double? price,
    int? stock,
    int? minStock,
    String? sku,
    String? barcode,
    bool? isActive,
    DateTime? createdAt,
    DateTime? updatedAt,
  }) {
    return ProductVariant(
      id: id ?? this.id,
      productId: productId ?? this.productId,
      name: name ?? this.name,
      attributes: attributes ?? this.attributes,
      price: price ?? this.price,
      stock: stock ?? this.stock,
      minStock: minStock ?? this.minStock,
      sku: sku ?? this.sku,
      barcode: barcode ?? this.barcode,
      isActive: isActive ?? this.isActive,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
    );
  }
}
