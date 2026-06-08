# ConvertLane — Affiliate Network Setup Guide

**Brand:** ConvertLane · **Tagline:** Scale What Converts  
**Stack:** Laravel (marketing site + applications) · **Tracking:** Affise · **Payouts:** Wise Business

> Legal documents in `/privacy`, `/affiliate-agreement`, etc. are **drafts**. Have a solicitor review before going live.

---

## Phase 1 — Brand & domain

- [ ] Register domain (e.g. `convertlane.co.uk`, `convertlane.io`)
- [ ] Configure DNS on Cloudflare (SSL, caching, WAF)
- [ ] Set up Herd local site → point production to Laravel host (Forge, Vapor, or VPS)
- [ ] Create logo suite (SVG, favicon, OG image 1200×630)
- [ ] Register social handles (LinkedIn, X)
- [ ] Update `config/brand.php` and `.env` with real contact details

---

## Phase 1b — Offers CMS (public catalogue)

Demo offers were removed from `config/offers.php`. Manage live programmes in the database:

```env
CMS_ACCESS_KEY=your_long_random_secret
```

- [ ] Run migrations: `php artisan migrate`
- [ ] Open **`/admin/offers?key=YOUR_CMS_ACCESS_KEY`**
- [ ] Add offers and tick **Published on website** when ready
- [ ] Homepage brand marquee pulls from published offers automatically

---

## Phase 2 — Affise platform (internal ops — not on public site)

- [ ] Sign Affise contract (Cloud / Enterprise tier based on volume)
- [ ] Provision Affise instance: `panel.convertlane.co.uk`, `track.convertlane.co.uk`
- [ ] Create Admin API key → add to `.env`:
  ```env
  AFFISE_API_URL=https://api.affise.com
  AFFISE_API_KEY=your_api_key
  AFFISE_TRACKING_URL=https://track.convertlane.co.uk
  AFFISE_PANEL_URL=https://panel.convertlane.co.uk
  ```
