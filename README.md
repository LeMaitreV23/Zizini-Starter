# Zizini.co.ke Laravel MVP

Zizini.co.ke is a simplified livestock listing and contact marketplace for Kenya. This MVP intentionally excludes online payments, checkout, cart, escrow, M-Pesa callbacks, transaction records, and revenue dashboards.

## Run Locally

This workspace includes a local portable PHP runtime in `.runtime/php` after setup. If you already have PHP 8.2+ on PATH, the normal commands work:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Open `http://127.0.0.1:8000`.

If system PHP is not on PATH, use the bundled runtime:

```powershell
.\.runtime\php\php.exe .\.runtime\composer.phar install
.\.runtime\php\php.exe artisan serve --host=127.0.0.1 --port=8001
```

Open `http://127.0.0.1:8001`.

## Key Files

- Routes: `routes/web.php`
- Demo data: `config/zizini-demo-data.php`
- Public views: `resources/views/public`
- Seller views: `resources/views/seller`
- Admin views: `resources/views/admin`
- Guide page: `resources/views/guide/index.blade.php`
- Brand assets: `public/assets/brand`
- Placeholder livestock images: `public/assets/placeholders`
- PostgreSQL-ready schema: `database/migrations/2026_05_23_000001_create_zizini_mvp_tables.php`

## Brand Editing

Replace the logo files in `public/assets/brand`:

- `logo-primary.png`
- `logo-symbol.png`
- `logo-primary-white-bg.png`
- `coming-soon-web.png`

Edit brand colors in:

- `resources/views/components/layouts/main.blade.php`
- `resources/views/components/layouts/admin.blade.php`

The current colors are Pasture Green `#2F6B3D`, Fresh Green `#7FBF3F`, Cream `#F6F1E7`, Earth Brown `#7A5C3E`, Charcoal `#1F1F1F`, Trust Blue `#2D6CDF`.

## Future Payment Integration Note

If payments are added later, keep them isolated in new routes/controllers/modules. Do not mix billing fields into the current listing/contact flow until the client approves the payment model.
