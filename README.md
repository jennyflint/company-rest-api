## ⚙️ Setup & Installation

This project is configured to run using **Laravel** (Docker).

**1. Clone the repository:**
```bash
git clone https://github.com/jennyflint/company-rest-api.git
cd company-rest-api
cp .env.example .env
```

### 2. Start Docker containers
```bash
docker compose up -d --build
```

### 3. Install dependencies:
```bash
  composer install
```

### 4. Generate app key and run migrations:

```bash
php artisan key:generate
php artisan migrate
```

### 5. Database Seeding
```bash
php artisan db:seed --class=CompanySeeder
```
To completely clear the database, re-run migrations, and seed fresh data:
(Best for local development)
```bash
php artisan migrate:fresh --seed
```

# API Documentation
```POST /api/company```

Headers:
* Accept: application/json
* Content-Type: application/json

### Request Body:
```
{
    "name": "ТОВ Українська енергетична біржа",
    "edrpou": "37027819",
    "address": "01001, Україна, м. Київ, вул. Хрещатик, 44"
}
```