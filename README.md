<div align="center">

# 🛡️ CodeVault

### High-Performance Snippet Management with Collaborative Vault Access

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Redis](https://img.shields.io/badge/Redis-Cache-DC382D?style=for-the-badge&logo=redis&logoColor=white)](https://redis.io)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-CSS-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

**CodeVault** is a production-grade snippet management platform engineered for developer teams. It goes beyond basic CRUD — featuring atomic cache invalidation, transactional file integrity, and a hybrid search engine that stays performant at scale.

[**Live Demo**](https://codevault.dushantha.me/) · [**Report Bug**](https://github.com/dushantha2000/codeMaster/issues) · [**Request Feature**](https://github.com/dushantha2000/codeMaster/issues)

</div>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Architecture Decisions](#-architecture-decisions)
- [Core Features](#-core-features)
- [Tech Stack](#-tech-stack)
- [Getting Started](#-getting-started)
- [Environment Variables](#-environment-variables)
- [API Reference](#-api-reference)
- [Author](#-author)

---

## 🔍 Overview

Most snippet managers are simple CRUD applications. CodeVault is built to solve the **real problems** that emerge when snippet libraries grow large and teams start collaborating:

| Problem | CodeVault's Solution |
|---|---|
| Cache invalidation at scale | Version-key strategy — O(1) complexity regardless of snippet count |
| Partial write failures | DB transactions wrap all multi-file operations |
| Slow search as data grows | Hybrid engine: B-Tree for prefix lookups, Full-Text for complex queries |
| N+1 queries on list views | Eager loading + explicit column selection (up to 70% less DB overhead) |
| Partner cache staleness | Version timestamps shared across user-partner relationships |

---

## ✨ Core Features

**📂 Multi-File Snippets** — Create snippets containing multiple files/modules, mirroring real-world project structures instead of single-file limitations.

**🤝 Shared Vaults (Vault Access)** — A granular permission system letting users grant specific partners read access to their vault. Partners see live-updated content thanks to shared cache versioning.

**🔍 Intelligent Discovery** — Filter by programming language, keywords, and creation date. The hybrid search engine keeps results fast as your library grows.

**⚡ Cursor-Paginated Dashboard** — `cursorPaginate` instead of `offset`-based pagination eliminates the performance cliff that hits at page 50+ on large datasets.

**🔒 Policy-Based Authorization** — Every route is gated through Laravel Policies, ensuring users can only mutate their own snippets, and partners are scoped correctly.

---

## 🛠️ Tech Stack

| Layer | Technology | Purpose |
|---|---|---|
| Framework | Laravel 11 / PHP 8.3+ | Application core, routing, ORM |
| Database | MySQL 8.0 | Persistent storage with Full-Text + B-Tree indexes |
| Cache | Redis via Laravel Cache | Versioned key invalidation, `rememberForever` |
| Frontend | Tailwind CSS | Utility-first styling |
| Interactivity | JavaScript / Axios | AJAX search without full-page reloads |
| Auth | Laravel Breeze | Session-based authentication |

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.3+
- Composer 2.x
- Node.js 18+ & npm
- MySQL 8.0
- Redis

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-username/codevault.git
cd codevault

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Set up the database
php artisan migrate

# 5. (Optional) Seed with sample data
php artisan db:seed

# 6. Start the development server
php artisan serve
```

Visit `http://localhost:8000` to get started.

---

## ⚙️ Environment Variables

| Variable | Default | Description |
|---|---|---|
| `DB_CONNECTION` | `mysql` | Database driver |
| `DB_HOST` | `127.0.0.1` | Database host |
| `DB_DATABASE` | `codevault` | Database name |
| `DB_USERNAME` | `root` | Database user |
| `DB_PASSWORD` | _(empty)_ | Database password |
| `CACHE_DRIVER` | `redis` | Must be `redis` for versioned caching |
| `REDIS_HOST` | `127.0.0.1` | Redis server host |
| `REDIS_PORT` | `6379` | Redis server port |
| `SESSION_DRIVER` | `database` | Session storage driver |

---

## 📡 API Reference

> CodeVault exposes internal JSON endpoints consumed by the frontend. All routes require authentication via session cookie.

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/snippets` | List authenticated user's snippets (cursor-paginated) |
| `POST` | `/snippets` | Create a new multi-file snippet |
| `GET` | `/snippets/{id}` | Retrieve a single snippet with files |
| `PUT` | `/snippets/{id}` | Update snippet (owner only) |
| `DELETE` | `/snippets/{id}` | Delete snippet and all associated files |
| `POST` | `/vaults/{userId}/access` | Grant vault access to a partner |
| `DELETE` | `/vaults/{userId}/access` | Revoke vault access |
| `GET` | `/search?q={term}` | Hybrid search across snippets |

---

## 👨‍💻 Author

**Dushantha Majith** — Full-Stack Developer

[![LinkedIn](https://img.shields.io/badge/LinkedIn-Connect-0A66C2?style=flat-square&logo=linkedin)](https://www.linkedin.com/in/dushantha-majith)
[![Portfolio](https://img.shields.io/badge/Portfolio-dushantha.me-000000?style=flat-square&logo=vercel)](https://dushantha.me)

---

<div align="center">
<sub>If this project helped you, consider giving it a ⭐</sub>
</div>
