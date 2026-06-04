# Zizini Production Security Checklist

## Code-Side Status

- Admin routes are protected by authentication and Admin/Super Admin role middleware.
- Seller routes are protected by authentication and seller-role middleware.
- Public inquiry, report, contact, login, and registration endpoints are rate limited.
- Public listing detail, inquiry, report, call, and WhatsApp routes only work for public listing statuses.
- Seller/admin image uploads reject SVG and only allow JPG, JPEG, PNG, and WebP.
- Composer dependency audit is clean as of the latest local scan.

## Must Do Before Uploading

- Do not upload the local `.env` file.
- Do not upload `storage/framework/sessions/*`.
- Do not upload `storage/logs/*.log`.
- Do not upload `bootstrap/cache/*.php` from the local machine.
- Do not upload `.runtime`.

## Production `.env` Requirements

Use these values as the minimum safe baseline:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://test.zizini.co.ke
SESSION_SECURE_COOKIE=true
LOG_LEVEL=warning
```

Generate a fresh server key on the VPS:

```bash
php artisan key:generate --force
```

Use a strong PostgreSQL password that is different from the local development password.

## Server Requirements

- Web root must point to `/var/www/zizini/public`, not `/var/www/zizini`.
- SSL must be enabled before public use.
- Nginx must not execute uploaded files from `public/assets/uploads`.
- File permissions should allow Laravel to write only to `storage`, `bootstrap/cache`, and intended upload folders.
- Database backups should be scheduled before real client data is collected.

## Remaining Production TODOs

- Replace demo seed passwords before real launch.
- Add real email delivery for contact/support forms.
- Add CAPTCHA or stronger spam protection if public forms start receiving spam.
- Move uploads to private/object storage later if seller uploads become heavy.
- Add centralized error monitoring such as Sentry or Bugsnag.
- Add automated tests for auth, seller access, listing visibility, and public form throttling.
