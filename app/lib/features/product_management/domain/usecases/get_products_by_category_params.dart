import 'package:equatable/equatable.dart';

class GetProductsByCategoryParams extends Equatable {
  final String categoryId;
  final int? limit;
  final int? offset;

  const GetProductsByCategoryParams({
    required this.categoryId,
    this.limit,
    this.offset,
  });

  @override
  List<Object?> get props => [categoryId, limit, offset];
}
