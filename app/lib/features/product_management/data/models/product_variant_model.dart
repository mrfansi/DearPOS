import '../../domain/entities/product_variant.dart';

class ProductVariantModel extends ProductVariant {
  const ProductVariantModel({
    required super.id,
    required super.productId,
    required super.name,
    required super.attributes,
    required super.price,
    required super.stock,
    super.minStock,
    super.sku,
    super.barcode,
    super.isActive,
    required super.createdAt,
    required super.updatedAt,
  });

  factory ProductVariantModel.fromJson(Map<String, dynamic> json) {
    return ProductVariantModel(
      id: json['id'],
      productId: json['productId'],
      name: json['name'],
      attributes: Map<String, String>.from(json['attributes']),
      price: json['price'].toDouble(),
      stock: json['stock'],
      minStock: json['minStock'] ?? 0,
      sku: json['sku'],
      barcode: json['barcode'],
      isActive: json['isActive'] ?? true,
      createdAt: DateTime.parse(json['createdAt']),
      updatedAt: DateTime.parse(json['updatedAt']),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'productId': productId,
      'name': name,
      'attributes': attributes,
      'price': price,
      'stock': stock,
      'minStock': minStock,
      'sku': sku,
      'barcode': barcode,
      'isActive': isActive,
      'createdAt': createdAt.toIso8601String(),
      'updatedAt': updatedAt.toIso8601String(),
    };
  }
}
