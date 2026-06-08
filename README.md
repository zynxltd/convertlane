# ConvertLane

Performance affiliate network marketing site built with **Laravel 13**, **Blade**, **Tailwind CSS 4**, and **Alpine.js**. Tracking and partner management run on **Affise** (configured separately).

## Brand

| | |
|---|---|
| **Name** | ConvertLane |
| **Tagline** | Scale What Converts |
| **Positioning** | CPA / CPL / CPS network for finance, iGaming, health, SaaS, e-commerce |
| **Stack** | Laravel + Blade + Tailwind 4 + Alpine.js (not Next.js) |

### Run the frontend

```bash
npm run dev    # development (required for live CSS if not built)
# or
npm run build  # production assets → public/build/
```

Visit **https://network.test** (Herd). If the site looks unstyled, run `npm run build` or `npm run dev`.

## Pages

- `/` — Home (CRO-focused landing)
- `/advertisers` · `/publishers` · `/offers` · `/verticals` · `/about`
- `/apply` — Partner application (stored locally + Affise API stub)
- `/contact` · `/blog` · Legal pages · `/sitemap.xml`

## Setup

See **[SETUP.md](SETUP.md)** for the full launch checklist: Affise, Wise Business payouts, agreements, IOs, compliance, and ops.

```bash
composer install
npm install
cp .env.example .env   # if needed
php artisan key:generate
php artisan migrate
npm run dev            # or npm run build for production
```

With [Laravel Herd](https://herd.laravel.com), the site is available at **https://network.test**.

## Company documentation (internal)

Full operating pack for a **5-person team**: roles, policies, agreements, IOs, payouts, compliance — **`docs/company/`** (start at [README](docs/company/README.md)).

## Due diligence (internal)

Strict KYC/KYB process — stage-based client & compliance docs in **`docs/due-diligence/onboarding/`** (index: [README](docs/due-diligence/onboarding/README.md)); policies in **`docs/due-diligence/`** and **`docs/company/`**.

```env
COMPLIANCE_ACCESS_KEY=your-long-random-secret
```

Portal: `https://network.test/compliance?key=YOUR_KEY`

- Applications open a DD review automatically
- Affise sync only after Compliance + AM (+ Finance for advertisers) sign-off

## Affise integration

Set API credentials in `.env`. Approved applications can be pushed via `App\Services\AffiseService`. See `config/services.php` and `SETUP.md` Phase 2.

## Legal

Website summaries: `/privacy`, `/terms`, `/affiliate-agreement`, `/advertiser-agreement`, `/io-template`.  
Full templates: **`docs/company/`** — require solicitor review before production use.
