import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';
import 'package:app/features/product_management/domain/usecases/bundle_params.dart';
import 'package:dartz/dartz.dart';
import 'package:app/core/error/failures.dart';

class DeleteBundle implements UseCase<bool, DeleteBundleParams> {
  final ProductRepository repository;

  const DeleteBundle(this.repository);

  @override
  Future<Either<Failure, bool>> call(DeleteBundleParams params) async {
    return await repository.deleteBundle(params.id);
  }
}
