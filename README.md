# Multi-Tenant CRM Demo with Sprout

This repository contains the code for a demonstration CRM application built with Laravel and the Sprout package for multi-tenancy. The demo shows how to implement a multi-tenant architecture where tenant data is isolated within a single database while maintaining a single codebase.

![Welcome Page](screenshots/welcome-page.png)

## Features

- **Multi-tenant architecture** using the [Sprout Laravel package](https://sprout.ollieread.com/docs/1.x/installation)
- **Subdomain-based tenant identification**
- **Data isolation** within a single database
- **Automatic tenant detection**
- **Scoped data access** to prevent cross-tenant access

## Dashboard Preview

![Dashboard](screenshots/dashboard.png)

## Getting Started

Follow these steps to set up the application locally:

### Prerequisites

- PHP 8.1+
- Composer
- Node.js & NPM
- SQLIte or any other Laravel-supported database

### Installation

1. Clone the repository:
   ```bash
   git clone git@github.com:stevepop/crm-with-sprout.git
   cd crm-with-sprout
   ```

2. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

3. Update the `.env` file with your database credentials and the following settings:
   ```
   SESSION_DRIVER=file
   TENANTED_DOMAIN=your-local-domain
   ```

4. Install PHP dependencies:
   ```bash
   composer install
   ```

5. Install JavaScript dependencies:
   ```bash
   npm install
   ```

6. Generate application key:
   ```bash
   php artisan key:generate
   ```

7. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

8. Start the development server:
   ```bash
   php artisan serve
   ```

9. In a separate terminal, compile assets:
   ```bash
   npm run dev
   ```

## Using the Demo

You can access the demo using the following tenant subdomains:

```
tenant1.your-local-domain or tenant1.localhost
tenant2.your-local-domain or tenant2.localhost
```

For local development, you may need to update your hosts file to map these subdomains to your local IP.

## How It Works

The application uses Sprout middleware to resolve the current tenant based on the subdomain. While Sprout supports multiple resolution methods (subdomains, paths, headers, session, or cookies), this demo specifically uses the subdomain approach.

Once the tenant is identified, the application automatically scopes all database queries to the current tenant, ensuring data isolation between tenants.

## Implementation Details

The multi-tenant architecture is implemented using the [Sprout Laravel package](https://sprout.ollieread.com/docs/1.x/installation), which provides:

- Tenant resolution via subdomains
- Automatic query scoping for tenant data isolation
- Tenant-aware authentication
- Tenant-aware routes

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
