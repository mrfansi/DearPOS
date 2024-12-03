import 'package:dartz/dartz.dart';

import 'package:app/core/error/failures.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';

class GetBundles implements UseCase<List<ProductBundle>, NoParams> {
  final ProductRepository repository;

  GetBundles(this.repository);

  @override
  Future<Either<Failure, List<ProductBundle>>> call(NoParams params) async {
    return await repository.getBundles();
  }
}
