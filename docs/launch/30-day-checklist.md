# ConvertLane — 30-day launch checklist (simplified)

**Stack:** convertlane.co.uk · Offer18 · Postmark · Google Workspace  
**Launch vertical:** Finance — loans, credit cards, credit score, personal finance  
**Assumption:** Site deployed, migrations done, API keys set, bank account ready.

---

## Already done ✓

- [x] convertlane.co.uk deployed
- [x] Offer18 tracking platform live
- [x] Postmark email configured
- [x] Migrations run
- [x] Offer18 API keys configured
- [x] Conversion statuses configured in Offer18
- [x] ConvertLane bank account ready

---

## Week 1 — Setup & first contacts

### Google Workspace (DD, agreements, IOs)

- [ ] Create Shared Drive: **ConvertLane — Compliance** (you + compliance contact only)
- [ ] Folder structure:
  ```
  ConvertLane — Compliance/
  ├── DD-P-001/          (publisher packs — one folder per application)
  ├── DD-A-001/          (advertiser packs)
  ├── Signed Agreements/
  ├── IOs/
  └── Templates/         (copy affiliate + advertiser agreement + IO from docs/contracts/)
  ```
- [ ] Set sharing: **no external access** on DD folders; use “Request file upload” link or secure upload instructions
- [ ] Store signed PDFs in `Signed Agreements/` and `IOs/` after DocuSign or wet signature
- [ ] Rule: **no ID documents by plain email** — upload to partner’s DD folder only

### Legal (before first paid partner)

- [ ] Solicitor review of:
  - [ ] `docs/contracts/affiliate-agreement.md`
  - [ ] `docs/contracts/advertiser-agreement.md`
  - [ ] `docs/contracts/insertion-order-template.md`
- [ ] Import to Google Docs: `affiliate-agreement.txt`, `advertiser-agreement.txt`, `io-template.txt` → `Templates/`

### Site & ops

- [ ] Finish Google Search Console verification + submit sitemap
- [ ] Test `/apply` → compliance portal opens review (`COMPLIANCE_ACCESS_KEY` set)
- [ ] Test application email lands in inbox via Postmark
- [ ] Add 0–2 placeholder offers in CMS only when first advertiser is close (don’t publish empty catalogue)

### Advertiser outreach (finance)

Target **2 advertisers** for Month 1. See [finance-advertiser-targets.md](finance-advertiser-targets.md).

- [ ] Build list of 15 finance advertisers (loans, cards, credit score)
- [ ] Send 5 personalised outreach emails / LinkedIn messages
- [ ] Goal by end of Week 1: **1 advertiser call booked**

### Affiliate sourcing (start list, don’t mass-approve)

- [ ] Create target list of 20 affiliates (see sourcing section below)
- [ ] Post once in **AffiliateFix** + one **LinkedIn** post: “ConvertLane open for finance affiliates — apply at convertlane.co.uk/apply”
- [ ] Do **not** auto-approve — every applicant gets DD pack

---

## Week 2 — First partners through the pipe

### Dry run (do this before real money)

- [ ] Fake affiliate apply → send doc request → approve in compliance portal → create in Offer18
- [ ] Fake advertiser apply → DD → record prepay on spreadsheet → draft IO
- [ ] Test click → conversion → appears in Offer18 with correct status
- [ ] Fraud rules: **skip for now** — add later when volume justifies it

### Finance spreadsheets (minimum)

- [ ] **Advertiser prepay ledger** (Google Sheet): advertiser, IO#, prepay received, cap, balance
- [ ] **Affiliate payout ledger** (Google Sheet): affiliate, approved conv, amount due, paid Y/N

### Real onboarding

- [ ] Onboard **1 advertiser**: DD → agreement signed → IO signed → **prepay received** → offer in Offer18
- [ ] Onboard **3–5 affiliates**: DD → agreement → IO per offer → assign to offer in Offer18
- [ ] Run test conversion with 1 affiliate before wider assignment

