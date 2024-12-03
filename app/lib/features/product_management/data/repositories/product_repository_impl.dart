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
        return Right(remoteProducts);
      } on ServerException {
        return Left(ServerFailure());
      }
    } else {
      try {
        final localProducts = await localDataSource.getLastProducts();
        return Right(localProducts);
      } on CacheException {
        return Left(CacheFailure());
      }
    }
  }

  @override
  Future<Either<Failure, Product>> getProduct(String id) async {
    if (await networkInfo.isConnected) {
      try {
        final remoteProduct = await remoteDataSource.getProduct(id);
        localDataSource.cacheProduct(remoteProduct);
        return Right(remoteProduct);
      } on ServerException {
        return Left(ServerFailure());
      }
    } else {
      try {
        final localProduct = await localDataSource.getProduct(id);
        return Right(localProduct!);
      } on CacheException {
        return Left(CacheFailure());
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
          price: product.price,
          stock: product.stock,
          barcode: product.barcode,
          imageUrl: product.imageUrl,
          createdAt: product.createdAt,
          updatedAt: product.updatedAt,
          isDeleted: product.isDeleted,
        );
        final remoteProduct =
            await remoteDataSource.createProduct(productModel);
        localDataSource.cacheProduct(remoteProduct);
        return Right(remoteProduct);
      } on ServerException {
        return Left(ServerFailure());
      }
    } else {
      return Left(NetworkFailure());
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
          price: product.price,
          stock: product.stock,
          barcode: product.barcode,
          imageUrl: product.imageUrl,
          createdAt: product.createdAt,
          updatedAt: product.updatedAt,
          isDeleted: product.isDeleted,
        );
        final remoteProduct =
            await remoteDataSource.updateProduct(productModel);
        localDataSource.cacheProduct(remoteProduct);
        return Right(remoteProduct);
      } on ServerException {
        return Left(ServerFailure());
      }
    } else {
      return Left(NetworkFailure());
    }
  }

  @override
  Future<Either<Failure, bool>> deleteProduct(String id) async {
    try {
      await remoteDataSource.deleteProduct(id);
      await localDataSource.deleteProduct(id);
      return const Right(true);
    } on ServerException {
      return Left(ServerFailure());
    }
  }

  @override
  Future<Either<Failure, void>> bulkUploadProducts(File file) async {
    try {
      final extension = file.path.split('.').last.toLowerCase();
      if (extension != 'csv' && extension != 'xlsx') {
        return Left(InvalidFileFailure());
      }
      
      await remoteDataSource.bulkUploadProducts(file);
      return const Right(null);
    } on ServerException {
      return Left(ServerFailure());
    }
  }

  @override
  Future<Either<Failure, List<Product>>> searchProducts(String query) async {
    if (await networkInfo.isConnected) {
      try {
        final products = await remoteDataSource.searchProducts(query);
        return Right(products);
      } on ServerException {
        return Left(ServerFailure());
      }
    } else {
      return Left(NetworkFailure());
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
      return Left(ServerFailure());
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
      return Left(ServerFailure());
    }
  }

  // Metode untuk mengonversi ProductBundleModel ke ProductBundle
  ProductBundle _mapBundleModelToEntity(ProductBundleModel model) {
    return ProductBundle(
      id: model.id,
      name: model.name,
      description: model.description,
      bundlePrice: model.bundlePrice,
      products: model.products.map((productModel) => 
        Product(
          id: productModel.id,
          name: productModel.name,
          price: productModel.price,
          category: productModel.category,
          stock: productModel.stock,
          barcode: productModel.barcode,
        )
      ).toList(),
      createdAt: model.createdAt,
      updatedAt: model.updatedAt,
    );
  }

  // Metode untuk mengonversi ProductBundle ke ProductBundleModel
  ProductBundleModel _mapBundleEntityToModel(ProductBundle bundle) {
    return ProductBundleModel(
      id: bundle.id,
      name: bundle.name,
      description: bundle.description,
      bundlePrice: bundle.bundlePrice,
      products: bundle.products.map((product) => 
        ProductModel(
          id: product.id,
          name: product.name,
          price: product.price,
          category: product.category,
          stock: product.stock,
          barcode: product.barcode,
        )
      ).toList(),
      createdAt: bundle.createdAt,
      updatedAt: bundle.updatedAt,
    );
  }

  @override
  Future<Either<Failure, ProductBundle>> getBundle(String id) async {
    try {
      final bundleModel = await remoteDataSource.getBundle(id);
      return Right(_mapBundleModelToEntity(bundleModel));
    } catch (error) {
      return Left(ServerFailure(message: error.toString()));
    }
  }

  @override
  Future<Either<Failure, List<ProductBundle>>> getBundles() async {
    try {
      final bundleModels = await remoteDataSource.getBundles();
      final bundles = bundleModels
          .map((bundleModel) => _mapBundleModelToEntity(bundleModel))
          .toList();
      return Right(bundles);
    } catch (error) {
      return Left(ServerFailure(message: error.toString()));
    }
  }

  @override
  Future<Either<Failure, ProductBundle>> createBundle(ProductBundle bundle) async {
    try {
      final bundleModel = _mapBundleEntityToModel(bundle);
      final createdBundleModel = await remoteDataSource.createBundle(bundleModel);
      return Right(_mapBundleModelToEntity(createdBundleModel));
    } catch (error) {
      return Left(ServerFailure(message: error.toString()));
    }
  }

  @override
  Future<Either<Failure, ProductBundle>> updateBundle(ProductBundle bundle) async {
    try {
      final bundleModel = _mapBundleEntityToModel(bundle);
      final updatedBundleModel = await remoteDataSource.updateBundle(bundleModel);
      return Right(_mapBundleModelToEntity(updatedBundleModel));
    } catch (error) {
      return Left(ServerFailure(message: error.toString()));
    }
  }

  @override
  Future<Either<Failure, bool>> deleteBundle(String id) async {
    try {
      await remoteDataSource.deleteBundle(id);
      return const Right(true);
    } catch (error) {
      return Left(ServerFailure(message: error.toString()));
    }
  }
}
