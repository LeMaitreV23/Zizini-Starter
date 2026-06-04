# Zizini Tech Stack & Module Specification

## Summary

Zizini will remain a Laravel-based production web application. The current Laravel app is the foundation, PostgreSQL is the approved production database, and the first production release will focus on three core modules: Admin, Reseller, and Marketplace Viewer.

The approved marketplace workflow is **auto-publish, verify later**. Approved resellers can publish listings immediately so the marketplace keeps moving, while admins retain moderation controls to verify, reject, feature, expire, or take down listings after publication.

## Approved Production Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Frontend:** Laravel Blade, HTML, CSS, and light JavaScript
- **Database:** PostgreSQL
- **ORM:** Laravel Eloquent
- **Authentication:** Laravel Breeze or Laravel Fortify
- **Authorization:** Laravel policies/gates plus `spatie/laravel-permission`
- **Roles:** Admin, Reseller, Viewer/Buyer, optional Super Admin
- **File uploads:** Laravel Filesystem
- **Image storage:** local server storage for first deployment; S3-compatible storage later
- **Cache, queues, and sessions:** Redis
- **Queue workers:** Laravel Queue with Supervisor
- **Scheduled tasks:** Laravel Scheduler for listing expiry and reminders
- **Email:** Laravel Mail using SMTP, Resend, or Mailgun
- **Contact channels:** phone, WhatsApp, and email
- **SMS/WhatsApp later:** Africa's Talking, WhatsApp Cloud API, or Twilio
- **Payments later:** M-Pesa Daraja API
- **Testing:** PHPUnit or Pest
- **Deployment:** Ubuntu VPS, Nginx, PHP-FPM, PostgreSQL, Redis, SSL, cron, and Supervisor
- **Monitoring:** Laravel logs, Sentry/Bugsnag, uptime checks, and database backups

## Admin Module

The Admin module manages the marketplace, seller access, moderation, and platform activity.

- Admin can log in securely.
- Admin can create, view, update, and delete listings.
- Admin can approve or reject reseller accounts.
- Admin can set reseller posting duration.
- Admin can set a default reseller posting duration.
- Admin can set reseller listing limits.
- Admin can set a default reseller listing limit.
- Admin can review listings after they are posted.
- Approved reseller listings auto-publish by default, then admin can verify them later.
- Admin can mark listings as verified, featured, rejected, expired, sold, or taken down.
- Admin can take down suspicious, expired, duplicate, or inappropriate listings.
- Admin can view reports submitted by marketplace viewers.
- Admin can view users, resellers, listings, contact activity, and marketplace activity.
- Admin can see reseller approval expiry dates and remaining listing allowances.
- Admin can view alerts for reported listings and expiring reseller approvals.
- Admin can manage livestock service categories, including **Artificial Insemination** where applicable.

Important wording decision: any previous "AI" label that refers to livestock services should be renamed to **Artificial Insemination**, not artificial intelligence.

## Reseller Module

The Reseller module lets approved livestock sellers publish and manage their own listings.

- Reseller can register and log in.
- New reseller waits for admin approval before posting.
- Approved reseller can create listings.
- Approved reseller listings auto-publish immediately, but remain unverified until admin reviews them.
- If reseller approval duration lapses, reseller can still log in and view dashboard, listings, status, history, and account details.
- If reseller approval duration lapses, reseller's active listings become inactive or expired based on the configured expiry rule.
- If reseller approval duration lapses, reseller cannot publish new active listings until renewed by admin.
- Reseller can manage own listings.
- Reseller can edit, mark sold, renew/request renewal, or archive own listings where allowed.
- Reseller can view listing status: draft, pending, active, unverified, verified, rejected, expired, sold, and taken down.
- Reseller can see remaining listing allowance and approval expiry date.
- Reseller can see contact counts such as phone clicks, WhatsApp clicks, and email inquiries.

## Marketplace Viewer Module

The Marketplace Viewer module allows public visitors to browse listings and contact sellers.

- Viewer can browse livestock listings without logging in.
- Viewer can filter listings by category, county, price, and status.
- Viewer can view listing details.
- Viewer can contact seller by phone, WhatsApp, or email.
- Viewer can report suspicious listings.
- Viewer can browse livestock services, including Artificial Insemination services if included as a category.
- Save/favorite listings can be added later if buyer accounts are introduced.

## Extra Features Worth Adding

- Listing expiry automation.
- Listing renewal requests.
- Report handling workflow.
- Seller verification badge.
- Featured listings.
- Image upload limits and compression.
- Audit log for admin actions.
- Soft deletes for listings and users.
- Basic anti-spam/rate limiting on contact and report forms.
- SEO-friendly listing pages.
- Admin dashboard analytics: total listings, active listings, expired listings, reports, resellers pending approval, and contact clicks.
- Terms, privacy policy, safety guide, and seller rules pages.

## Key Product Decision

Approved decision: **Auto-publish, verify later**.

Approved resellers can publish listings immediately so the marketplace keeps moving. Admin still has a moderation panel to verify, reject, feature, or take down listings after publication. This avoids bottlenecks while keeping safety controls in place.
