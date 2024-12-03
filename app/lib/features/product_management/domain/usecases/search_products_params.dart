import 'package:equatable/equatable.dart';

class SearchProductsParams extends Equatable {
  final String? query;
  final List<String>? categories;
  final double? minPrice;
  final double? maxPrice;
  final bool? isActive;

  const SearchProductsParams({
    this.query,
    this.categories,
    this.minPrice,
    this.maxPrice,
    this.isActive,
  });

  @override
  List<Object?> get props => [query, categories, minPrice, maxPrice, isActive];
}
