import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';

import 'package:app/core/error/exceptions.dart';
import 'package:app/features/product_management/data/models/product_model.dart';

abstract class ProductLocalDataSource {
  Future<List<ProductModel>> getLastProducts();
  Future<void> cacheProducts(List<ProductModel> products);
  Future<ProductModel?> getProduct(String id);
  Future<void> cacheProduct(ProductModel product);
  Future<void> deleteProduct(String id);
}

const cachedProducts = 'CACHED_PRODUCTS';

class ProductLocalDataSourceImpl implements ProductLocalDataSource {
  final SharedPreferences sharedPreferences;

  ProductLocalDataSourceImpl({required this.sharedPreferences});

  @override
  Future<List<ProductModel>> getLastProducts() {
    final jsonString = sharedPreferences.getString(cachedProducts);
    if (jsonString != null) {
      final List<dynamic> jsonList = json.decode(jsonString);
      return Future.value(
        jsonList.map((json) => ProductModel.fromJson(json)).toList(),
      );
    } else {
      throw CacheException(message: 'No cached products found');
    }
  }

  @override
  Future<void> cacheProducts(List<ProductModel> products) {
    return sharedPreferences.setString(
      cachedProducts,
      json.encode(products.map((product) => product.toJson()).toList()),
    );
  }

  @override
  Future<ProductModel?> getProduct(String id) {
    final jsonString = sharedPreferences.getString(cachedProducts);
    if (jsonString != null) {
      final List<dynamic> jsonList = json.decode(jsonString);
      final products =
          jsonList.map((json) => ProductModel.fromJson(json)).toList();
      final product = products.firstWhere(
        (product) => product.id == id,
        orElse: () => throw CacheException(message: 'Product not found'),
      );
      return Future.value(product);
    } else {
      throw CacheException(message: 'No cached products found');
    }
  }

  @override
  Future<void> cacheProduct(ProductModel product) async {
    final jsonString = sharedPreferences.getString(cachedProducts);
    if (jsonString != null) {
      final List<dynamic> jsonList = json.decode(jsonString);
      final products =
          jsonList.map((json) => ProductModel.fromJson(json)).toList();
      final index = products.indexWhere((p) => p.id == product.id);
      if (index >= 0) {
        products[index] = product;
      } else {
        products.add(product);
      }
      await cacheProducts(products);
    } else {
      await cacheProducts([product]);
    }
  }

  @override
  Future<void> deleteProduct(String id) async {
    final jsonString = sharedPreferences.getString(cachedProducts);
    if (jsonString != null) {
      final List<dynamic> jsonList = json.decode(jsonString);
      final products =
          jsonList.map((json) => ProductModel.fromJson(json)).toList();
      products.removeWhere((product) => product.id == id);
      await cacheProducts(products);
    }
  }
}
