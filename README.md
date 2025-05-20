# E‑Commerce REST API

A lightweight product & category catalog built with **Laravel 12**, secured by **Laravel Sanctum**, documented with **Swagger / OpenAPI 3** and  **MySQL** as a DB.

---

## ✨ Features

| Area                       | Details                                                                                   |
| -------------------------- | ----------------------------------------------------------------------------------------- |
| **Authentication**         | Token‑based via Laravel Sanctum (`/api/register`, `/api/login`).                          |
| **CRUD**                   | Full Create/Read/Update/Delete for Products & Categories.                                 |
| **Pagination & Filtering** | Query params: `per_page`, `category_id`, `min_price`, `max_price`, `sort_by`, `sort_dir`. |
| **Validation**             | Form‑request classes with granular rules (`Store*Request`, `Update*Request`).             |
| **Resources**              | Consistent `data / links / meta` JSON output through API Resources.                       |
| **Database**               | MySQL (tested on 8.x) – port **3307** in default `.env`.                                  |
| **Testing**                | PHPUnit feature tests + model factories & seeders.                                        |
| **Docs**                   | Interactive Swagger UI at `/api/documentation`.                                           |

---

## 🚀 Quick start

# 1. Clone & install
git clone https://github.com/Dzhemile-dzh/ecomerce-api.git

cd ecommerce-api

composer install

# 2. Environment
cp .env.example .env

php artisan key:generate

# 3. Database
php artisan migrate --seed

# 4. Serve
php artisan serve

---

## 🔑 Authentication flow

1. **Register**  
   `POST /api/register` → `{ name, email, password }`  
   ↳ returns `token` (Bearer)

2. **Login**  
   `POST /api/login` → `{ email, password }`  
   ↳ returns `token`

3. **Use token**  
   Add header `Authorization: Bearer <token>` to every protected request.

Sanctum stores tokens in `personal_access_tokens`; revoke with `$user->tokens()->delete()`.

---

## 🛣️ API map

| Method | Endpoint | Description | Query params |
|--------|----------|-------------|--------------|
| **\*Public\*** |  |  |  |
| GET | `/api/products` | List products (paginated) | `per_page`, `category_id`, `min_price`, `max_price`, `sort_by`, `sort_dir` |
| GET | `/api/products/{id}` | Product details | — |
| GET | `/api/categories` | List categories (paginated) | `per_page` |
| GET | `/api/categories/{id}` | Category details | — |
| **\*Protected\*** |  |  |  |
| POST | `/api/products` | Create product | — |
| PUT | `/api/products/{id}` | Update product | — |
| DELETE | `/api/products/{id}` | Delete product | — |
| POST | `/api/categories` | Create category | — |
| PUT | `/api/categories/{id}` | Update category | — |
| DELETE | `/api/categories/{id}` | Delete category | — |

---

## 🗄️ Database & seeders

* **Migrations:** located in `database/migrations` (_products_, _categories_, _users_).
* **Factories:**
  * `CategoryFactory` – unique name + sentence description.
  * `ProductFactory` – belongs to Category, random price & stock.
  * `UserFactory` – default password **`password`**.
* **Seeders:** `DatabaseSeeder` invokes individual seeders; adjust counts as required.

---

## 🧪 Running tests

```bash
php artisan test
```

---

## 📑 Swagger / OpenAPI docs

```bash
php artisan l5-swagger:generate
```

Open <http://localhost:8000/api/documentation> in your browser.

---

## 🏗️ Project structure

```
app/
  Http/
    Controllers/Api/…       ← Product, Category, Auth
    Requests/…              ← Store*/Update*Request
    Resources/…             ← ProductResource, CategoryResource
  Models/…
config/
database/
  factories/
  migrations/
  seeders/
routes/
  api.php
```

---

## 🖥️ Environment variables

```env
APP_NAME="Ecommerce API"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=product_db
DB_USERNAME=root
DB_PASSWORD=secret

SANCTUM_STATEFUL_DOMAINS=localhost:3000
```

## ✨ Demo
# Register
![image](https://github.com/user-attachments/assets/e6531845-c67e-48c1-aae2-1738a99394ed)

# Login
![login](https://github.com/user-attachments/assets/4fd531f7-9764-4f10-8493-f4409d9ae518)

# Categories
![categories-getId](https://github.com/user-attachments/assets/e1b50bbc-f555-42c0-b77e-1784fd4f3d98)
![categories-get](https://github.com/user-attachments/assets/356c65c7-f78f-45f0-abc8-846de166cdfc)
![categories-add](https://github.com/user-attachments/assets/8c7ff3a7-1ddd-4270-80e6-b6580c18edad)
![categories-delete](https://github.com/user-attachments/assets/785bf6ab-e899-4926-8060-03cb3b75b15c)
![categories-update](https://github.com/user-attachments/assets/dbadaf6b-5bd9-4411-92de-b67d56a67abc)


# Products
![products-getId](https://github.com/user-attachments/assets/9dadaf81-2bd4-4afe-a4d5-988e8e89a42b)
![products-get](https://github.com/user-attachments/assets/e941c521-da69-43c9-8302-2da4b00ac9f0)
![products-add](https://github.com/user-attachments/assets/eff0d34b-7ebf-4fa4-b936-8ee8c21edf54)
![products-update](https://github.com/user-attachments/assets/1fbb1f1a-683f-45e2-8437-01364c8b8d21)

# Filters
![image](https://github.com/user-attachments/assets/8c3f3e16-0f1f-4f6c-96c8-b38b20385f45)


# Swagger
![swagger](https://github.com/user-attachments/assets/ff2cfe9c-c971-4e4d-ba07-6c15ee836a47)




---
