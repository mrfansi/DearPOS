import 'package:dartz/dartz.dart';
import 'package:equatable/equatable.dart';
import 'package:app/core/error/failures.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';

class DeleteProduct implements UseCase<bool, DeleteProductParams> {
  final ProductRepository repository;

  DeleteProduct(this.repository);

  @override
  Future<Either<Failure, bool>> call(DeleteProductParams params) async {
    return await repository.deleteProduct(params.id);
  }
}

class DeleteProductParams extends Equatable {
  final String id;

  const DeleteProductParams({required this.id});

  @override
  List<Object> get props => [id];
}