- [ ] Configure postback URL templates for advertisers
- [ ] Set up conversion statuses (pending, approved, declined, hold)
- [ ] Enable fraud features (IP duplicate, proxy detection, cap alerts)
- [ ] Create offer categories matching verticals in `config/brand.php`
- [ ] Wire `App\Services\AffiseService` to sync approved applications → Affise partners
- [ ] Set Offer18 login API in `.env` (`OFFER18_MID`, `OFFER18_API_KEY`, `OFFER18_SECRET_KEY`) — see [Login API](https://knowledgebase.offer18.com/network/network-api/login-api)
- [ ] Set `PARTNER_PANEL_URL` / `ADVERTISER_PANEL_URL` (publisher → `https://convertlane.offer18.com`, advertiser → `https://convertlane.offer18.com/m`)
- [ ] Test click → conversion → postback end-to-end

---

## Phase 3 — Company & banking (Wise Business)

- [ ] Register UK Ltd (or appropriate entity) — Companies House
- [ ] Open **Wise Business** account (multi-currency GBP, EUR, USD)
- [ ] Order Wise Business debit card for ops expenses
- [ ] Collect W-8BEN-E / VAT details from international publishers
- [ ] Define payout calendar: **net-30**, paid on **15th** for prior month
- [ ] Set minimum threshold (£100 / $100) in Affise billing settings
- [ ] Export Affise payment report monthly → batch Wise transfers
- [ ] Reconcile: Affise approved stats vs Wise sent vs publisher invoices
- [ ] Keep float reserve (1.5× average monthly publisher liability)

---

## Phase 4 — Affiliate payments workflow

| Step | Owner | Tool |
|------|--------|------|
| Conversions approved in Affise | AM / Auto rules | Affise |
| Monthly payment report generated | Finance | Affise → CSV |
| Publisher invoice / self-billing (UK VAT) | Finance | Xero / FreeAgent |
| Wise batch payment | Finance | Wise Business |
| Payment confirmation email | Ops | Laravel Mailable |

- [ ] Create Affise payment methods: Wise (primary), PayPal (optional backup)
- [ ] Publisher onboarding form: Wise email / account details (encrypted in DB)
- [ ] Document FX policy (publisher bears Wise fee vs network absorbs)
- [ ] Handle chargebacks / invalid leads deduction process
- [ ] Tax: IR35 N/A for publishers; issue invoices; VAT MOSS if EU B2C

---

## Phase 5 — Company documentation & due diligence (mandatory)

**Operating pack (5-person team):** `docs/company/README.md` — roles, lifecycle, KYC/KYB policy, agreements, IOs, payout/billing, fraud, escalation.

**Detailed DD SOPs:** `docs/due-diligence/`

- [ ] Assign Compliance Lead + Finance reviewer
- [ ] Set `COMPLIANCE_ACCESS_KEY` in `.env` (long random string)
- [ ] Open compliance portal: `/compliance?key=YOUR_KEY`
- [ ] Every `/apply` submission auto-creates `DD-P-*` or `DD-A-*` review
- [ ] Send document request email within 2 business days (templates in `docs/due-diligence/templates/`)
- [ ] Complete checklist (publisher or advertiser) — no blank boxes
- [ ] Score risk matrix — reject if 60+ without Board exception
- [ ] **No Affise panel** until status `approved` + all sign-offs
- [ ] Store documents in encrypted folder per `document-retention.md`
- [ ] Quarterly / annual monitoring per `ongoing-monitoring.md`

## Phase 6 — Legal & compliance

- [ ] Solicitor review of:
  - [ ] Privacy Policy (`/privacy`)
  - [ ] Terms of Service (`/terms`)
  - [ ] Affiliate Agreement (`/affiliate-agreement`)
  - [ ] Advertiser Agreement (`/advertiser-agreement`)
  - [ ] IO Template (`/io-template`)
- [ ] GDPR: DPA with Affise, Wise, hosting provider
- [ ] Cookie consent → connect analytics only after accept
- [ ] FTC / ASA affiliate disclosure guidelines in publisher onboarding pack
- [ ] iGaming: verify licence per geo before offer launch
- [ ] Finance vertical: FCA awareness, credit broker permissions where applicable
- [ ] AML/KYC: basic checks on high-volume publishers (Companies House, ID)

---

## Phase 7 — Laravel site (this repo)

- [ ] `composer install && npm install && npm run build`
- [ ] `php artisan migrate`
- [ ] Configure mail (Resend/Postmark) for application + contact notifications
- [ ] Queue worker for Affise sync jobs
- [ ] Add admin panel (Filament) to review `applications` table
- [ ] Production: `APP_ENV=production`, `APP_DEBUG=false`, Redis cache
- [ ] Submit sitemap to Google Search Console
- [ ] Lighthouse audit: target 90+ mobile performance

---

## Phase 8 — Operations

- [ ] Hire / assign: Network Manager, AM (advertisers), AM (publishers), Compliance
- [ ] Publisher vetting checklist (traffic screenshots, domain WHOIS, reference checks)
- [ ] Advertiser onboarding: IO signed, pre-pay or credit line, postback tested
- [ ] Weekly cap review meetings
- [ ] Discrepancy SLA: 5 business days
- [ ] Slack/email support channels for partners

---

## Phase 9 — Growth & CRO

- [ ] A/B test hero CTAs (publisher vs advertiser split)
- [ ] Add live chat (Crisp / Intercom) on `/apply` and `/contact`
- [ ] Case studies with real metrics (when available)
- [ ] Retargeting pixels (only post cookie consent)
- [ ] Partner referral programme
- [ ] Expand blog with 2–4 posts/month for SEO

---

## Environment variables

```env
APP_NAME=ConvertLane
APP_URL=https://convertlane.co.uk
APP_PUBLIC_URL=https://convertlane.co.uk

BRAND_CONTACT_EMAIL=contact@convertlane.co.uk
BRAND_EMAIL=contact@convertlane.co.uk

AFFISE_API_URL=https://api.affise.com
AFFISE_API_KEY=
AFFISE_TRACKING_URL=https://track.convertlane.co.uk
AFFISE_PANEL_URL=https://panel.convertlane.co.uk

MAIL_MAILER=postmark
POSTMARK_API_KEY=your_postmark_server_token
MAIL_FROM_ADDRESS=partners@convertlane.co.uk
RESEND_API_KEY=
```

---

## Quick start (local)

```bash
composer install
cp .env.example .env   # already keyed
php artisan migrate
npm install && npm run dev
```

Visit **https://network.test** (Herd) or `php artisan serve`.

---

## Suggested IO checklist (per offer)

1. Offer ID & landing URL  
2. Payout (CPA/CPL/CPS) & event definition  
3. Geo & device targeting  
4. Cap (daily/monthly)  
5. Cookie window  
6. Allowed / prohibited traffic  
7. Brand bidding rule  
8. Pre-lander approval required (Y/N)  
9. Payment terms (net-30, threshold, currency)  
10. Signatures both parties  
