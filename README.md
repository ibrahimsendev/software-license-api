# Software License Management REST API

This project is a Laravel 12-based RESTful API application that enables users to purchase digital software licenses, list their acquired licenses, and manage stock inventory efficiently.

---

## Technical Features & Architecture

- **Framework:** Laravel 12 (PHP 8.3+)
- **Database:** MySQL / SQLite
- **Architecture:** RESTful API, Service-Repository Pattern, Thin Controllers
- **Data Integrity & Security:** Database Transactions, Pessimistic Locking (`lockForUpdate` - Race Condition Protection)
- **Asynchronous Processing:** Laravel Queues & Jobs (`SendLicenseEmailJob`)
- **CLI Reporting:** Custom Artisan Command (`report:stock`)

---

## Installation & Setup Guide

### 1. Install Project Dependencies
```bash
composer install
```

### 2. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Update your database credentials and set the queue connection in your `.env` file:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=software_license_api
DB_USERNAME=root
DB_PASSWORD=
```

```bash
QUEUE_CONNECTION=database
```

### 3. Run Database Migrations & Seeders
```bash
php artisan migrate:fresh --seed
```

### 4. Start the Application Server & Queue Worker

**Development Server:**
```bash
php artisan serve
```

**Queue Worker (for background jobs):**
```bash
php artisan queue:work
```

---

## API Endpoints

All responses are formatted and returned using Eloquent API Resources.
**[Postman Collection - Software License Management API](https://www.postman.com/ibrahim-sen/workspace/software-license-management-api/collection/40401228-e81c8d85-98c5-4cc9-b410-2fac00f9a1cf?action=share&source=copy-link&creator=40401228)**

### 1. List Users
- **URL:** `GET /api/users`
- **Description:** Retrieves all registered users in the system.

---

### 2. List Products & Available Stock
- **URL:** `GET /api/products`
- **Description:** Retrieves all products alongside their available stock count (`available_stock` where `user_id = NULL`).

---

### 3. List User Licenses
- **URL:** `GET /api/users/{user}/licenses`
- **Description:** Retrieves all licenses purchased by the specified user (uses Route Model Binding).

---

### 4. Create Order / Purchase License
- **URL:** `POST /api/orders`
- **Description:** Assigns the first available license key of the specified product to the user.
- **Headers:** `Content-Type: application/json`, `Accept: application/json`

**Request Body:**
```json
{
  "user_id": 1,
  "product_id": 2
}
```

**Success Response (201 Created):**
```json
{
  "message": "Order processed successfully and license assigned.",
  "data": {
    "id": 5,
    "license_key": "A1B2-C3D4-E5F6-G7H8",
    "assigned_user_id": 1,
    "purchased_at": "2026-09-24 21:00:00"
  }
}
```

**Error Response (422 Unprocessable Entity - Out of Stock or Invalid ID):**
```json
{
  "message": "Validation failed.",
  "errors": {
    "product_id": [
      "No available licenses in stock for this product."
    ]
  }
}
```

---

## Stock Reporting Command (CLI)

System administrators can run the following custom Artisan command to display products with available stock count **below 5** in a clean console table:

```bash
php artisan report:stock
```

**Sample Console Output:**
```text
+----+---------------------+-----------+-----------------+
| ID | Product Name        | Price ($) | Available Stock |
+----+---------------------+-----------+-----------------+
| 2  | Windows 11 Pro      | 129.00    | 3               |
| 3  | Antivirus Security  | 49.00     | 4               |
+----+---------------------+-----------+-----------------+
```