import 'package:equatable/equatable.dart';

abstract class Failure extends Equatable {
  @override
  List<Object> get props => [];
}

class ServerFailure extends Failure {}

class CacheFailure extends Failure {}

class NetworkFailure extends Failure {
  @override
  List<Object> get props => [];
}

class InvalidFileFailure extends Failure {
  @override
  List<Object> get props => [];
}

class ValidationFailure extends Failure {
  final String message;

  ValidationFailure({required this.message});

  @override
  List<Object> get props => [message];
}
