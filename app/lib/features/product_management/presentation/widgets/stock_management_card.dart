import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:app/features/product_management/domain/entities/product.dart';
import 'package:app/features/product_management/presentation/bloc/product_bloc.dart';

class StockManagementCard extends StatelessWidget {
  final Product product;

  const StockManagementCard({super.key, required this.product});

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildStockHeader(),
            const SizedBox(height: 16),
            _buildStockInfo(),
            const SizedBox(height: 16),
            _buildStockMovements(),
            if (product.isLowStock) ...[
              const SizedBox(height: 16),
              _buildLowStockWarning(),
            ],
            const SizedBox(height: 16),
            _buildStockActions(context),
          ],
        ),
      ),
    );
  }

  Widget _buildStockHeader() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        const Text(
          'Stock Management',
          style: TextStyle(
            fontSize: 18,
            fontWeight: FontWeight.bold,
          ),
        ),
        Text(
          'Current Stock: ${product.stock}',
          style: TextStyle(
            fontSize: 16,
            fontWeight: FontWeight.w500,
            color: product.isLowStock ? Colors.red : Colors.black,
          ),
        ),
      ],
    );
  }

  Widget _buildStockInfo() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text('Minimum Stock Level: ${product.minStock}'),
        if (product.expiryDate != null)
          Text(
            'Expiry Date: ${product.expiryDate!.toString().split(' ')[0]}',
            style: TextStyle(
              color: product.expiryDate!.isBefore(DateTime.now())
                  ? Colors.red
                  : Colors.black,
            ),
          ),
      ],
    );
  }

  Widget _buildStockMovements() {
    if (product.stockMovements.isEmpty) {
      return const Text('No stock movements recorded');
    }

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Recent Stock Movements',
          style: TextStyle(
            fontSize: 16,
            fontWeight: FontWeight.w500,
          ),
        ),
        const SizedBox(height: 8),
        SizedBox(
          height: 150,
          child: ListView.builder(
            itemCount: product.stockMovements.length,
            itemBuilder: (context, index) {
              final movement = product.stockMovements[index];
              return ListTile(
                dense: true,
                leading: Icon(
                  movement.type == 'in' ? Icons.add : Icons.remove,
                  color: movement.type == 'in' ? Colors.green : Colors.red,
                ),
                title: Text(
                  '${movement.type == 'in' ? '+' : '-'}${movement.quantity}',
                  style: TextStyle(
                    color: movement.type == 'in' ? Colors.green : Colors.red,
                  ),
                ),
                subtitle: Text(movement.notes ?? ''),
                trailing: Text(
                  movement.timestamp.toString().split(' ')[0],
                  style: Theme.of(context).textTheme.bodySmall,
                ),
              );
            },
          ),
        ),
      ],
    );
  }

  Widget _buildLowStockWarning() {
    return Container(
      padding: const EdgeInsets.all(8),
      decoration: BoxDecoration(
        color: Colors.red.shade100,
        borderRadius: BorderRadius.circular(4),
      ),
      child: Row(
        children: [
          Icon(Icons.warning_amber_rounded, color: Colors.red.shade700),
          const SizedBox(width: 8),
          Text(
            'Low Stock Alert!',
            style: TextStyle(
              color: Colors.red.shade700,
              fontWeight: FontWeight.bold,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStockActions(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
      children: [
        ElevatedButton.icon(
          icon: const Icon(Icons.add),
          label: const Text('Add Stock'),
          onPressed: () => _showStockAdjustmentDialog(context, 'in'),
        ),
        ElevatedButton.icon(
          icon: const Icon(Icons.remove),
          label: const Text('Remove Stock'),
          onPressed: () => _showStockAdjustmentDialog(context, 'out'),
          style: ElevatedButton.styleFrom(
            backgroundColor: Colors.red,
          ),
        ),
      ],
    );
  }

  void _showStockAdjustmentDialog(BuildContext context, String type) {
    final quantityController = TextEditingController();
    final notesController = TextEditingController();

    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text('${type == 'in' ? 'Add' : 'Remove'} Stock'),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            TextField(
              controller: quantityController,
              decoration: const InputDecoration(
                labelText: 'Quantity',
              ),
              keyboardType: TextInputType.number,
            ),
            TextField(
              controller: notesController,
              decoration: const InputDecoration(
                labelText: 'Notes',
              ),
              maxLines: 2,
            ),
          ],
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () {
              final quantity = int.tryParse(quantityController.text);
              if (quantity != null && quantity > 0) {
                final updatedProduct = product.copyWith(stock: product.stock + (type == 'in' ? quantity : -quantity));
                context.read<ProductBloc>().add(
                      UpdateProductEvent(updatedProduct),
                    );
                Navigator.pop(context);
              }
            },
            child: const Text('Confirm'),
          ),
        ],
      ),
    );
  }
}
