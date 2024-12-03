import 'package:app/features/product_management/domain/entities/product.dart';

class ProductModel extends Product {
  const ProductModel({
    required super.id,
    required super.name,
    required String super.description,
    required super.category,
    required super.categoryId,
    required super.price,
    required super.stock,
    int? minStock,
    super.barcode,
    super.imageUrl,
    required super.createdAt,
    required super.updatedAt,
    super.isDeleted,
    super.isActive,
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
      categoryId: json['categoryId'] as String,
      price: (json['price'] as num).toDouble(),
      stock: json['stock'] as int,
      minStock: json['minStock'] as int?,
      barcode: json['barcode'] as String?,
      imageUrl: json['imageUrl'] as String?,
      createdAt: DateTime.parse(json['createdAt'] as String),
      updatedAt: DateTime.parse(json['updatedAt'] as String),
      isDeleted: json['isDeleted'] as bool? ?? false,
      isActive: json['isActive'] as bool? ?? true,
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

  factory ProductModel.fromEntity(Product product) {
    return ProductModel(
      id: product.id,
      name: product.name,
      description: product.description ?? '',
      category: product.category,
      categoryId: product.categoryId,
      price: product.price,
      stock: product.stock,
      minStock: product.minStock,
      barcode: product.barcode,
      imageUrl: product.imageUrl,
      createdAt: product.createdAt,
      updatedAt: product.updatedAt,
      isDeleted: product.isDeleted,
      isActive: product.isActive,
      stockMovements: product.stockMovements.map((sm) => StockMovementModel(
        id: sm.id, 
        type: sm.type, 
        quantity: sm.quantity, 
        timestamp: sm.timestamp,
        productId: product.id,
        variantId: sm.variantId
      )).toList(),
      expiryDate: product.expiryDate,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'category': category,
      'categoryId': categoryId,
      'price': price,
      'stock': stock,
      'minStock': minStock,
      'barcode': barcode,
      'imageUrl': imageUrl,
      'createdAt': createdAt.toIso8601String(),
      'updatedAt': updatedAt.toIso8601String(),
      'isDeleted': isDeleted,
      'isActive': isActive,
      'stockMovements': stockMovements.map((sm) => 
        sm is StockMovementModel 
          ? sm.toJson() 
          : StockMovementModel(
              id: sm.id, 
              productId: sm.productId, 
              quantity: sm.quantity, 
              type: sm.type, 
              notes: sm.notes, 
              timestamp: sm.timestamp,
              variantId: sm.variantId
            ).toJson()
      ).toList(),
      'expiryDate': expiryDate?.toIso8601String(),
    };
  }

  Product toEntity() {
    return Product(
      id: id,
      name: name,
      description: description,
      category: category,
      categoryId: categoryId,
      price: price,
      stock: stock,
      minStock: minStock,
      barcode: barcode,
      imageUrl: imageUrl,
      createdAt: createdAt,
      updatedAt: updatedAt,
      isDeleted: isDeleted,
      isActive: isActive,
      stockMovements: stockMovements,
      expiryDate: expiryDate,
    );
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
    super.variantId,
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
      variantId: json['variantId'],
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
      'variantId': variantId,
    };
  }
}
