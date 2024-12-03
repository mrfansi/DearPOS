import 'package:app/features/product_management/data/models/product_model.dart';

/// Model untuk menyimpan hasil bulk upload produk
class BulkUploadResult {
  /// Jumlah total baris dalam file
  final int totalRows;

  /// Jumlah produk yang berhasil diupload
  final int successfulUploads;

  /// Jumlah produk yang dilewati karena duplikat
  final int skippedDuplicates;

  /// Pesan error yang terjadi selama proses upload
  final List<String> errorMessages;

  /// Daftar produk yang berhasil diupload
  final List<ProductModel> uploadedProducts;

  const BulkUploadResult({
    required this.totalRows,
    required this.successfulUploads,
    required this.skippedDuplicates,
    required this.errorMessages,
    required this.uploadedProducts,
  });
}
