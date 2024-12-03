import 'package:dartz/dartz.dart';
import 'package:equatable/equatable.dart';

import 'package:app/core/error/failures.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';

class CreateBundle implements UseCase<ProductBundle, CreateBundleParams> {
  final ProductRepository repository;

  CreateBundle(this.repository);

  @override
  Future<Either<Failure, ProductBundle>> call(CreateBundleParams params) async {
    return await repository.createBundle(params.bundle);
  }
}

class CreateBundleParams extends Equatable {
  final ProductBundle bundle;

  const CreateBundleParams({required this.bundle});

  @override
  List<Object> get props => [bundle];
}
