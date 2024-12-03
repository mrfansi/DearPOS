import 'package:dartz/dartz.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:mockito/annotations.dart';
import 'package:mockito/mockito.dart';
import 'package:uuid/uuid.dart';

import 'package:app/core/error/failures.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';
import 'package:app/features/product_management/domain/usecases/get_products.dart';

import 'get_products_test.mocks.dart';

@GenerateMocks([ProductRepository])
void main() {
  late GetProducts useCase;
  late MockProductRepository mockProductRepository;
  const uuid = Uuid();

  setUp(() {
    mockProductRepository = MockProductRepository();
    useCase = GetProducts(mockProductRepository);
  });

  final testProducts = [
    Product(
      id: uuid.v4(),
      name: 'Product 1',
      description: 'Description 1',
      category: 'Category 1',
      price: 100.0,
      stock: 10,
      minStock: 5,
      barcode: '123456',
      imageUrl: 'url1',
      createdAt: DateTime.now(),
      updatedAt: DateTime.now(),
    ),
    Product(
      id: uuid.v4(),
      name: 'Product 2',
      description: 'Description 2',
      category: 'Category 2',
      price: 200.0,
      stock: 20,
      minStock: 10,
      barcode: '789012',
      imageUrl: 'url2',
      createdAt: DateTime.now(),
      updatedAt: DateTime.now(),
    )
  ];

  group('GetProducts', () {
    test('should get products from the repository', () async {
      // Arrange
      when(mockProductRepository.getProducts())
          .thenAnswer((_) async => Right(testProducts));

      // Act
      final result = await useCase(NoParams());

      // Assert
      expect(result, Right(testProducts));
      verify(mockProductRepository.getProducts()).called(1);
      verifyNoMoreInteractions(mockProductRepository);
    });

    test('should return a Failure when getting products fails', () async {
      // Arrange
      when(mockProductRepository.getProducts())
          .thenAnswer((_) async => Left(ServerFailure()));

      // Act
      final result = await useCase(NoParams());

      // Assert
      expect(result, Left(ServerFailure()));
      verify(mockProductRepository.getProducts()).called(1);
      verifyNoMoreInteractions(mockProductRepository);
    });

    test('should return a Failure when repository throws an exception', () async {
      // Arrange
      when(mockProductRepository.getProducts())
          .thenThrow(Exception('Test Exception'));

      // Act
      final result = await useCase(NoParams());

      // Assert
      expect(result, Left(ServerFailure()));
      verify(mockProductRepository.getProducts()).called(1);
      verifyNoMoreInteractions(mockProductRepository);
    });
  });
}
