import 'dart:typed_data';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:file_picker/file_picker.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';

class BulkUploadDialog extends StatelessWidget {
  const BulkUploadDialog({super.key});

  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title: const Text('Bulk Upload Products'),
      content: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          ElevatedButton.icon(
            icon: const Icon(Icons.upload_file),
            label: const Text('Choose File'),
            onPressed: () => _pickAndUploadFile(context),
          ),
        ],
      ),
    );
  }

  Future<void> _pickAndUploadFile(BuildContext context) async {
    // Simpan context di variable lokal
    final currentContext = context;
    
    FilePickerResult? result = await FilePicker.platform.pickFiles(
      type: FileType.custom,
      allowedExtensions: ['csv', 'xlsx'],
    );
    
    if (result != null && result.files.single.path != null) {
      final filePath = result.files.single.path!;
      
      if (!currentContext.mounted) return;
      
      currentContext.read<ProductBloc>().add(
        BulkUploadProductsEvent(filePath: filePath)
      );
      Navigator.pop(currentContext);
    }
  }

  List<Map<String, dynamic>> parseFile(Uint8List? fileBytes, String fileName) {
    // Implement your file parsing logic here
    return [];
  }
}
