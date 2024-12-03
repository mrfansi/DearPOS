import 'package:dartz/dartz.dart';

import 'package:app/core/error/failures.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';
import 'package:app/features/product_management/domain/usecases/bundle_params.dart';

class GetBundles implements UseCase<List<ProductBundle>, GetBundlesParams> {
  final ProductRepository repository;

  const GetBundles(this.repository);

  @override
  Future<Either<Failure, List<ProductBundle>>> call(GetBundlesParams params) async {
    return await repository.getBundles(
      limit: params.limit,
      offset: params.offset,
      isActive: params.isActive,
    );
  }
}
