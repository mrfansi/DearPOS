class StockMovement {
  final String id;
  final String productId;
  final String? variantId;
  final int quantity;
  final String type; // 'in' or 'out'
  final String notes;
  final DateTime timestamp;

  const StockMovement({
    required this.id,
    required this.productId,
    this.variantId,
    required this.quantity,
    required this.type,
    required this.notes,
    required this.timestamp,
  });

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
