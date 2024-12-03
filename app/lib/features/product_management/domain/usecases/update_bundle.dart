import 'package:dartz/dartz.dart';
import 'package:app/core/error/failures.dart';
import 'package:app/core/usecases/usecase.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/domain/entities/product_bundle.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';
import 'package:app/features/product_management/domain/usecases/bundle_params.dart';

class UpdateBundle implements UseCase<ProductBundle, UpdateBundleParams> {
  final ProductRepository repository;

  const UpdateBundle(this.repository);

  @override
  Future<Either<Failure, ProductBundle>> call(UpdateBundleParams params) async {
    try {
      // Get the existing bundle first
      final bundleResult = await repository.getBundle(params.id);
      
      return await bundleResult.fold(
        (failure) => Left(failure),
        (existingBundle) async {
          // If product IDs are provided, fetch the products
          if (params.productIds != null) {
            final products = <Product>[];
            for (final id in params.productIds!) {
              final productResult = await repository.getProduct(id);
              final product = productResult.fold(
                (failure) => throw Exception('Failed to fetch product: ${failure.message}'),
                (product) => product,
              );
              products.add(product);
            }

            // Create an updated bundle with new products
            final updatedBundle = existingBundle.copyWith(
              name: params.name ?? existingBundle.name,
              description: params.description ?? existingBundle.description,
              bundlePrice: params.bundlePrice ?? existingBundle.bundlePrice,
              products: products,
              isActive: params.isActive ?? existingBundle.isActive,
              updatedAt: DateTime.now(),
            );

            return repository.updateBundle(updatedBundle);
          } else {
            // Create an updated bundle keeping existing products
            final updatedBundle = existingBundle.copyWith(
              name: params.name ?? existingBundle.name,
              description: params.description ?? existingBundle.description,
              bundlePrice: params.bundlePrice ?? existingBundle.bundlePrice,
              isActive: params.isActive ?? existingBundle.isActive,
              updatedAt: DateTime.now(),
            );

            return repository.updateBundle(updatedBundle);
          }
        },
      );
    } catch (e) {
      return Left(ServerFailure(message: e.toString()));
    }
  }
}
