import 'package:equatable/equatable.dart';

abstract class BundleParams extends Equatable {
  const BundleParams();
}

class CreateBundleParams extends BundleParams {
  final String name;
  final String? description;
  final double bundlePrice;
  final List<String> productIds;
  final bool? isActive;

  const CreateBundleParams({
    required this.name,
    this.description,
    required this.bundlePrice,
    required this.productIds,
    this.isActive,
  });

  @override
  List<Object?> get props => [name, description, bundlePrice, productIds, isActive];
}

class UpdateBundleParams extends BundleParams {
  final String id;
  final String? name;
  final String? description;
  final double? bundlePrice;
  final List<String>? productIds;
  final bool? isActive;

  const UpdateBundleParams({
    required this.id,
    this.name,
    this.description,
    this.bundlePrice,
    this.productIds,
    this.isActive,
  });

  @override
  List<Object?> get props => [id, name, description, bundlePrice, productIds, isActive];
}

class DeleteBundleParams extends BundleParams {
  final String id;

  const DeleteBundleParams({required this.id});

  @override
  List<Object?> get props => [id];
}

class GetBundleParams extends BundleParams {
  final String id;

  const GetBundleParams({required this.id});

  @override
  List<Object?> get props => [id];
}

class GetBundlesParams extends BundleParams {
  final int? limit;
  final int? offset;
  final bool? isActive;

  const GetBundlesParams({
    this.limit,
    this.offset,
    this.isActive,
  });

  @override
  List<Object?> get props => [limit, offset, isActive];
}
