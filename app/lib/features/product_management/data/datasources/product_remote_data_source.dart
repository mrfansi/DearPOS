import 'dart:io';
import 'package:firebase_storage/firebase_storage.dart';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:csv/csv.dart';

import 'package:app/core/error/exceptions.dart';
import 'package:app/features/product_management/data/models/product_model.dart';
import 'package:app/features/product_management/data/models/bulk_upload_result.dart';
import 'package:app/features/product_management/data/models/product_bundle_model.dart';

// Konstanta header untuk bulk upload
const List<String> kBulkUploadHeaders = [
  'name', 
  'description', 
  'category', 
  'price', 
  'stock', 
  'minStock', 
  'barcode',
  'imageUrl',
  'expiryDate'
];

abstract class ProductRemoteDataSource {
  Future<List<ProductModel>> getProducts();
  Future<ProductModel> getProduct(String id);
  Future<ProductModel> createProduct(ProductModel product);
  Future<ProductModel> updateProduct(ProductModel product);
  Future<void> deleteProduct(String id);
  Future<List<ProductModel>> searchProducts(String query);
  Future<BulkUploadResult> bulkUploadProducts(File file);
  Future<ProductBundleModel> createBundle(ProductBundleModel bundle);
  Future<ProductBundleModel> updateBundle(ProductBundleModel bundle);
  Future<void> deleteBundle(String id);
  Future<List<ProductBundleModel>> getBundles();
  Future<ProductBundleModel> getBundle(String id);
}

class ProductRemoteDataSourceImpl implements ProductRemoteDataSource {
  final FirebaseFirestore firestore;
  final FirebaseStorage storage;

  ProductRemoteDataSourceImpl({
    required this.firestore,
    required this.storage,
  });

