import 'package:dartz/dartz.dart';
import 'package:uuid/uuid.dart';

import 'package:app/core/error/failures.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';
import 'package:app/features/product_management/domain/usecases/bundle_params.dart';

class CreateBundle implements UseCase<ProductBundle, CreateBundleParams> {
  final ProductRepository repository;

  const CreateBundle(this.repository);

  @override
  Future<Either<Failure, ProductBundle>> call(CreateBundleParams params) async {
    final now = DateTime.now();
    final bundle = ProductBundle(
      id: const Uuid().v4(), // Generate a new UUID for the bundle
      name: params.name,
      description: params.description ?? '',
      bundlePrice: params.bundlePrice,
      products: const [], // Empty list for now, will be populated later
      isActive: params.isActive ?? true,
      createdAt: now,
      updatedAt: now,
    );
    
    return await repository.createBundle(bundle);
  }
}
