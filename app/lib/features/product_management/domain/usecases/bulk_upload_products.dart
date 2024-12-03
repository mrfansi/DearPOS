import 'dart:io';

import 'package:dartz/dartz.dart';
import 'package:injectable/injectable.dart';

import '../../../../core/error/failures.dart';
import '../../../../core/usecases/usecase.dart';
import '../repositories/product_repository.dart';

@lazySingleton
class BulkUploadProducts implements UseCase<void, File> {
  final ProductRepository repository;

  BulkUploadProducts(this.repository);

  @override
  Future<Either<Failure, void>> call(File params) async {
    return await repository.bulkUploadProducts(params);
  }
}
