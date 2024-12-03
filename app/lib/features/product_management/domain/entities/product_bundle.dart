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

  void validate() {
    // Validasi nama
    if (name.trim().isEmpty) {
      throw ArgumentError('Nama bundle tidak boleh kosong');
    }

    // Validasi harga
    if (bundlePrice <= 0) {
      throw ArgumentError('Harga bundle harus lebih besar dari 0');
    }

    // Validasi produk
    if (products.isEmpty) {
      throw ArgumentError('Bundle harus memiliki setidaknya satu produk');
    }

    // Validasi tanggal
    if (createdAt.isAfter(updatedAt)) {
      throw ArgumentError(
          'Tanggal pembuatan tidak boleh setelah tanggal update');
    }
  }

  // Metode untuk membuat salinan dengan perubahan opsional
  ProductBundle copyWith({
    String? id,
    String? name,
    String? description,
    double? bundlePrice,
    List<Product>? products,
    DateTime? createdAt,
    DateTime? updatedAt,
    bool? isActive,
  }) {
    return ProductBundle(
      id: id ?? this.id,
      name: name ?? this.name,
      description: description ?? this.description,
      bundlePrice: bundlePrice ?? this.bundlePrice,
      products: products ?? this.products,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
      isActive: isActive ?? this.isActive,
    );
  }

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
