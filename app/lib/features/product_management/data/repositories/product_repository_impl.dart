import 'dart:io';
import 'package:dartz/dartz.dart';

import 'package:app/core/error/exceptions.dart';
import 'package:app/core/error/failures.dart';
import 'package:app/core/network/network_info.dart';
import 'package:app/features/product_management/data/datasources/product_local_data_source.dart';
import 'package:app/features/product_management/data/datasources/product_remote_data_source.dart';
import 'package:app/features/product_management/data/models/product_bundle_model.dart';
import 'package:app/features/product_management/data/models/product_model.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';

class ProductRepositoryImpl implements ProductRepository {
  final ProductRemoteDataSource remoteDataSource;
  final ProductLocalDataSource localDataSource;
  final NetworkInfo networkInfo;

  ProductRepositoryImpl({
    required this.remoteDataSource,
    required this.localDataSource,
    required this.networkInfo,
  });

  @override
  Future<Either<Failure, List<Product>>> getProducts() async {
    if (await networkInfo.isConnected) {
      try {
        final remoteProducts = await remoteDataSource.getProducts();
        localDataSource.cacheProducts(remoteProducts);
        return Right(remoteProducts.map((model) => model.toEntity()).toList());
      } on ServerException {
        return const Left(
            ServerFailure(message: 'Gagal mengambil produk dari server'));
      }
    } else {
      try {
        final localProducts = await localDataSource.getLastProducts();
        return Right(localProducts);
      } on CacheException {
        return const Left(
            CacheFailure(message: 'Gagal mengambil produk dari cache'));
      }
    }
  }

  @override
  Future<Either<Failure, Product>> getProduct(String id) async {
    if (await networkInfo.isConnected) {
      try {
        final remoteProduct = await remoteDataSource.getProduct(id);
        localDataSource.cacheProduct(remoteProduct);
        return Right(remoteProduct.toEntity());
      } on ServerException {
        return const Left(
            ServerFailure(message: 'Gagal mengambil produk dari server'));
      }
    } else {
      try {
        final localProduct = await localDataSource.getProduct(id);
        return Right(localProduct!.toEntity());
      } on CacheException {
        return const Left(
            CacheFailure(message: 'Gagal mengambil produk dari cache'));
      }
    }
  }

  @override
  Future<Either<Failure, Product>> createProduct(Product product) async {
    if (await networkInfo.isConnected) {
      try {
        final productModel = ProductModel(
          id: product.id,
          name: product.name,
          description: product.description ?? '',
          category: product.category,
          categoryId: product.categoryId,
          price: product.price,
          stock: product.stock,
          barcode: product.barcode,
          imageUrl: product.imageUrl,
          createdAt: product.createdAt,
          updatedAt: product.updatedAt,
          isDeleted: product.isDeleted,
          isActive: product.isActive,
        );
        final remoteProduct =
            await remoteDataSource.createProduct(productModel);
        localDataSource.cacheProduct(remoteProduct);
        return Right(remoteProduct.toEntity());
      } on ServerException {
        return const Left(
            ServerFailure(message: 'Gagal membuat produk di server'));
      }
    } else {
      return const Left(NetworkFailure(message: 'Tidak ada koneksi internet'));
    }
  }

  @override
  Future<Either<Failure, Product>> updateProduct(Product product) async {
    if (await networkInfo.isConnected) {
      try {
        final productModel = ProductModel(
          id: product.id,
          name: product.name,
          description: product.description ?? '',
          category: product.category,
          categoryId: product.categoryId,
          price: product.price,
          stock: product.stock,
          barcode: product.barcode,
          imageUrl: product.imageUrl,
          createdAt: product.createdAt,
          updatedAt: product.updatedAt,
          isDeleted: product.isDeleted,
          isActive: product.isActive,
        );
        final remoteProduct =
            await remoteDataSource.updateProduct(productModel);
        localDataSource.cacheProduct(remoteProduct);
        return Right(remoteProduct.toEntity());
      } on ServerException {
        return const Left(
            ServerFailure(message: 'Gagal memperbarui produk di server'));
      }
    } else {
      return const Left(NetworkFailure(message: 'Tidak ada koneksi internet'));
    }
  }

  @override
  Future<Either<Failure, bool>> deleteProduct(String id) async {
    try {
      await remoteDataSource.deleteProduct(id);
      await localDataSource.deleteProduct(id);
      return const Right(true);
    } on ServerException {
      return const Left(
          ServerFailure(message: 'Gagal menghapus produk di server'));
    }
  }

