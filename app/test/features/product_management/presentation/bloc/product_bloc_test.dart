import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:bloc_test/bloc_test.dart';
import 'package:dartz/dartz.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:mockito/annotations.dart';
import 'package:mockito/mockito.dart';

import 'package:app/features/product_management/domain/usecases/create_product.dart';
import 'package:app/features/product_management/domain/usecases/update_product.dart';
import 'package:app/features/product_management/domain/usecases/delete_product.dart';
import 'package:app/features/product_management/domain/usecases/search_products.dart';
import 'package:app/features/product_management/domain/usecases/get_products_by_category.dart';
import 'package:app/features/product_management/domain/usecases/bulk_upload_products.dart';
import 'package:app/features/product_management/domain/usecases/get_products.dart';
import 'package:app/features/product_management/domain/usecases/create_bundle.dart';
import 'package:app/features/product_management/domain/usecases/update_bundle.dart';
import 'package:app/features/product_management/domain/usecases/delete_bundle.dart';
import 'package:app/features/product_management/domain/usecases/get_bundle.dart' as get_bundle_usecase;
import 'package:app/features/product_management/domain/usecases/get_bundles.dart';

import 'product_bloc_test.mocks.dart';

// ignore_for_file: prefer_const_constructors

@GenerateMocks([
  GetProducts,
  CreateProduct,
  UpdateProduct,
  DeleteProduct,
  SearchProducts,
  GetProductsByCategory,
  BulkUploadProducts,
  CreateBundle,
  UpdateBundle,
  DeleteBundle,
  get_bundle_usecase.GetBundle,
  GetBundles,
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
  late MockCreateBundle mockCreateBundle;
  late MockUpdateBundle mockUpdateBundle;
  late MockDeleteBundle mockDeleteBundle;
  late MockGetBundle mockGetBundle;
  late MockGetBundles mockGetBundles;

  final testProduct = Product(
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
    createdAt: DateTime.now(),
    updatedAt: DateTime.now(),
  );

  setUp(() {
    mockGetProducts = MockGetProducts();
    mockCreateProduct = MockCreateProduct();
    mockUpdateProduct = MockUpdateProduct();
    mockDeleteProduct = MockDeleteProduct();
    mockSearchProducts = MockSearchProducts();
    mockGetProductsByCategory = MockGetProductsByCategory();
    mockBulkUploadProducts = MockBulkUploadProducts();
    mockCreateBundle = MockCreateBundle();
    mockUpdateBundle = MockUpdateBundle();
    mockDeleteBundle = MockDeleteBundle();
    mockGetBundle = MockGetBundle();
    mockGetBundles = MockGetBundles();

    productBloc = ProductBloc(
      getProducts: mockGetProducts,
      createProduct: mockCreateProduct,
      updateProduct: mockUpdateProduct,
      deleteProduct: mockDeleteProduct,
      searchProducts: mockSearchProducts,
      getProductsByCategory: mockGetProductsByCategory,
      bulkUploadProducts: mockBulkUploadProducts,
      createBundle: mockCreateBundle,
      updateBundle: mockUpdateBundle,
      deleteBundle: mockDeleteBundle,
      getBundle: mockGetBundle,
      getBundles: mockGetBundles,
    );
  });

  tearDown(() {
    productBloc.close();
  });

  group('GetProducts', () {
    blocTest<ProductBloc, ProductState>(
      'emits [ProductLoading, ProductsLoadSuccess] when GetProductsEvent is added and successful',
      build: () {
        when(mockGetProducts(any))
            .thenAnswer((_) async => Right([testProduct]));
        return productBloc;
      },
      act: (bloc) => bloc.add(const GetProductsEvent()),
      expect: () => [
        const ProductLoading(),
        ProductsLoadSuccess(products: [testProduct]),
      ],
      verify: (_) {
        verify(mockGetProducts(any)).called(1);
      },
    );
  });

  group('CreateProductEvent', () {
    blocTest<ProductBloc, ProductState>(
      'emits [ProductLoading, ProductOperationSuccess] when CreateProductEvent is added and successful',
      build: () {
        when(mockCreateProduct(any))
            .thenAnswer((_) async => Right(testProduct));
        return productBloc;
      },
      act: (bloc) => bloc.add(CreateProductEvent(testProduct)),
      expect: () => [
        const ProductLoading(),
        ProductOperationSuccess(
          product: testProduct, 
          message: 'Product created successfully',
        ),
      ],
      verify: (_) {
        verify(mockCreateProduct(any)).called(1);
      },
    );
  });
}
