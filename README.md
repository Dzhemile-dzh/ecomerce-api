# E‑Commerce REST API (Laravel 10)

A lightweight product & category catalog built with **Laravel 10**, secured by **Laravel Sanctum**, documented with **Swagger / OpenAPI 3** and backed by **MySQL**.

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

$$
# 1. Clone & install
git clone https://github.com/Dzhemile-dzh/ecomerce-api.git
cd ecommerce-api
composer install

# 2. Environment
cp .env.example .env
# → tweak the DB_ keys to match your local MySQL (port 3307 by default)

php artisan key:generate

# 3. Database
php artisan migrate --seed   # runs migrations + DatabaseSeeder

# 4. Serve
php artisan serve            # http://localhost:8000
```


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

Feature tests live in `tests/Feature` and reset the database with `RefreshDatabase`.

---

## 📑 Swagger / OpenAPI docs

```bash
php artisan l5-swagger:generate
```

Open <http://localhost:8000/api/documentation> in your browser.

---

## 🔒 Security

| Measure | Notes |
|---------|-------|
| **Rate limiting** | `60 req/min` per user/IP via `RouteServiceProvider`. |
| **Auth tokens** | Stored hashed; revoke via Sanctum API. |
| **Validation** | All input passes through dedicated `FormRequest` classes. |
| **Headers** | Uses Laravel defaults: CSRF disabled for `api` middleware group (tokens instead). |

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

---