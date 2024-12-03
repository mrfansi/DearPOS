import 'package:flutter/material.dart';

class ProductFilter extends StatelessWidget {
  const ProductFilter({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      scrollDirection: Axis.horizontal,
      padding: const EdgeInsets.symmetric(horizontal: 16),
      child: Row(
        children: [
          _buildFilterChip(
            label: 'All Products',
            selected: true,
            onSelected: (bool selected) {
              // Handle filter selection
            },
          ),
          const SizedBox(width: 8),
          _buildFilterChip(
            label: 'Low Stock',
            selected: false,
            onSelected: (bool selected) {
              // Handle filter selection
            },
          ),
          const SizedBox(width: 8),
          _buildFilterChip(
            label: 'Out of Stock',
            selected: false,
            onSelected: (bool selected) {
              // Handle filter selection
            },
          ),
          const SizedBox(width: 8),
          _buildFilterChip(
            label: 'Recently Added',
            selected: false,
            onSelected: (bool selected) {
              // Handle filter selection
            },
          ),
          const SizedBox(width: 8),
          _buildFilterChip(
            label: 'Price: High to Low',
            selected: false,
            onSelected: (bool selected) {
              // Handle filter selection
            },
          ),
          const SizedBox(width: 8),
          _buildFilterChip(
            label: 'Price: Low to High',
            selected: false,
            onSelected: (bool selected) {
              // Handle filter selection
            },
          ),
        ],
      ),
    );
  }

  Widget _buildFilterChip({
    required String label,
    required bool selected,
    required Function(bool) onSelected,
  }) {
    return FilterChip(
      label: Text(label),
      selected: selected,
      onSelected: onSelected,
      selectedColor: Colors.blue.withOpacity(0.25),
      checkmarkColor: Colors.blue,
    );
  }
}
