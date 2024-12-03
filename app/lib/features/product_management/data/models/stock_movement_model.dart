import 'package:app/features/product_management/domain/entities/stock_movement.dart';

class StockMovementModel extends StockMovement {
  const StockMovementModel({
    required super.id,
    required super.productId,
    super.variantId,
    required super.quantity,
    required super.type,
    required super.notes,
    required super.timestamp,
  });

  factory StockMovementModel.fromJson(Map<String, dynamic> json) {
    return StockMovementModel(
      id: json['id'] as String,
      productId: json['productId'] as String,
      variantId: json['variantId'] as String?,
      quantity: json['quantity'] as int,
      type: json['type'] as String,
      notes: json['notes'] as String,
      timestamp: DateTime.parse(json['timestamp'] as String),
    );
  }

  @override
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'productId': productId,
      'variantId': variantId,
      'quantity': quantity,
      'type': type,
      'notes': notes,
      'timestamp': timestamp.toIso8601String(),
    };
  }
}
