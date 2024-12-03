import 'package:dartz/dartz.dart';
import 'package:equatable/equatable.dart';

import 'package:app/core/error/failures.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';

class UpdateBundle implements UseCase<ProductBundle, UpdateBundleParams> {
  final ProductRepository repository;

  UpdateBundle(this.repository);

  @override
  Future<Either<Failure, ProductBundle>> call(UpdateBundleParams params) async {
    return await repository.updateBundle(params.bundle);
  }
}

class UpdateBundleParams extends Equatable {
  final ProductBundle bundle;

  const UpdateBundleParams({required this.bundle});

  @override
  List<Object> get props => [bundle];
}