  @override
  Future<List<ProductModel>> getProducts() async {
    try {
      QuerySnapshot querySnapshot = await firestore
          .collection('products')
          .where('isDeleted', isEqualTo: false)
          .get();

      return querySnapshot.docs.map((doc) {
        Map<String, dynamic> data = doc.data() as Map<String, dynamic>;
        data['id'] = doc.id;
        return ProductModel.fromJson(data);
      }).toList();
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<ProductModel> getProduct(String id) async {
    try {
      DocumentSnapshot doc =
          await firestore.collection('products').doc(id).get();

      if (!doc.exists) {
        throw ServerException();
      }

      Map<String, dynamic> data = doc.data() as Map<String, dynamic>;
      data['id'] = doc.id;
      return ProductModel.fromJson(data);
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<ProductModel> createProduct(ProductModel product) async {
    try {
      Map<String, dynamic> productData = product.toJson();

      // Hapus ID jika ada (Firestore akan generate ID baru)
      productData.remove('id');

      // Tambahkan timestamp server
      productData['createdAt'] = FieldValue.serverTimestamp();
      productData['updatedAt'] = FieldValue.serverTimestamp();

      // Default isDeleted ke false
      productData['isDeleted'] = false;

      // Simpan ke Firestore
      DocumentReference docRef =
          await firestore.collection('products').add(productData);

      // Baca dokumen yang baru dibuat
      DocumentSnapshot newDoc = await docRef.get();

      // Konversi kembali ke ProductModel
      Map<String, dynamic> newProductData =
          newDoc.data() as Map<String, dynamic>;
      newProductData['id'] = newDoc.id;

      return ProductModel.fromJson(newProductData);
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<ProductModel> updateProduct(ProductModel product) async {
    try {
      Map<String, dynamic> productData = product.toJson();

      // Hapus ID dari data yang akan diupdate
      final id = productData.remove('id');

      // Update timestamp
      productData['updatedAt'] = FieldValue.serverTimestamp();

      // Update dokumen di Firestore
      await firestore.collection('products').doc(id).update(productData);

      // Ambil dokumen terbaru
      DocumentSnapshot updatedDoc =
          await firestore.collection('products').doc(id).get();

      Map<String, dynamic> updatedData =
          updatedDoc.data() as Map<String, dynamic>;
      updatedData['id'] = updatedDoc.id;

      return ProductModel.fromJson(updatedData);
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<void> deleteProduct(String id) async {
    try {
      await firestore.collection('products').doc(id).update({
        'isDeleted': true,
        'updatedAt': FieldValue.serverTimestamp(),
      });
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<List<ProductModel>> searchProducts(String query) async {
    try {
      QuerySnapshot querySnapshot = await firestore
          .collection('products')
          .where('isDeleted', isEqualTo: false)
          .where('name', isGreaterThanOrEqualTo: query.toLowerCase())
          .where('name', isLessThan: '${query.toLowerCase()}\uf8ff')
          .get();

      return querySnapshot.docs.map((doc) {
        Map<String, dynamic> data = doc.data() as Map<String, dynamic>;
        data['id'] = doc.id;
        return ProductModel.fromJson(data);
      }).toList();
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<BulkUploadResult> bulkUploadProducts(File file) async {
    List<String> errorMessages = [];
    List<ProductModel> uploadedProducts = [];
    Set<String> processedBarcodes = {};
    int skippedDuplicates = 0;

    try {
      // Validasi file
      if (!file.existsSync()) {
        throw ServerException();
      }

      // Validasi ekstensi file
      if (!file.path.toLowerCase().endsWith('.csv')) {
        throw ServerException();
      }

      // Upload file ke Firebase Storage untuk backup
      String fileName = 'bulk_uploads/${DateTime.now().millisecondsSinceEpoch}.csv';
      UploadTask uploadTask = storage.ref(fileName).putFile(file);
      
      // Tunggu upload selesai
      await uploadTask;
      
      // Baca konten file CSV
      String csvString = await file.readAsString();
      
      // Parse CSV
      List<List<dynamic>> csvTable = const CsvToListConverter().convert(csvString);
      
      // Validasi header
      if (csvTable.isEmpty || csvTable[0].length < kBulkUploadHeaders.length) {
        throw ServerException();
      }

      // Batch untuk menulis produk
      WriteBatch batch = firestore.batch();

      // Lewati header
      for (int rowIndex = 1; rowIndex < csvTable.length; rowIndex++) {
        try {
          // Validasi panjang baris
          if (csvTable[rowIndex].length < kBulkUploadHeaders.length) {
            throw Exception('Baris tidak lengkap');
          }

          // Konversi data ke Map
          Map<String, dynamic> productData = {};
          for (int i = 0; i < kBulkUploadHeaders.length; i++) {
            productData[kBulkUploadHeaders[i]] = csvTable[rowIndex][i];
          }

          // Validasi data produk
          if (productData['name'] == null || productData['name'].isEmpty) {
            throw Exception('Nama produk tidak boleh kosong');
          }

          // Cek duplikat berdasarkan barcode
          String barcode = productData['barcode'] ?? '';
          if (processedBarcodes.contains(barcode)) {
            skippedDuplicates++;
            continue;
          }
          processedBarcodes.add(barcode);

          // Tambahkan metadata
          productData['createdAt'] = FieldValue.serverTimestamp();
          productData['updatedAt'] = FieldValue.serverTimestamp();
          productData['isDeleted'] = false;
          
          // Referensi dokumen baru
          DocumentReference docRef = firestore.collection('products').doc();
          
          // Tambahkan ke batch
          batch.set(docRef, productData);
          
          // Konversi dan simpan untuk return
          productData['id'] = docRef.id;
          uploadedProducts.add(ProductModel.fromJson(productData));
        } catch (rowError) {
          // Catat error per baris
          errorMessages.add('Baris $rowIndex: ${rowError.toString()}');
        }
      }
      
      // Commit batch
      await batch.commit();
      
      return BulkUploadResult(
        totalRows: csvTable.length - 1,
        successfulUploads: uploadedProducts.length,
        skippedDuplicates: skippedDuplicates,
        errorMessages: errorMessages,
        uploadedProducts: uploadedProducts,
      );
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<ProductBundleModel> createBundle(ProductBundleModel bundle) async {
    try {
      Map<String, dynamic> bundleData = bundle.toJson();

      // Hapus ID jika ada (Firestore akan generate ID baru)
      bundleData.remove('id');

      // Tambahkan timestamp server
      bundleData['createdAt'] = FieldValue.serverTimestamp();
      bundleData['updatedAt'] = FieldValue.serverTimestamp();

      // Default isDeleted ke false
      bundleData['isDeleted'] = false;

      // Simpan ke Firestore
      DocumentReference docRef =
          await firestore.collection('bundles').add(bundleData);

      // Baca dokumen yang baru dibuat
      DocumentSnapshot newDoc = await docRef.get();

      // Konversi kembali ke ProductBundleModel
      Map<String, dynamic> newBundleData =
          newDoc.data() as Map<String, dynamic>;
      newBundleData['id'] = newDoc.id;

      return ProductBundleModel.fromJson(newBundleData);
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<ProductBundleModel> updateBundle(ProductBundleModel bundle) async {
    try {
      Map<String, dynamic> bundleData = bundle.toJson();

      // Hapus ID dari data yang akan diupdate
      final id = bundleData.remove('id');

      // Update timestamp
      bundleData['updatedAt'] = FieldValue.serverTimestamp();

      // Update dokumen di Firestore
      await firestore.collection('bundles').doc(id).update(bundleData);

      // Ambil dokumen terbaru
      DocumentSnapshot updatedDoc =
          await firestore.collection('bundles').doc(id).get();

      Map<String, dynamic> updatedData =
          updatedDoc.data() as Map<String, dynamic>;
      updatedData['id'] = updatedDoc.id;

      return ProductBundleModel.fromJson(updatedData);
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<void> deleteBundle(String id) async {
    try {
      await firestore.collection('bundles').doc(id).update({
        'isDeleted': true,
        'updatedAt': FieldValue.serverTimestamp(),
      });
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<List<ProductBundleModel>> getBundles() async {
    try {
      QuerySnapshot querySnapshot = await firestore
          .collection('bundles')
          .where('isDeleted', isEqualTo: false)
          .get();

      return querySnapshot.docs.map((doc) {
        Map<String, dynamic> data = doc.data() as Map<String, dynamic>;
        data['id'] = doc.id;
        return ProductBundleModel.fromJson(data);
      }).toList();
    } catch (e) {
      throw ServerException();
    }
  }

  @override
  Future<ProductBundleModel> getBundle(String id) async {
    try {
      DocumentSnapshot doc =
          await firestore.collection('bundles').doc(id).get();

      if (!doc.exists) {
        throw ServerException();
      }

      Map<String, dynamic> data = doc.data() as Map<String, dynamic>;
      data['id'] = doc.id;
      return ProductBundleModel.fromJson(data);
    } catch (e) {
      throw ServerException();
    }
  }
}