  @override
  Future<Either<Failure, void>> bulkUploadProducts(File file) async {
    try {
      final extension = file.path.split('.').last.toLowerCase();
      if (extension != 'csv' && extension != 'xlsx') {
        return const Left(
            InvalidFileFailure(message: 'Format file tidak didukung'));
      }

      await remoteDataSource.bulkUploadProducts(file);
      return const Right(null);
    } on ServerException {
      return const Left(
          ServerFailure(message: 'Gagal mengunggah produk ke server'));
    }
  }

  @override
  Future<Either<Failure, List<Product>>> searchProducts(String query) async {
    if (await networkInfo.isConnected) {
      try {
        final products = await remoteDataSource.searchProducts(query);
        return Right(products.map((model) => model.toEntity()).toList());
      } on ServerException {
        return const Left(
            ServerFailure(message: 'Gagal mencari produk di server'));
      }
    } else {
      return const Left(NetworkFailure(message: 'Tidak ada koneksi internet'));
    }
  }

  @override
  Future<Either<Failure, List<Product>>> getProductsByCategory(
      String category) async {
    try {
      final products = await getProducts();
      return products.fold(
        (failure) => Left(failure),
        (products) => Right(
          products.where((product) => product.category == category).toList(),
        ),
      );
    } catch (e) {
      return const Left(ServerFailure(
          message: 'Gagal mengambil produk berdasarkan kategori'));
    }
  }

  @override
  Future<Either<Failure, List<Product>>> getLowStockProducts(
      int threshold) async {
    try {
      final products = await getProducts();
      return products.fold(
        (failure) => Left(failure),
        (products) => Right(
          products.where((product) => product.stock <= threshold).toList(),
        ),
      );
    } catch (e) {
      return const Left(
          ServerFailure(message: 'Gagal mengambil produk dengan stok rendah'));
    }
  }

  @override
  Future<Either<Failure, List<ProductBundle>>> getBundles({
    int? limit,
    int? offset,
    bool? isActive,
  }) async {
    if (await networkInfo.isConnected) {
      try {
        final remoteBundles = await remoteDataSource.getBundles(
          limit: limit,
          offset: offset,
          isActive: isActive,
        );
        return Right(remoteBundles.map((model) => model.toEntity()).toList());
      } on ServerException {
        return const Left(
            ServerFailure(message: 'Gagal mengambil bundle dari server'));
      }
    } else {
      return const Left(NetworkFailure(message: 'Tidak ada koneksi internet'));
    }
  }

  @override
  Future<Either<Failure, ProductBundle>> getBundle(String id) async {
    if (await networkInfo.isConnected) {
      try {
        final remoteBundle = await remoteDataSource.getBundle(id);
        return Right(remoteBundle.toEntity());
      } on ServerException {
        return const Left(
            ServerFailure(message: 'Gagal mengambil bundle dari server'));
      }
    } else {
      return const Left(NetworkFailure(message: 'Tidak ada koneksi internet'));
    }
  }

  @override
  Future<Either<Failure, ProductBundle>> createBundle(
      ProductBundle bundle) async {
    if (await networkInfo.isConnected) {
      try {
        final bundleModel = ProductBundleModel.fromEntity(bundle);
        final remoteBundle = await remoteDataSource.createBundle(bundleModel);
        return Right(remoteBundle.toEntity());
      } on ServerException {
        return const Left(
            ServerFailure(message: 'Gagal membuat bundle di server'));
      }
    } else {
      return const Left(NetworkFailure(message: 'Tidak ada koneksi internet'));
    }
  }

  @override
  Future<Either<Failure, ProductBundle>> updateBundle(
      ProductBundle bundle) async {
    if (await networkInfo.isConnected) {
      try {
        final bundleModel = ProductBundleModel.fromEntity(bundle);
        final remoteBundle = await remoteDataSource.updateBundle(bundleModel);
        return Right(remoteBundle.toEntity());
      } on ServerException {
        return const Left(
            ServerFailure(message: 'Gagal memperbarui bundle di server'));
      }
    } else {
      return const Left(NetworkFailure(message: 'Tidak ada koneksi internet'));
    }
  }

  @override
  Future<Either<Failure, bool>> deleteBundle(String id) async {
    if (await networkInfo.isConnected) {
      try {
        await remoteDataSource.deleteBundle(id);
        return const Right(true);
      } on ServerException {
        return const Left(
            ServerFailure(message: 'Gagal menghapus bundle di server'));
      }
    } else {
      return const Left(NetworkFailure(message: 'Tidak ada koneksi internet'));
    }
  }
}
