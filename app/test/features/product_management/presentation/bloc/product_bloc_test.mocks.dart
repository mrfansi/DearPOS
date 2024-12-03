// Mocks generated by Mockito 5.4.4 from annotations
// in app/test/features/product_management/presentation/bloc/product_bloc_test.dart.
// Do not manually edit this file.

// ignore_for_file: no_leading_underscores_for_library_prefixes
import 'dart:async' as _i5;
import 'dart:io' as _i15;

import 'package:app/core/error/failures.dart' as _i6;
import 'package:app/core/usecases/usecase.dart' as _i8;
import 'package:app/features/product_management/domain/entities/product.dart'
    as _i7;
import 'package:app/features/product_management/domain/entities/product_bundle.dart'
    as _i17;
import 'package:app/features/product_management/domain/repositories/product_repository.dart'
    as _i2;
import 'package:app/features/product_management/domain/usecases/bulk_upload_products.dart'
    as _i14;
import 'package:app/features/product_management/domain/usecases/bundle_params.dart'
    as _i18;
import 'package:app/features/product_management/domain/usecases/create_bundle.dart'
    as _i16;
import 'package:app/features/product_management/domain/usecases/create_product.dart'
    as _i9;
import 'package:app/features/product_management/domain/usecases/delete_bundle.dart'
    as _i20;
import 'package:app/features/product_management/domain/usecases/delete_product.dart'
    as _i11;
import 'package:app/features/product_management/domain/usecases/get_bundle.dart'
    as _i21;
import 'package:app/features/product_management/domain/usecases/get_bundles.dart'
    as _i22;
import 'package:app/features/product_management/domain/usecases/get_products.dart'
    as _i4;
import 'package:app/features/product_management/domain/usecases/get_products_by_category.dart'
    as _i13;
import 'package:app/features/product_management/domain/usecases/search_products.dart'
    as _i12;
import 'package:app/features/product_management/domain/usecases/update_bundle.dart'
    as _i19;
import 'package:app/features/product_management/domain/usecases/update_product.dart'
    as _i10;
import 'package:dartz/dartz.dart' as _i3;
import 'package:mockito/mockito.dart' as _i1;

// ignore_for_file: type=lint
// ignore_for_file: avoid_redundant_argument_values
// ignore_for_file: avoid_setters_without_getters
// ignore_for_file: comment_references
// ignore_for_file: deprecated_member_use
// ignore_for_file: deprecated_member_use_from_same_package
// ignore_for_file: implementation_imports
// ignore_for_file: invalid_use_of_visible_for_testing_member
// ignore_for_file: prefer_const_constructors
// ignore_for_file: unnecessary_parenthesis
// ignore_for_file: camel_case_types
// ignore_for_file: subtype_of_sealed_class

class _FakeProductRepository_0 extends _i1.SmartFake
    implements _i2.ProductRepository {
  _FakeProductRepository_0(
    Object parent,
    Invocation parentInvocation,
  ) : super(
          parent,
          parentInvocation,
        );
}

class _FakeEither_1<L, R> extends _i1.SmartFake implements _i3.Either<L, R> {
  _FakeEither_1(
    Object parent,
    Invocation parentInvocation,
  ) : super(
          parent,
          parentInvocation,
        );
}

