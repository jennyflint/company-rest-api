## ⚙️ Setup & Installation

This project is configured to run using **Laravel Sail** (Docker).

**1. Clone the repository:**
```bash
git clone <your-repo-url>
cd my-project
cp .env.example .env
```

### 2. Install dependencies:
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

### 3. Start Docker containers:
```bash
./vendor/bin/sail up -d
```

### 4. Generate app key and run migrations:

```bash
sail artisan key:generate
sail artisan migrate
```

### 5. Database Seeding
```bash
sail artisan db:seed --class=CompanySeeder
```
To completely clear the database, re-run migrations, and seed fresh data:
(Best for local development)
```bash
sail artisan migrate:fresh --seed
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