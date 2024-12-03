import 'package:equatable/equatable.dart';
import 'package:meta/meta.dart';

@immutable
class DeleteProductParams extends Equatable {
  final String id;

  const DeleteProductParams({required this.id});

  @override
  List<Object> get props => [id];
}
