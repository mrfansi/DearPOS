import 'package:equatable/equatable.dart';
import 'product_variant.dart';

class Product extends Equatable {
  final String id;
  final String name;
  final String? description;
  final String category;
  final double price; // Base price
  final int stock; // Total stock of all variants
  final int minStock;
  final String? barcode;
  final String? imageUrl;
  final DateTime createdAt;
  final DateTime updatedAt;
  final bool isDeleted;
  final List<StockMovement> stockMovements;
  final DateTime? expiryDate;
  final List<ProductVariant> variants;
  final Map<String, List<String>> variantOptions; // e.g., {'size': ['S', 'M', 'L'], 'color': ['Red', 'Blue']}
  final bool hasVariants;

  const Product({
    required this.id,
    required this.name,
    this.description,
    required this.category,
    required this.price,
    required this.stock,
    this.minStock = 0,
    this.barcode,
    this.imageUrl,
    required this.createdAt,
    required this.updatedAt,
    this.isDeleted = false,
    this.stockMovements = const [],
    this.expiryDate,
    this.variants = const [],
    this.variantOptions = const {},
    this.hasVariants = false,
  });

  @override
  List<Object?> get props => [
        id,
        name,
        description,
        category,
        price,
        stock,
        minStock,
        barcode,
        imageUrl,
        createdAt,
        updatedAt,
        isDeleted,
        stockMovements,
        expiryDate,
        variants,
        variantOptions,
        hasVariants,
      ];

  bool get isLowStock => stock <= minStock;

  Product copyWith({
    String? id,
    String? name,
    String? description,
    String? category,
    double? price,
    int? stock,
    int? minStock,
    String? barcode,
    String? imageUrl,
    DateTime? createdAt,
    DateTime? updatedAt,
    bool? isDeleted,
    List<StockMovement>? stockMovements,
    DateTime? expiryDate,
    List<ProductVariant>? variants,
    Map<String, List<String>>? variantOptions,
    bool? hasVariants,
  }) {
    return Product(
      id: id ?? this.id,
      name: name ?? this.name,
      description: description ?? this.description,
      category: category ?? this.category,
      price: price ?? this.price,
      stock: stock ?? this.stock,
      minStock: minStock ?? this.minStock,
      barcode: barcode ?? this.barcode,
      imageUrl: imageUrl ?? this.imageUrl,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
      isDeleted: isDeleted ?? this.isDeleted,
      stockMovements: stockMovements ?? this.stockMovements,
      expiryDate: expiryDate ?? this.expiryDate,
      variants: variants ?? this.variants,
      variantOptions: variantOptions ?? this.variantOptions,
      hasVariants: hasVariants ?? this.hasVariants,
    );
  }
}

class StockMovement extends Equatable {
  final String id;
  final String productId;
  final String? variantId; // New field for variant
  final int quantity;
  final String type; // 'in' or 'out'
  final String? reference;
  final String? notes;
  final DateTime timestamp;

  const StockMovement({
    required this.id,
    required this.productId,
    this.variantId,
    required this.quantity,
    required this.type,
    this.reference,
    this.notes,
    required this.timestamp,
  });

  @override
  List<Object?> get props => [
        id,
        productId,
        variantId,
        quantity,
        type,
        reference,
        notes,
        timestamp,
      ];
}
