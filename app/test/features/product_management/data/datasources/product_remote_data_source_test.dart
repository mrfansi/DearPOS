import 'dart:io';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:firebase_storage/firebase_storage.dart';
import 'package:fake_cloud_firestore/fake_cloud_firestore.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:mockito/mockito.dart';
import 'package:uuid/uuid.dart';

import 'package:app/core/error/exceptions.dart';
import 'package:app/features/product_management/data/datasources/product_remote_data_source.dart';
import 'package:app/features/product_management/data/models/product_model.dart';

class MockFirebaseFirestore extends Mock implements FirebaseFirestore {}
class MockFirebaseStorage extends Mock implements FirebaseStorage {}
class MockCollectionReference extends Mock implements CollectionReference<Map<String, dynamic>> {}
class MockQuerySnapshot extends Mock implements QuerySnapshot<Map<String, dynamic>> {}

void main() {
  late ProductRemoteDataSourceImpl dataSource;
  late FakeFirebaseFirestore fakeFirestore;
  late MockFirebaseStorage mockStorage;
  const uuid = Uuid();

  setUp(() {
    fakeFirestore = FakeFirebaseFirestore();
    mockStorage = MockFirebaseStorage();
    dataSource = ProductRemoteDataSourceImpl(
      firestore: fakeFirestore,
      storage: mockStorage,
    );
  });

  final testProductModel = ProductModel(
    id: uuid.v4(),
    name: 'Test Product',
    description: 'Test Description',
    category: 'Test Category',
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
      expect(result.length, 1);
      expect(result[0], equals(testProductModel));
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
      expect(result, equals(testProductModel));
      final snapshot = await fakeFirestore
          .collection('products')
          .doc(testProductModel.id)
          .get();
      expect(snapshot.data(), equals(testProductModel.toJson()));
    });

    test('should throw ServerException when product creation fails', () async {
      // Arrange
      final invalidProductModel = ProductModel(
        id: '',  // Invalid ID
        name: 'Test Product',
        description: 'Test Description',
        category: 'Test Category',
        price: 100.0,
        stock: 10,
        minStock: 5,
        barcode: '123456',
        imageUrl: 'test_url',
        createdAt: DateTime.now(),
        updatedAt: DateTime.now(),
      );

      // Act & Assert
      expect(
        () async => await dataSource.createProduct(invalidProductModel),
        throwsA(isA<ServerException>()),
      );
    });
  });

  group('bulkUploadProducts', () {
    test('should successfully bulk upload products from a CSV file', () async {
      // Arrange
      final testFile = File('/tmp/test_products.csv');
      await testFile.writeAsString('''
name,description,category,price,stock,minStock,barcode,imageUrl
${testProductModel.name},${testProductModel.description},${testProductModel.category},${testProductModel.price},${testProductModel.stock},${testProductModel.minStock},${testProductModel.barcode},${testProductModel.imageUrl}
''');

      // Act
      final result = await dataSource.bulkUploadProducts(testFile);

      // Assert
      expect(result.totalRows, 1);
      expect(result.successfulUploads, 1);
      expect(result.skippedDuplicates, 0);
      expect(result.uploadedProducts.length, 1);
      expect(result.uploadedProducts[0].name, equals(testProductModel.name));

      final snapshot = await fakeFirestore
          .collection('products')
          .where('name', isEqualTo: testProductModel.name)
          .get();
      expect(snapshot.docs.length, 1);
    });

    test('should handle duplicate products during bulk upload', () async {
      // Arrange
      final testFile = File('/tmp/test_duplicate_products.csv');
      await testFile.writeAsString('''
name,description,category,price,stock,minStock,barcode,imageUrl
${testProductModel.name},${testProductModel.description},${testProductModel.category},${testProductModel.price},${testProductModel.stock},${testProductModel.minStock},${testProductModel.barcode},${testProductModel.imageUrl}
${testProductModel.name},${testProductModel.description},${testProductModel.category},${testProductModel.price},${testProductModel.stock},${testProductModel.minStock},${testProductModel.barcode},${testProductModel.imageUrl}
''');

      // Act
      final result = await dataSource.bulkUploadProducts(testFile);

      // Assert
      expect(result.totalRows, 2);
      expect(result.successfulUploads, 1);
      expect(result.skippedDuplicates, 1);
      expect(result.uploadedProducts.length, 1);
      expect(result.uploadedProducts[0].name, equals(testProductModel.name));

      final snapshot = await fakeFirestore
          .collection('products')
          .where('name', isEqualTo: testProductModel.name)
          .get();
      expect(snapshot.docs.length, 1);
    });

    test('should throw ServerException when CSV file is invalid', () async {
      // Arrange
      final invalidFile = File('/tmp/invalid_products.csv');
      await invalidFile.writeAsString('Invalid CSV content');

      // Act & Assert
      expect(
        () async => await dataSource.bulkUploadProducts(invalidFile),
        throwsA(isA<ServerException>()),
      );
    });

    test('should throw ServerException when CSV file is empty', () async {
      // Arrange
      final emptyFile = File('/tmp/empty_products.csv');
      await emptyFile.writeAsString('');

      // Act & Assert
      expect(
        () async => await dataSource.bulkUploadProducts(emptyFile),
        throwsA(isA<ServerException>()),
      );
    });

    test('should throw ServerException when CSV file has invalid headers', () async {
      // Arrange
      final invalidHeadersFile = File('/tmp/invalid_headers_products.csv');
      await invalidHeadersFile.writeAsString('''
Invalid headers
${testProductModel.name},${testProductModel.description},${testProductModel.category},${testProductModel.price},${testProductModel.stock},${testProductModel.minStock},${testProductModel.barcode},${testProductModel.imageUrl}
''');

      // Act & Assert
      expect(
        () async => await dataSource.bulkUploadProducts(invalidHeadersFile),
        throwsA(isA<ServerException>()),
      );
    });
  });
}
