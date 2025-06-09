# Price Observer

- This service allows users to subscribe to changes for items.
- Users provide a listing URL and their email, then receive a confirmation email.
- After confirming the subscription, they receive notifications when the price changes.

## Installation

### Clone

```bash
git clone https://github.com/tea-aroma/price-observer.git
```

```bash
cd price-observer/
```

---

### Environment

Copy the example `.env` file:

```bash
cp .env.example .env
```

Update `.env` with your custom values.

#### Database

```dotenv
DB_CONNECTION=pgsql
DB_HOST=price_observer_postgres
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

#### Cache & Queue (Redis)

```dotenv
QUEUE_CONNECTION=redis

CACHE_STORE=redis

REDIS_HOST=redis
```

#### Other

```dotenv
APP_URL=http://localhost:8000
```

Notice: For the `email` process enable, update properties for mail.

---

### Docker

Build and start the containers:

```bash
docker compose up -d --build
```

Notice: Make sure Docker and Docker Compose are installed and running on your system.

---

### Laravel

Install dependencies:

```bash
docker compose exec app composer install
```

Generate the application key:

```bash
docker compose exec app php artisan key:generate
```

Run tests:

```bash
docker compose exec app php artisan test
```

Run migrations:

```bash
docker compose exec app php artisan migrate
```

Run seeder:

```bash
docker compose exec app php artisan db:seed --class=DatabaseSeeder 
```

Now the project should be available at: http://localhost:8000

---

## Routes

### Available routes

| URL                   | Description                  |
|-----------------------|------------------------------|
| `recipient/subscribe` | Subscribes recipient to item |
| `recipient/confirm`   | Confirms recipient by token  |