/// A class which mocks [GetProducts].
///
/// See the documentation for Mockito's code generation for more information.
class MockGetProducts extends _i1.Mock implements _i4.GetProducts {
  MockGetProducts() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, List<_i7.Product>>> call(
          _i8.NoParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue:
            _i5.Future<_i3.Either<_i6.Failure, List<_i7.Product>>>.value(
                _FakeEither_1<_i6.Failure, List<_i7.Product>>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, List<_i7.Product>>>);
}

/// A class which mocks [CreateProduct].
///
/// See the documentation for Mockito's code generation for more information.
class MockCreateProduct extends _i1.Mock implements _i9.CreateProduct {
  MockCreateProduct() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, _i7.Product>> call(
          _i9.CreateProductParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue: _i5.Future<_i3.Either<_i6.Failure, _i7.Product>>.value(
            _FakeEither_1<_i6.Failure, _i7.Product>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, _i7.Product>>);
}

/// A class which mocks [UpdateProduct].
///
/// See the documentation for Mockito's code generation for more information.
class MockUpdateProduct extends _i1.Mock implements _i10.UpdateProduct {
  MockUpdateProduct() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, _i7.Product>> call(
          _i10.UpdateProductParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue: _i5.Future<_i3.Either<_i6.Failure, _i7.Product>>.value(
            _FakeEither_1<_i6.Failure, _i7.Product>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, _i7.Product>>);
}

/// A class which mocks [DeleteProduct].
///
/// See the documentation for Mockito's code generation for more information.
class MockDeleteProduct extends _i1.Mock implements _i11.DeleteProduct {
  MockDeleteProduct() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, bool>> call(
          _i11.DeleteProductParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue: _i5.Future<_i3.Either<_i6.Failure, bool>>.value(
            _FakeEither_1<_i6.Failure, bool>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, bool>>);
}

/// A class which mocks [SearchProducts].
///
/// See the documentation for Mockito's code generation for more information.
class MockSearchProducts extends _i1.Mock implements _i12.SearchProducts {
  MockSearchProducts() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, List<_i7.Product>>> call(
          _i12.SearchProductsParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue:
            _i5.Future<_i3.Either<_i6.Failure, List<_i7.Product>>>.value(
                _FakeEither_1<_i6.Failure, List<_i7.Product>>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, List<_i7.Product>>>);
}

/// A class which mocks [GetProductsByCategory].
///
/// See the documentation for Mockito's code generation for more information.
class MockGetProductsByCategory extends _i1.Mock
    implements _i13.GetProductsByCategory {
  MockGetProductsByCategory() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, List<_i7.Product>>> call(
          _i13.GetProductsByCategoryParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue:
            _i5.Future<_i3.Either<_i6.Failure, List<_i7.Product>>>.value(
                _FakeEither_1<_i6.Failure, List<_i7.Product>>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, List<_i7.Product>>>);
}

/// A class which mocks [BulkUploadProducts].
///
/// See the documentation for Mockito's code generation for more information.
class MockBulkUploadProducts extends _i1.Mock
    implements _i14.BulkUploadProducts {
  MockBulkUploadProducts() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, void>> call(_i15.File? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue: _i5.Future<_i3.Either<_i6.Failure, void>>.value(
            _FakeEither_1<_i6.Failure, void>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, void>>);
}

/// A class which mocks [CreateBundle].
///
/// See the documentation for Mockito's code generation for more information.
class MockCreateBundle extends _i1.Mock implements _i16.CreateBundle {
  MockCreateBundle() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, _i17.ProductBundle>> call(
          _i18.CreateBundleParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue:
            _i5.Future<_i3.Either<_i6.Failure, _i17.ProductBundle>>.value(
                _FakeEither_1<_i6.Failure, _i17.ProductBundle>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, _i17.ProductBundle>>);
}

/// A class which mocks [UpdateBundle].
///
/// See the documentation for Mockito's code generation for more information.
class MockUpdateBundle extends _i1.Mock implements _i19.UpdateBundle {
  MockUpdateBundle() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, _i17.ProductBundle>> call(
          _i18.UpdateBundleParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue:
            _i5.Future<_i3.Either<_i6.Failure, _i17.ProductBundle>>.value(
                _FakeEither_1<_i6.Failure, _i17.ProductBundle>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, _i17.ProductBundle>>);
}

/// A class which mocks [DeleteBundle].
///
/// See the documentation for Mockito's code generation for more information.
class MockDeleteBundle extends _i1.Mock implements _i20.DeleteBundle {
  MockDeleteBundle() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, bool>> call(
          _i18.DeleteBundleParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue: _i5.Future<_i3.Either<_i6.Failure, bool>>.value(
            _FakeEither_1<_i6.Failure, bool>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, bool>>);
}

/// A class which mocks [GetBundle].
///
/// See the documentation for Mockito's code generation for more information.
class MockGetBundle extends _i1.Mock implements _i21.GetBundle {
  MockGetBundle() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, _i17.ProductBundle>> call(
          _i21.GetBundleParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue:
            _i5.Future<_i3.Either<_i6.Failure, _i17.ProductBundle>>.value(
                _FakeEither_1<_i6.Failure, _i17.ProductBundle>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, _i17.ProductBundle>>);
}

/// A class which mocks [GetBundles].
///
/// See the documentation for Mockito's code generation for more information.
class MockGetBundles extends _i1.Mock implements _i22.GetBundles {
  MockGetBundles() {
    _i1.throwOnMissingStub(this);
  }

  @override
  _i2.ProductRepository get repository => (super.noSuchMethod(
        Invocation.getter(#repository),
        returnValue: _FakeProductRepository_0(
          this,
          Invocation.getter(#repository),
        ),
      ) as _i2.ProductRepository);

  @override
  _i5.Future<_i3.Either<_i6.Failure, List<_i17.ProductBundle>>> call(
          _i18.GetBundlesParams? params) =>
      (super.noSuchMethod(
        Invocation.method(
          #call,
          [params],
        ),
        returnValue:
            _i5.Future<_i3.Either<_i6.Failure, List<_i17.ProductBundle>>>.value(
                _FakeEither_1<_i6.Failure, List<_i17.ProductBundle>>(
          this,
          Invocation.method(
            #call,
            [params],
          ),
        )),
      ) as _i5.Future<_i3.Either<_i6.Failure, List<_i17.ProductBundle>>>);
}
