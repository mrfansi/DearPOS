import 'package:app/features/product_management/domain/entities/product.dart';

class ProductModel extends Product {
  const ProductModel({
    required super.id,
    required super.name,
    required String super.description,
    required super.category,
    required super.price,
    required super.stock,
    int? minStock,
    super.barcode,
    super.imageUrl,
    required super.createdAt,
    required super.updatedAt,
    super.isDeleted,
    List<StockMovementModel> super.stockMovements = const [],
    super.expiryDate,
  }) : super(
          minStock: minStock ?? 0,
        );

  factory ProductModel.fromJson(Map<String, dynamic> json) {
    return ProductModel(
      id: json['id'] as String,
      name: json['name'] as String,
      description: json['description'] as String,
      category: json['category'] as String,
      price: (json['price'] as num).toDouble(),
      stock: json['stock'] as int,
      minStock: json['minStock'] as int?,
      barcode: json['barcode'] as String?,
      imageUrl: json['imageUrl'] as String?,
      createdAt: DateTime.parse(json['createdAt'] as String),
      updatedAt: DateTime.parse(json['updatedAt'] as String),
      isDeleted: json['isDeleted'] as bool? ?? false,
      stockMovements: (json['stockMovements'] as List<dynamic>?)
              ?.map(
                  (e) => StockMovementModel.fromJson(e as Map<String, dynamic>))
              .toList() ??
          [],
      expiryDate: json['expiryDate'] != null
          ? DateTime.parse(json['expiryDate'] as String)
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'category': category,
      'price': price,
      'stock': stock,
      'minStock': minStock,
      'barcode': barcode,
      'imageUrl': imageUrl,
      'createdAt': createdAt.toIso8601String(),
      'updatedAt': updatedAt.toIso8601String(),
      'isDeleted': isDeleted,
      'stockMovements': stockMovements
          .map((e) => (e as StockMovementModel).toJson())
          .toList(),
      'expiryDate': expiryDate?.toIso8601String(),
    };
  }
}

class StockMovementModel extends StockMovement {
  const StockMovementModel({
    required super.id,
    required super.productId,
    required super.quantity,
    required super.type,
    super.reference,
    super.notes,
    required super.timestamp,
  });

  factory StockMovementModel.fromJson(Map<String, dynamic> json) {
    return StockMovementModel(
      id: json['id'],
      productId: json['productId'],
      quantity: json['quantity'],
      type: json['type'],
      reference: json['reference'],
      notes: json['notes'],
      timestamp: DateTime.parse(json['timestamp']),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'productId': productId,
      'quantity': quantity,
      'type': type,
      'reference': reference,
      'notes': notes,
      'timestamp': timestamp.toIso8601String(),
    };
  }
}
