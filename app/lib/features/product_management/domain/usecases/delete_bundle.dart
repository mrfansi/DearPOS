import 'package:dartz/dartz.dart';
import 'package:equatable/equatable.dart';

import 'package:app/core/error/failures.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';

class DeleteBundle implements UseCase<bool, DeleteBundleParams> {
  final ProductRepository repository;

  DeleteBundle(this.repository);

  @override
  Future<Either<Failure, bool>> call(DeleteBundleParams params) async {
    return await repository.deleteBundle(params.id);
  }
}

class DeleteBundleParams extends Equatable {
  final String id;

  const DeleteBundleParams({required this.id});

  @override
  List<Object> get props => [id];
}
