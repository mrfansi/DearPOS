import 'dart:io';
import 'package:dartz/dartz.dart';

import 'package:app/core/error/failures.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';

abstract class ProductRepository {
  Future<Either<Failure, List<Product>>> getProducts();
  Future<Either<Failure, Product>> getProduct(String id);
  Future<Either<Failure, Product>> createProduct(Product product);
  Future<Either<Failure, Product>> updateProduct(Product product);
  Future<Either<Failure, bool>> deleteProduct(String id);
  Future<Either<Failure, void>> bulkUploadProducts(File file);
  Future<Either<Failure, List<Product>>> searchProducts(String query);
  Future<Either<Failure, List<Product>>> getProductsByCategory(String category);
  Future<Either<Failure, List<Product>>> getLowStockProducts(int threshold);
  Future<Either<Failure, ProductBundle>> createBundle(ProductBundle bundle);
  Future<Either<Failure, ProductBundle>> updateBundle(ProductBundle bundle);
  Future<Either<Failure, bool>> deleteBundle(String id);
  Future<Either<Failure, List<ProductBundle>>> getBundles({
    int? limit,
    int? offset,
    bool? isActive,
  });
  Future<Either<Failure, ProductBundle>> getBundle(String id);
}
