import 'package:equatable/equatable.dart';
import 'package:dartz/dartz.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/core/error/failures.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';
import 'package:app/features/product_management/domain/usecases/bundle_params.dart';

class GetBundle implements UseCase<ProductBundle, GetBundleParams> {
  final ProductRepository repository;

  const GetBundle(this.repository);

  @override
  Future<Either<Failure, ProductBundle>> call(GetBundleParams params) async {
    return await repository.getBundle(params.id);
  }
}

class GetBundleParams extends Equatable {
  final String id;
  final ProductBundle? bundle;

  const GetBundleParams({required this.id, this.bundle});

  @override
  List<Object?> get props => [id, bundle];
}
