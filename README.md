# SHOW.TV - Streaming & Management Platform

A web application built with **Laravel**, **Bootstrap 5**, **jQuery**, and **Spatie Translatable / Media Library** for managing and streaming TV shows and episodes.

---

## Features

- **Authentication & User Profiles**: User registration with avatar upload via Spatie Media Library, login, and logout.
- **TV Shows**: Browse paginated TV shows list, view show details, view related episodes, and follow/unfollow shows.
- **Episodes**: View episode details, duration, airing times, thumbnail, and stream video content (authentication required).
- **Interactions**: Like / Dislike reactions on episodes with toggle/removal support.
- **Dynamic Navigation**: Navbar featuring 5 random TV shows on each page request and quick search bar.
- **Search**: Search across TV Shows and Episodes by title and description, supporting Spatie Translatable JSON fields in English & Arabic.
- **Admin Area (Role Protection)**:
  - Admin Dashboard accessible strictly to users with `role = 'admin'`.
  - **Users Management**: Read-only listing and detailed profile view of registered users.
  - **TV Shows CRUD**: List, Create, View, and Edit TV series with bilingual titles and descriptions.
  - **Episodes CRUD**: List, Create, View, and Edit episodes with TV show association, thumbnail/video upload or URL management, and reaction stats.

---

## Architecture

The project strictly adheres to the **Controller → Service → Repository → Model** architectural pattern:

- **Controllers**: Thin controllers handling HTTP requests and view rendering.
- **Services**: Business logic execution and data orchestration (e.g. file upload handling, auth, reactions, search).
- **Repositories**: Database access and Eloquent query encapsulation with contract interfaces.
- **Models**: Eloquent models with Spatie Translatable and Spatie Media Library traits.

---

## Setup & Installation

### 1. Requirements
- PHP 8.2+
- Composer
- SQLite / MySQL / PostgreSQL

### 2. Installation Steps

1. Clone the repository and install Composer dependencies:
   ```bash
   composer install
   ```

2. Copy environment file and setup database:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Configure database in `.env` (SQLite is enabled by default in `.env.example`).

4. Run migrations and seed default Admin user:
   ```bash
   php artisan migrate --seed
   ```

   *This executes the `AdminUserSeeder`, creating default admin credentials:*
   - **Email**: `admin@show.tv`
   - **Password**: `password`
   - **Role**: `admin`

5. Create storage symbolic link:
   ```bash
   php artisan storage:link
   ```

6. Start local development server:
   ```bash
   php artisan serve
   ```

---

## Running Tests

Execute the full automated test suite covering authentication, admin authorization, user features, search, and TV Show / Episode CRUD:

```bash
php artisan test
```

---

## Tech Stack
- **Backend Framework**: Laravel
- **Frontend Stack**: Laravel Blade, Bootstrap 5, Bootstrap Icons, jQuery
- **Media Management**: Spatie Media Library
- **Localization**: Spatie Translatable (JSON column translation without separate tables)