**Week 2 exit:** 1 funded offer in Offer18, 3+ approved affiliates, 1 real test conversion.

---

## Week 3 — Go live

- [ ] Offer live with caps set (start low — e.g. 10–20 conv/day)
- [ ] Publish offer on `/offers` if advertiser approves
- [ ] Daily check: caps vs spend in Offer18 + prepay ledger
- [ ] Second advertiser in pipeline (outreach + DD)
- [ ] Approve 3–5 more affiliates if quality applications come in

---

## Week 4 — Stabilise

- [ ] Review conversion approval rate with advertiser
- [ ] First weekly cap check (Friday, 15 min)
- [ ] Fix any postback / tracking issues
- [ ] LinkedIn case study or “we’re live” post (no fake stats)
- [ ] Plan Month 2: fraud rules, second vertical, or scale caps

**Day 30 targets:**

| Metric | Target |
|--------|--------|
| Live finance offers | 1–2 |
| Approved affiliates | 5–10 |
| Funded advertisers | 1–2 |
| Test + real conversions in Offer18 | Yes |
| Prepay before traffic | 100% |

---

## Non-negotiable gates (keep it simple)

1. **No tracking links** until compliance = `approved` + signed IO  
2. **No advertiser caps** until prepay on ledger  
3. **No affiliate payout** until conversions approved + advertiser funds cover it  
4. **Offer18 = system of record** for stats  

---

## Where to source affiliates

| Channel | Use for | Notes |
|---------|---------|-------|
| **LinkedIn** | Primary outreach | Search “affiliate marketer”, “performance marketing”, “finance leads”. DM + post in feed. Best quality for finance. |
| **AffiliateFix** | Forum recruitment | Free forum, “Networks” section. Post intro thread. Better than BHW for compliance-minded pubs. |
| **STM (StackThatMoney)** | Serious paid-social / native pubs | Paid forum (~$99/mo). Worth it if you run native finance. |
| **Offervault** | Research, not recruitment | See which finance offers are hot and which networks run them. Reverse-engineer who to poach from, not where to post. |
| **Facebook groups** | UK affiliate groups | Search “UK affiliate marketing”, “CPA marketing”. Mixed quality — vet hard. |
| **Twitter/X** | #affiliatemarketing | Quick visibility, follow finance affiliate accounts. |
| **Direct outreach** | Comparison sites, finance blogs | Email sites ranking for “best credit cards UK”, “loans comparison”. High intent, slower close. |
| **BlackHatWorld** | Optional, low priority | High volume, mixed compliance. Finance advertisers often reject BHW traffic. Use only if IO allows and you can vet. |
| **Your network** | Best source | Ex-colleagues, agency contacts, former network AMs. Start here. |

**Recommended order:** Warm contacts → LinkedIn → AffiliateFix → Direct outreach to finance sites → STM if budget allows → BHW last (if at all).

---

## Deferred (don’t block launch)

- [ ] Fraud rules in Offer18 (Week 4+)
- [ ] Formal role assignments / RACI
- [ ] Filament admin panel
- [ ] Automated DD document emails (manual from templates is fine for first 10 partners)
- [ ] Credit lines for advertisers (prepay only at launch)

---

## Quick links

| Item | Location |
|------|----------|
| Affiliate agreement | [docs/contracts/affiliate-agreement.md](../contracts/affiliate-agreement.md) |
| Advertiser agreement | [docs/contracts/advertiser-agreement.md](../contracts/advertiser-agreement.md) |
| IO template (Google Doc) | [docs/contracts/google-workspace/io-template.txt](../contracts/google-workspace/io-template.txt) |
| Finance advertiser targets | [finance-advertiser-targets.md](finance-advertiser-targets.md) |
| DD onboarding stages | [docs/due-diligence/onboarding/README.md](../due-diligence/onboarding/README.md) |
