import 'dart:io';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:fake_cloud_firestore/fake_cloud_firestore.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:mockito/annotations.dart';
import 'package:mockito/mockito.dart';
import 'package:uuid/uuid.dart';

import 'package:app/core/error/exceptions.dart';
import 'package:app/features/product_management/data/datasources/product_remote_data_source.dart';
import 'package:app/features/product_management/data/models/product_model.dart';
import 'package:app/features/product_management/data/models/bulk_upload_result.dart';

import 'product_remote_data_source_test.mocks.dart';

@GenerateMocks([
  FirebaseFirestore, 
], customMocks: [
  MockSpec<CollectionReference<Map<String, dynamic>>>(as: #GeneratedMockCollectionReference),
  MockSpec<QuerySnapshot<Map<String, dynamic>>>(as: #GeneratedMockQuerySnapshot),
])

void main() {
  late ProductRemoteDataSourceImpl dataSource;
  late FakeFirebaseFirestore fakeFirestore;
  const uuid = Uuid();

  setUp(() {
    fakeFirestore = FakeFirebaseFirestore();

    dataSource = ProductRemoteDataSourceImpl(
      firestore: fakeFirestore,
    );
  });

  final testProductModel = ProductModel(
    id: uuid.v4(),
    name: 'Test Product',
    description: 'Test Description',
    category: 'Test Category',
    categoryId: uuid.v4(),
    price: 100.0,
    stock: 10,
    minStock: 5,
    barcode: '123456',
    imageUrl: 'test_url',
    createdAt: DateTime.now(),
    updatedAt: DateTime.now(),
  );

  group('getProducts', () {
    test('should return list of ProductModels from Firestore', () async {
      // Arrange
      await fakeFirestore
          .collection('products')
          .doc(testProductModel.id)
          .set(testProductModel.toJson());

      // Act
      final result = await dataSource.getProducts();

      // Assert
      expect(result, [testProductModel]);
    });

    test('should return an empty list when no products exist', () async {
      // Act
      final result = await dataSource.getProducts();

      // Assert
      expect(result, isEmpty);
    });
  });

  group('createProduct', () {
    test('should create a product in Firestore and return the created product', () async {
      // Act
      final result = await dataSource.createProduct(testProductModel);

      // Assert
      final storedProduct = await fakeFirestore
          .collection('products')
          .doc(testProductModel.id)
          .get();
      
      expect(result, testProductModel);
      expect(storedProduct.data(), testProductModel.toJson());
    });

    test('should throw ServerException when product creation fails', () async {
      // Act & Assert
      expect(
        () => dataSource.createProduct(testProductModel), 
        throwsA(isA<ServerException>())
      );
    });
  });

  group('bulkUploadProducts', () {
    test('should successfully bulk upload products from a CSV file', () async {
      // Arrange
      final csvFile = File('test/fixtures/products_valid.csv');

      // Act
      final result = await dataSource.bulkUploadProducts(csvFile);

      // Assert
      expect(result, isA<BulkUploadResult>());
      expect(result.successfulUploads, greaterThan(0));
    });

    test('should handle duplicate products during bulk upload', () async {
      // Arrange
      final csvFile = File('test/fixtures/products_with_duplicates.csv');

      // Act
      final result = await dataSource.bulkUploadProducts(csvFile);

      // Assert
      expect(result, isA<BulkUploadResult>());
      expect(result.skippedDuplicates, greaterThan(0));
    });

    test('should throw ServerException when CSV file is invalid', () async {
      // Arrange
      final csvFile = File('test/fixtures/invalid_products.csv');

      // Act & Assert
      expect(
        () => dataSource.bulkUploadProducts(csvFile), 
        throwsA(isA<ServerException>())
      );
    });

    test('should throw ServerException when CSV file is empty', () async {
      // Arrange
      final csvFile = File('test/fixtures/empty_products.csv');

      // Act & Assert
      expect(
        () => dataSource.bulkUploadProducts(csvFile), 
        throwsA(isA<ServerException>())
      );
    });

    test('should throw ServerException when CSV file has invalid headers', () async {
      // Arrange
      final csvFile = File('test/fixtures/products_invalid_headers.csv');

      // Act & Assert
      expect(
        () => dataSource.bulkUploadProducts(csvFile), 
        throwsA(isA<ServerException>())
      );
    });
  });
}
