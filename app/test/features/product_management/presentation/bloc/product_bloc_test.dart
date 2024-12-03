import 'dart:io';
import 'package:bloc_test/bloc_test.dart';
import 'package:dartz/dartz.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:mockito/annotations.dart';
import 'package:mockito/mockito.dart';
import 'package:uuid/uuid.dart';

import 'package:app/core/error/failures.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/data/models/product_model.dart';
import 'package:app/features/product_management/domain/usecases/get_products.dart';
import 'package:app/features/product_management/domain/usecases/create_product.dart';
import 'package:app/features/product_management/domain/usecases/update_product.dart';
import 'package:app/features/product_management/domain/usecases/delete_product.dart';
import 'package:app/features/product_management/domain/usecases/search_products.dart';
import 'package:app/features/product_management/domain/usecases/get_products_by_category.dart';
import 'package:app/features/product_management/domain/usecases/bulk_upload_products.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';
import 'package:app/features/product_management/data/models/bulk_upload_result.dart';

import 'product_bloc_test.mocks.dart';

// Constant for server failure message
// ignore: constant_identifier_names
const String SERVER_FAILURE_MESSAGE = 'Server Failure';

@GenerateMocks([
  GetProducts,
  CreateProduct,
  UpdateProduct,
  DeleteProduct,
  SearchProducts,
  GetProductsByCategory,
  BulkUploadProducts
])
void main() {
  late ProductBloc productBloc;
  late MockGetProducts mockGetProducts;
  late MockCreateProduct mockCreateProduct;
  late MockUpdateProduct mockUpdateProduct;
  late MockDeleteProduct mockDeleteProduct;
  late MockSearchProducts mockSearchProducts;
  late MockGetProductsByCategory mockGetProductsByCategory;
  late MockBulkUploadProducts mockBulkUploadProducts;
  const uuid = Uuid();

  setUp(() {
    mockGetProducts = MockGetProducts();
    mockCreateProduct = MockCreateProduct();
    mockUpdateProduct = MockUpdateProduct();
    mockDeleteProduct = MockDeleteProduct();
    mockSearchProducts = MockSearchProducts();
    mockGetProductsByCategory = MockGetProductsByCategory();
    mockBulkUploadProducts = MockBulkUploadProducts();
    productBloc = ProductBloc(
      getProducts: mockGetProducts,
      createProduct: mockCreateProduct,
      updateProduct: mockUpdateProduct,
      deleteProduct: mockDeleteProduct,
      searchProducts: mockSearchProducts,
      getProductsByCategory: mockGetProductsByCategory,
      bulkUploadProducts: mockBulkUploadProducts,
    );
  });

  tearDown(() {
    productBloc.close();
  });

  final testProductModels = [
    ProductModel(
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
    ProductModel(
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

  final List<Product> testProducts = testProductModels;

  group('GetProductsEvent', () {
    blocTest<ProductBloc, ProductState>(
      'should emit [ProductLoading, ProductsLoaded] when GetProductsEvent is added and products are fetched successfully',
      build: () {
        when(mockGetProducts(any)).thenAnswer((_) async => Right(testProducts));
        return productBloc;
      },
      act: (bloc) => bloc.add(GetProductsEvent()),
      expect: () => [
        ProductLoading(),
        ProductsLoaded(testProducts),
      ],
      verify: (_) {
        verify(mockGetProducts(any)).called(1);
      },
    );

    blocTest<ProductBloc, ProductState>(
      'should emit [ProductLoading, ProductError] when GetProductsEvent is added and products fetch fails',
      build: () {
        when(mockGetProducts(any))
            .thenAnswer((_) async => Left(ServerFailure()));
        return productBloc;
      },
      act: (bloc) => bloc.add(GetProductsEvent()),
      expect: () => [
        ProductLoading(),
        const ProductError('ServerFailure()'),
      ],
      verify: (_) {
        verify(mockGetProducts(any)).called(1);
      },
    );
  });

  group('CreateProductEvent', () {
    final testProduct = testProductModels[0];

    blocTest<ProductBloc, ProductState>(
      'should emit [ProductLoading, ProductCreated] when CreateProductEvent is added and product is created successfully',
      build: () {
        when(mockCreateProduct(any))
            .thenAnswer((_) async => Right(testProduct));
        return productBloc;
      },
      act: (bloc) => bloc.add(CreateProductEvent(testProduct)),
      expect: () => [
        ProductLoading(),
        ProductCreated(testProduct),
      ],
      verify: (_) {
        verify(mockCreateProduct(any)).called(1);
      },
    );

    blocTest<ProductBloc, ProductState>(
      'should emit [ProductLoading, ProductError] when CreateProductEvent is added and product creation fails',
      build: () {
        when(mockCreateProduct(any))
            .thenAnswer((_) async => Left(ServerFailure()));
        return productBloc;
      },
      act: (bloc) => bloc.add(CreateProductEvent(testProduct)),
      expect: () => [
        ProductLoading(),
        const ProductError('ServerFailure()'),
      ],
      verify: (_) {
        verify(mockCreateProduct(any)).called(1);
      },
    );
  });

  group('BulkUploadProductsEvent', () {
    final testFile = File('/tmp/test_upload.csv');
    final testBulkUploadResult = BulkUploadResult(
      totalRows: 2,
      successfulUploads: 2,
      skippedDuplicates: 0,
      errorMessages: [],
      uploadedProducts: testProductModels,
    );

    blocTest<ProductBloc, ProductState>(
      'should emit [ProductLoading, ProductsBulkUploaded] when BulkUploadProductsEvent is added and upload is successful',
      build: () {
        when(mockBulkUploadProducts(any))
            .thenAnswer((_) async => Right(testBulkUploadResult));
        return productBloc;
      },
      act: (bloc) => bloc.add(BulkUploadProductsEvent(filePath: testFile.path)),
      expect: () => [
        ProductLoading(),
        const ProductsBulkUploaded(0),
      ],
      verify: (_) {
        verify(mockBulkUploadProducts(any)).called(1);
      },
    );

    blocTest<ProductBloc, ProductState>(
      'should emit [ProductLoading, ProductError] when BulkUploadProductsEvent is added and upload fails',
      build: () {
        when(mockBulkUploadProducts(any))
            .thenAnswer((_) async => Left(ServerFailure()));
        return productBloc;
      },
      act: (bloc) => bloc.add(BulkUploadProductsEvent(filePath: testFile.path)),
      expect: () => [
        ProductLoading(),
        const ProductError('ServerFailure()'),
      ],
      verify: (_) {
        verify(mockBulkUploadProducts(any)).called(1);
      },
    );
  });
}
