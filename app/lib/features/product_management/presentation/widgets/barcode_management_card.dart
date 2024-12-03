import 'package:flutter/material.dart';
import 'dart:math';
import 'package:barcode_widget/barcode_widget.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

class BarcodeManagementCard extends StatefulWidget {
  final Product product;

  const BarcodeManagementCard({super.key, required this.product});

  @override
  State<BarcodeManagementCard> createState() => _BarcodeManagementCardState();
}

class _BarcodeManagementCardState extends State<BarcodeManagementCard> {
  final TextEditingController _barcodeController = TextEditingController();
  String _selectedBarcodeType = 'ean13';

  @override
  void initState() {
    super.initState();
    _barcodeController.text = widget.product.barcode ?? '';
  }

  @override
  void dispose() {
    _barcodeController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Barcode Management',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 16),
            _buildBarcodeInput(),
            const SizedBox(height: 16),
            _buildBarcodeTypeSelector(),
            const SizedBox(height: 16),
            if (_barcodeController.text.isNotEmpty) ...[
              _buildBarcodePreview(),
              const SizedBox(height: 16),
            ],
          ],
        ),
      ),
    );
  }

  Widget _buildBarcodeInput() {
    return TextFormField(
      controller: _barcodeController,
      decoration: InputDecoration(
        labelText: 'Barcode',
        hintText: 'Enter barcode number',
        suffixIcon: IconButton(
          icon: const Icon(Icons.refresh),
          onPressed: _generateBarcode,
          tooltip: 'Generate random barcode',
        ),
      ),
      onChanged: (value) {
        setState(() {});
        context.read<ProductBloc>().add(
              UpdateProductEvent(widget.product.copyWith(
                barcode: value,
              )),
            );
      },
    );
  }

  Widget _buildBarcodeTypeSelector() {
    return DropdownButtonFormField<String>(
      value: _selectedBarcodeType,
      decoration: const InputDecoration(
        labelText: 'Barcode Type',
      ),
      items: const [
        DropdownMenuItem(
          value: 'ean13',
          child: Text('EAN-13'),
        ),
        DropdownMenuItem(
          value: 'code128',
          child: Text('Code 128'),
        ),
      ],
      onChanged: (value) {
        setState(() {
          _selectedBarcodeType = value!;
        });
      },
    );
  }

  Widget _buildBarcodePreview() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Preview',
          style: TextStyle(
            fontSize: 16,
            fontWeight: FontWeight.w500,
          ),
        ),
        const SizedBox(height: 8),
        Center(
          child: Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(8),
              border: Border.all(color: Colors.grey.shade300),
            ),
            child: Column(
              children: [
                BarcodeWidget(
                  barcode: _selectedBarcodeType == 'ean13'
                      ? Barcode.ean13()
                      : Barcode.code128(),
                  data: _barcodeController.text,
                  width: 200,
                  height: 80,
                ),
                const SizedBox(height: 8),
                Text(
                  _barcodeController.text,
                  style: const TextStyle(fontSize: 12),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  void _generateBarcode() {
    final random = StringBuffer();
    if (_selectedBarcodeType == 'ean13') {
      // Generate 12 digits for EAN-13 (13th digit is check digit)
      for (var i = 0; i < 12; i++) {
        random.write((i == 0 ? Random().nextInt(9) + 1 : Random().nextInt(10))
            .toString());
      }
    } else {
      // Generate 12 random digits for Code 128
      for (var i = 0; i < 12; i++) {
        random.write(Random().nextInt(10).toString());
      }
    }
    setState(() {
      _barcodeController.text = random.toString();
    });
    context.read<ProductBloc>().add(
          UpdateProductEvent(widget.product.copyWith(
            barcode: _barcodeController.text,
          )),
        );
  }
}
