# RESTful API Laravel – Product Management

## 📌 Deskripsi Project

Project ini merupakan aplikasi **RESTful API Backend** yang dibuat menggunakan **Laravel** untuk mengelola data produk (Product Management). API ini menyediakan fitur CRUD (Create, Read, Update, Delete) dan menggunakan konsep:

* Model & Migration
* Form Request Validation
* API Resource
* API Resource Collection
* Pagination
* JSON Response Standard

API ini dapat diakses menggunakan tools seperti **Postman** atau diintegrasikan dengan frontend (Vue, React, Mobile App, dll).

---

## 🛠 Tools & Teknologi

* PHP
* Laravel
* MySQL
* Composer
* Postman

---

## 📂 Struktur Fitur

Project ini memiliki fitur utama:

* Menampilkan semua data products (pagination)
* Menampilkan detail product berdasarkan ID
* Menambahkan product baru
* Mengupdate product
* Menghapus product

---

## 🗄 Struktur Database – Tabel `products`

| Field       | Type            | Keterangan       |
| ----------- | --------------- | ---------------- |
| id          | bigint unsigned | Primary Key      |
| name        | varchar(255)    | Nama produk      |
| description | text            | Deskripsi produk |
| price       | decimal(10,2)   | Harga produk     |
| stock       | int             | Stok produk      |
| image       | varchar(255)    | Path gambar      |
| created_at  | timestamp       | Waktu dibuat     |
| updated_at  | timestamp       | Waktu diupdate   |

---

## 🚀 Cara Instalasi

1. Clone project

```
git clone <repository-url>
```

2. Masuk ke folder project

```
cd laravel-api
```

3. Install dependency

```
composer install
```

4. Copy file environment

```
cp .env.example .env
```

5. Setting database di file `.env`

6. Generate key

```
php artisan key:generate
```

7. Jalankan migration

```
php artisan migrate
```

8. Jalankan server

```
php artisan serve
```

---

## 📡 Endpoint API

Base URL:

```
http://127.0.0.1:8000/api/products
```

### 1️⃣ GET – Menampilkan Semua Product

```
GET /api/products
```

### 2️⃣ GET – Detail Product

```
GET /api/products/{id}
```

### 3️⃣ POST – Tambah Product

```
POST /api/products
```

Body (raw JSON):

```json
{
  "name": "Laptop",
  "description": "Laptop Gaming",
  "price": 15000000,
  "stock": 10
}
```

### 4️⃣ PUT – Update Product

```
PUT /api/products/{id}
```

### 5️⃣ DELETE – Hapus Product

```
DELETE /api/products/{id}
```

---

## 📦 Konsep yang Digunakan

### 🔹 Model & Migration

Model digunakan untuk merepresentasikan tabel di database, sedangkan migration digunakan untuk membuat struktur tabel.

### 🔹 Form Request (ProductRequest)

Digunakan untuk validasi input agar data yang masuk sesuai aturan.

Contoh rules:

* name → required, string, max 255
* price → required, numeric
* stock → required, integer, min 0
* image → required, image, max 2MB

### 🔹 API Resource (ProductResource)

Digunakan untuk mengatur format JSON response untuk satu data product.

### 🔹 API Resource Collection (ProductCollection)

Digunakan untuk mengatur response banyak data sekaligus dan menambahkan metadata pagination.

---

## 🎯 Tujuan Project

* Memahami konsep RESTful API
* Memahami arsitektur backend Laravel
* Mengimplementasikan validasi data
* Mengelola response JSON yang terstruktur
* Menggunakan pagination

---

## ✅ Kelebihan RESTful API

* Backend & frontend terpisah
* Bisa digunakan untuk web & mobile
* Response ringan (JSON)
* Mudah dikembangkan
* Scalable

---

## ⚠ Kekurangan

* Tidak memiliki tampilan (hanya backend)
* Membutuhkan autentikasi tambahan untuk keamanan
* Harus dikelola dengan baik agar endpoint tetap konsisten

---

## 👨‍💻 Author

Xixiqo

---
