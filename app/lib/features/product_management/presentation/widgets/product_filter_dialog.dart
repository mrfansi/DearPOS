import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';

class ProductFilterDialog extends StatefulWidget {
  const ProductFilterDialog({super.key});

  @override
  State<ProductFilterDialog> createState() => ProductFilterDialogState();
}

class ProductFilterDialogState extends State<ProductFilterDialog> {
  // Filter parameters
  RangeValues _priceRange = const RangeValues(0, 10000);
  RangeValues _stockRange = const RangeValues(0, 1000);
  bool _lowStockOnly = false;
  bool _outOfStockOnly = false;
  String _selectedCategory = 'All';
  DateTime? _expiryDateFrom;
  DateTime? _expiryDateTo;

  // Mock categories (replace with actual categories from your system)
  final List<String> _categories = [
    'All',
    'Electronics',
    'Clothing',
    'Food',
    'Beverages',
    'Stationery'
  ];

  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title: const Text('Advanced Product Filter'),
      content: SingleChildScrollView(
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Price Range Filter
            _buildRangeFilter(
              title: 'Price Range',
              values: _priceRange,
              min: 0,
              max: 10000,
              onChanged: (values) {
                setState(() {
                  _priceRange = values;
                });
              },
              formatValue: (value) => 'Rp ${value.toStringAsFixed(0)}',
            ),

            // Stock Range Filter
            _buildRangeFilter(
              title: 'Stock Range',
              values: _stockRange,
              min: 0,
              max: 1000,
              onChanged: (values) {
                setState(() {
                  _stockRange = values;
                });
              },
              formatValue: (value) => value.toStringAsFixed(0),
            ),

            // Category Dropdown
            const SizedBox(height: 16),
            const Text('Category',
                style: TextStyle(fontWeight: FontWeight.bold)),
            DropdownButton<String>(
              isExpanded: true,
              value: _selectedCategory,
              items: _categories.map((category) {
                return DropdownMenuItem(
                  value: category,
                  child: Text(category),
                );
              }).toList(),
              onChanged: (value) {
                setState(() {
                  _selectedCategory = value!;
                });
              },
            ),

            // Stock Status Filters
            const SizedBox(height: 16),
            CheckboxListTile(
              title: const Text('Low Stock Only'),
              value: _lowStockOnly,
              onChanged: (bool? value) {
                setState(() {
                  _lowStockOnly = value ?? false;
                });
              },
            ),
            CheckboxListTile(
              title: const Text('Out of Stock Only'),
              value: _outOfStockOnly,
              onChanged: (bool? value) {
                setState(() {
                  _outOfStockOnly = value ?? false;
                });
              },
            ),

            // Expiry Date Range
            const SizedBox(height: 16),
            const Text('Expiry Date Range',
                style: TextStyle(fontWeight: FontWeight.bold)),
            Row(
              children: [
                Expanded(
                  child: ElevatedButton(
                    onPressed: () async {
                      final DateTime? picked = await showDatePicker(
                        context: context,
                        initialDate: _expiryDateFrom ?? DateTime.now(),
                        firstDate: DateTime(2000),
                        lastDate: DateTime(2100),
                      );
                      if (picked != null) {
                        setState(() {
                          _expiryDateFrom = picked;
                        });
                      }
                    },
                    child: Text(_expiryDateFrom == null
                        ? 'From Date'
                        : '${_expiryDateFrom!.day}/${_expiryDateFrom!.month}/${_expiryDateFrom!.year}'),
                  ),
                ),
                const SizedBox(width: 8),
                Expanded(
                  child: ElevatedButton(
                    onPressed: () async {
                      final DateTime? picked = await showDatePicker(
                        context: context,
                        initialDate: _expiryDateTo ?? DateTime.now(),
                        firstDate: DateTime(2000),
                        lastDate: DateTime(2100),
                      );
                      if (picked != null) {
                        setState(() {
                          _expiryDateTo = picked;
                        });
                      }
                    },
                    child: Text(_expiryDateTo == null
                        ? 'To Date'
                        : '${_expiryDateTo!.day}/${_expiryDateTo!.month}/${_expiryDateTo!.year}'),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
      actions: [
        TextButton(
          onPressed: () => Navigator.of(context).pop(),
          child: const Text('Cancel'),
        ),
        ElevatedButton(
          onPressed: () {
            // Apply filters
            context.read<ProductBloc>().add(
                  FilterProducts(
                    minPrice: _priceRange.start,
                    maxPrice: _priceRange.end,
                    minStock: _stockRange.start.toInt(),
                    maxStock: _stockRange.end.toInt(),
                    category:
                        _selectedCategory == 'All' ? null : _selectedCategory,
                    lowStockOnly: _lowStockOnly,
                    outOfStockOnly: _outOfStockOnly,
                    expiryDateFrom: _expiryDateFrom,
                    expiryDateTo: _expiryDateTo,
                  ),
                );
            Navigator.of(context).pop();
          },
          child: const Text('Apply Filters'),
        ),
      ],
    );
  }

  Widget _buildRangeFilter({
    required String title,
    required RangeValues values,
    required double min,
    required double max,
    required void Function(RangeValues) onChanged,
    required String Function(double) formatValue,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 16),
        Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
        RangeSlider(
          values: values,
          min: min,
          max: max,
          divisions: 100,
          labels: RangeLabels(
            formatValue(values.start),
            formatValue(values.end),
          ),
          onChanged: onChanged,
        ),
      ],
    );
  }
}
