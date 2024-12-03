import 'package:get_it/get_it.dart';
import 'package:internet_connection_checker/internet_connection_checker.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:firebase_storage/firebase_storage.dart';

import 'package:app/features/product_management/data/datasources/product_local_data_source.dart';
import 'package:app/features/product_management/data/datasources/product_remote_data_source.dart';
import 'package:app/features/product_management/data/repositories/product_repository_impl.dart';
import 'package:app/features/product_management/domain/repositories/product_repository.dart';
import 'package:app/features/product_management/domain/usecases/get_products.dart';
import 'package:app/features/product_management/domain/usecases/create_product.dart';
import 'package:app/features/product_management/domain/usecases/update_product.dart';
import 'package:app/features/product_management/domain/usecases/delete_product.dart';
import 'package:app/features/product_management/domain/usecases/search_products.dart';
import 'package:app/features/product_management/domain/usecases/get_products_by_category.dart';
import 'package:app/features/product_management/domain/usecases/bulk_upload_products.dart';
import 'package:app/features/product_management/domain/usecases/get_bundles.dart';
import 'package:app/features/product_management/domain/usecases/get_bundle.dart';
import 'package:app/features/product_management/domain/usecases/create_bundle.dart';
import 'package:app/features/product_management/domain/usecases/update_bundle.dart';
import 'package:app/features/product_management/domain/usecases/delete_bundle.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';
import 'package:app/core/network/network_info.dart';

final sl = GetIt.instance;

Future<void> init() async {
  //! Features - Product Management
  // Bloc
  sl.registerFactory(
    () => ProductBloc(
      getProducts: sl(),
      createProduct: sl(),
      updateProduct: sl(),
      deleteProduct: sl(),
      searchProducts: sl(),
      getProductsByCategory: sl(),
      bulkUploadProducts: sl(),
      getBundles: sl(),
      getBundle: sl(),
      createBundle: sl(),
      updateBundle: sl(),
      deleteBundle: sl(),
    ),
  );

  // Use cases
  sl.registerLazySingleton(() => GetProducts(sl()));
  sl.registerLazySingleton(() => CreateProduct(sl()));
  sl.registerLazySingleton(() => UpdateProduct(sl()));
  sl.registerLazySingleton(() => DeleteProduct(sl()));
  sl.registerLazySingleton(() => SearchProducts(sl()));
  sl.registerLazySingleton(() => GetProductsByCategory(sl()));
  sl.registerLazySingleton(() => BulkUploadProducts(sl()));
  
  // Bundle use cases
  sl.registerLazySingleton(() => GetBundles(sl()));
  sl.registerLazySingleton(() => GetBundle(sl()));
  sl.registerLazySingleton(() => CreateBundle(sl()));
  sl.registerLazySingleton(() => UpdateBundle(sl()));
  sl.registerLazySingleton(() => DeleteBundle(sl()));

  // Repository
  sl.registerLazySingleton<ProductRepository>(
    () => ProductRepositoryImpl(
      remoteDataSource: sl(),
      localDataSource: sl(),
      networkInfo: sl(),
    ),
  );

  // Data sources
  sl.registerLazySingleton<ProductRemoteDataSource>(
    () => ProductRemoteDataSourceImpl(
      firestore: FirebaseFirestore.instance,
      storage: FirebaseStorage.instance,
    ),
  );
  
  sl.registerLazySingleton<ProductLocalDataSource>(
    () => ProductLocalDataSourceImpl(sharedPreferences: sl()),
  );

  //! Core
  sl.registerLazySingleton<NetworkInfo>(
    () => NetworkInfoImpl(sl()),
  );

  //! External
  final sharedPreferences = await SharedPreferences.getInstance();
  sl.registerLazySingleton(() => sharedPreferences);
  sl.registerLazySingleton(() => http.Client());
  sl.registerLazySingleton(() => InternetConnectionChecker());
}
