# API Documentation - DearPOS Laravel Backend

## Overview
Dokumentasi ini menjelaskan REST API endpoints yang tersedia di sistem DearPOS menggunakan Laravel backend.

## Base URL
```
Production: https://api.dearpos.com/v1
Staging: https://api-staging.dearpos.com/v1
Development: http://localhost:8000/api/v1
```

## Authentication
API menggunakan Laravel Sanctum dengan Bearer Token Authentication.

### Authentication Flow
1. Login endpoint menghasilkan token
2. Token digunakan untuk setiap request yang memerlukan otorisasi
3. Token memiliki masa berlaku dan dapat di-revoke

### Headers
```http
Authorization: Bearer <sanctum_token>
Content-Type: application/json
Accept: application/json
```

## Security Features
- JWT Token Authentication
- Role-Based Access Control (RBAC)
- Rate Limiting
- CSRF Protection
- Input Validation
- Encryption in Transit (HTTPS)

## API Endpoints

### Authentication Endpoints

#### Login
```http
POST /auth/login
```
Request Body:
```json
{
  "email": "user@dearpos.com",
  "password": "secure_password"
}
```
Response:
```json
{
  "access_token": "sanctum_token",
  "token_type": "Bearer",
  "expires_at": "2024-12-31T23:59:59Z",
  "user": {
    "id": "uuid",
    "name": "User Name",
    "email": "user@dearpos.com",
    "roles": ["admin", "pos_operator"]
  }
}
```

### Product Management

#### List Products
```http
GET /products
```
Query Parameters:
- `page`: Halaman hasil
- `per_page`: Jumlah item per halaman
- `search`: Pencarian berdasarkan nama/SKU
- `category`: Filter berdasarkan kategori
- `status`: Status produk (active/inactive)

Response:
```json
{
  "data": [
    {
      "id": "uuid",
      "name": "Produk Contoh",
      "sku": "PROD-001",
      "price": 100000,
      "stock": 50,
      "category": "Elektronik"
    }
  ],
  "meta": {
    "current_page": 1,
    "total_pages": 5,
    "total_items": 100
  }
}
```

#### Create Product
```http
POST /products
```
Request Body:
```json
{
  "name": "Produk Baru",
  "sku": "PROD-NEW-001",
  "description": "Deskripsi produk",
  "price": 150000,
  "stock": 100,
  "category_id": "uuid_kategori"
}
```

### Sales Transaction

#### Create Transaction
```http
POST /sales
```
Request Body:
```json
{
  "customer_id": "uuid_pelanggan",
  "items": [
    {
      "product_id": "uuid_produk",
      "quantity": 2,
      "price": 100000
    }
  ],
  "payment_method": "cash",
  "total_amount": 200000
}
```

### Reporting

#### Generate Sales Report
```http
GET /reports/sales
```
Query Parameters:
- `start_date`: Tanggal mulai
- `end_date`: Tanggal selesai
- `format`: Format laporan (pdf/csv)

## Error Handling

### Contoh Respon Error
```json
{
  "message": "Validation Error",
  "errors": {
    "email": ["Email tidak valid"],
    "password": ["Password minimal 8 karakter"]
  }
}
```

## Rate Limiting
- Maksimal 60 request per menit
- Berbeda untuk setiap role pengguna

## Versioning
- Versi saat ini: `v1`
- Backward compatibility dijamin
- Migrasi antar versi didokumentasikan

## Webhook
- Notifikasi real-time untuk transaksi
- Konfigurasi integrasi eksternal

## Dokumentasi Tambahan
- Swagger/OpenAPI Specification
- Postman Collection
- Contoh implementasi client
