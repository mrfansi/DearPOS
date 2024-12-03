import 'package:dartz/dartz.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:mockito/annotations.dart';
import 'package:mockito/mockito.dart';
import 'dart:io';

import 'package:app/core/error/exceptions.dart';
import 'package:app/core/error/failures.dart';
import 'package:app/core/network/network_info.dart';
import 'package:app/features/product_management/data/datasources/product_remote_data_source.dart';
import 'package:app/features/product_management/data/datasources/product_local_data_source.dart';
import 'package:app/features/product_management/data/models/product_model.dart';
import 'package:app/features/product_management/data/models/bulk_upload_result.dart';
import 'package:app/features/product_management/data/repositories/product_repository_impl.dart';
import 'package:app/features/product_management/domain/entities/product.dart';

import 'product_repository_impl_test.mocks.dart';

@GenerateMocks([
  ProductRemoteDataSource,
  ProductLocalDataSource,
  NetworkInfo,
])
void main() {
  late ProductRepositoryImpl repository;
  late MockProductRemoteDataSource mockRemoteDataSource;
  late MockProductLocalDataSource mockLocalDataSource;
  late MockNetworkInfo mockNetworkInfo;

  setUp(() {
    mockRemoteDataSource = MockProductRemoteDataSource();
    mockLocalDataSource = MockProductLocalDataSource();
    mockNetworkInfo = MockNetworkInfo();
    repository = ProductRepositoryImpl(
      remoteDataSource: mockRemoteDataSource,
      localDataSource: mockLocalDataSource,
      networkInfo: mockNetworkInfo,
    );
  });

  final testDateTime = DateTime(2024, 1, 1);
  final testProductModels = [
    ProductModel(
      id: '1',
      name: 'Test Product',
      description: 'Test Description',
      category: 'Test Category',
      categoryId: '1',
      price: 10.0,
      stock: 100,
      minStock: 10,
      barcode: '123456',
      imageUrl: 'test_url',
      createdAt: testDateTime,
      updatedAt: testDateTime,
    )
  ];

  final List<Product> testProducts = testProductModels.map((model) => model.toEntity()).toList();
  final testProductModel = testProductModels[0];

  group('GetProducts', () {
    test('should check if the device is online', () async {
      // Arrange
      when(mockNetworkInfo.isConnected).thenAnswer((_) async => true);
      when(mockRemoteDataSource.getProducts())
          .thenAnswer((_) async => testProductModels);
      when(mockLocalDataSource.cacheProducts(testProductModels)).thenAnswer((_) async {});

      // Act
      await repository.getProducts();

      // Assert
      verify(mockNetworkInfo.isConnected).called(1);
    });

    test('should return remote data when the device is online', () async {
      // Arrange
      when(mockNetworkInfo.isConnected).thenAnswer((_) async => true);
      when(mockRemoteDataSource.getProducts())
          .thenAnswer((_) async => testProductModels);
      when(mockLocalDataSource.cacheProducts(testProductModels)).thenAnswer((_) async {});

      // Act
      final result = await repository.getProducts();

      // Assert
      verify(mockRemoteDataSource.getProducts()).called(1);
      verify(mockLocalDataSource.cacheProducts(testProductModels)).called(1);
      expect(result, equals(Right<Failure, List<Product>>(testProducts)));
    });

    test('should return locally cached data when the device is offline',
        () async {
      // Arrange
      when(mockNetworkInfo.isConnected).thenAnswer((_) async => false);
      when(mockLocalDataSource.getLastProducts())
          .thenAnswer((_) async => testProductModels);

      // Act
      final result = await repository.getProducts();

      // Assert
      verifyZeroInteractions(mockRemoteDataSource);
      verify(mockLocalDataSource.getLastProducts()).called(1);
      expect(result, equals(Right<Failure, List<Product>>(testProducts)));
    });

    test(
        'should return server failure when remote data source throws an exception',
        () async {
      // Arrange
      when(mockNetworkInfo.isConnected).thenAnswer((_) async => true);
      when(mockRemoteDataSource.getProducts()).thenThrow(ServerException(message: 'Gagal mengambil produk dari server'));

      // Act
      final result = await repository.getProducts();

      // Assert
      verify(mockNetworkInfo.isConnected).called(1);
      expect(result, equals(Left<Failure, List<Product>>(ServerFailure(message: 'Gagal mengambil produk dari server'))));
    });
  });

  group('CreateProduct', () {
    test('should create a product when the device is online', () async {
      // Arrange
      when(mockNetworkInfo.isConnected).thenAnswer((_) async => true);
      when(mockRemoteDataSource.createProduct(any))
          .thenAnswer((_) async => testProductModel);
      when(mockLocalDataSource.cacheProduct(any)).thenAnswer((_) async {});

      // Act
      final result = await repository.createProduct(testProductModel.toEntity());

      // Assert
      verify(mockNetworkInfo.isConnected).called(1);
      verify(mockRemoteDataSource.createProduct(any)).called(1);
      verify(mockLocalDataSource.cacheProduct(any)).called(1);
      expect(result, equals(Right<Failure, Product>(testProductModel.toEntity())));
    });

    test('should return server failure when creating a product fails',
        () async {
      // Arrange
      when(mockNetworkInfo.isConnected).thenAnswer((_) async => true);
      when(mockRemoteDataSource.createProduct(any))
          .thenThrow(ServerException(message: 'Gagal membuat produk di server'));

      // Act
      final result = await repository.createProduct(testProductModel.toEntity());

      // Assert
      verify(mockNetworkInfo.isConnected).called(1);
      expect(result, equals(Left<Failure, Product>(ServerFailure(message: 'Gagal membuat produk di server'))));
    });
  });

  group('BulkUploadProducts', () {
    final testFile = File('/tmp/test_upload.csv');
    final testBulkUploadResult = BulkUploadResult(
      totalRows: 1,
      successfulUploads: 1,
      skippedDuplicates: 0,
      errorMessages: [],
      uploadedProducts: testProductModels,
    );

    test('should bulk upload products when the device is online', () async {
      // Arrange
      when(mockNetworkInfo.isConnected).thenAnswer((_) async => true);
      when(mockRemoteDataSource.bulkUploadProducts(testFile))
          .thenAnswer((_) async => testBulkUploadResult);

      // Act
      final result = await repository.bulkUploadProducts(testFile);

      // Assert
      verify(mockNetworkInfo.isConnected).called(1);
      verify(mockRemoteDataSource.bulkUploadProducts(testFile)).called(1);
      expect(result, equals(Right<Failure, BulkUploadResult>(testBulkUploadResult)));
    });

    test('should return server failure when bulk upload fails', () async {
      // Arrange
      when(mockNetworkInfo.isConnected).thenAnswer((_) async => true);
      when(mockRemoteDataSource.bulkUploadProducts(testFile))
          .thenThrow(ServerException(message: 'Gagal mengunggah produk'));

      // Act
      final result = await repository.bulkUploadProducts(testFile);

      // Assert
      verify(mockNetworkInfo.isConnected).called(1);
      verify(mockRemoteDataSource.bulkUploadProducts(testFile)).called(1);
      expect(result, equals(Left<Failure, BulkUploadResult>(ServerFailure(message: 'Gagal mengunggah produk'))));
    });
  });
}
