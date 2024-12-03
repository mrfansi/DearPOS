import 'package:flutter/material.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'firebase_options.dart';

// Product Management
import 'package:app/features/product_management/presentation/pages/product_list_page.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';
import 'package:app/features/product_management/domain/usecases/get_products.dart';
import 'package:app/features/product_management/domain/usecases/create_product.dart';
import 'package:app/features/product_management/domain/usecases/update_product.dart';
import 'package:app/features/product_management/domain/usecases/delete_product.dart';
import 'package:app/features/product_management/domain/usecases/search_products.dart';
import 'package:app/features/product_management/domain/usecases/get_products_by_category.dart';
import 'package:app/features/product_management/domain/usecases/bulk_upload_products.dart';
import 'package:app/features/product_management/domain/usecases/create_bundle.dart';
import 'package:app/features/product_management/domain/usecases/update_bundle.dart';
import 'package:app/features/product_management/domain/usecases/delete_bundle.dart';
import 'package:app/features/product_management/domain/usecases/get_bundle.dart';
import 'package:app/features/product_management/domain/usecases/get_bundles.dart';
import 'package:app/core/injection/injection_container.dart' as di;

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await di.init();  // Initialize dependencies first
  await Firebase.initializeApp(
    options: DefaultFirebaseOptions.currentPlatform,
  );
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MultiBlocProvider(
      providers: [
        BlocProvider<ProductBloc>(
          create: (context) => ProductBloc(
            getProducts: di.sl<GetProducts>(),
            createProduct: di.sl<CreateProduct>(),
            updateProduct: di.sl<UpdateProduct>(),
            deleteProduct: di.sl<DeleteProduct>(),
            searchProducts: di.sl<SearchProducts>(),
            getProductsByCategory: di.sl<GetProductsByCategory>(),
            bulkUploadProducts: di.sl<BulkUploadProducts>(),
            createBundle: di.sl<CreateBundle>(),
            updateBundle: di.sl<UpdateBundle>(),
            deleteBundle: di.sl<DeleteBundle>(),
            getBundle: di.sl<GetBundle>(),
            getBundles: di.sl<GetBundles>(),
          )..add(const GetProductsEvent()),
        ),
      ],
      child: MaterialApp(
        title: 'DearPOS',
        theme: ThemeData(
          colorScheme: ColorScheme.fromSeed(seedColor: Colors.blue),
          useMaterial3: true,
        ),
        home: const ProductListPage(),
      ),
    );
  }
}
