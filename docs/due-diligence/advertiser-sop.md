# Advertiser due diligence SOP

**Owner:** Compliance Lead · **Finance co-owner for Phase 3** · **Version:** 1.0

**Checklist (per-task detail):** [advertiser-checklist.md](advertiser-checklist.md)  
**Credit / cash-flow:** [18-advertiser-credit-and-cashflow-procedure.md](../company/18-advertiser-credit-and-cashflow-procedure.md)  
**Risk score how-to:** [risk-scoring-guide.md](risk-scoring-guide.md)

## Objective

Confirm advertisers are solvent, legally permitted to market their product, will pay for valid conversions, and will not create regulatory or reputational liability for ConvertLane.

## Phase 1 — Application triage (Day 0–2)

1. Application received → `applied`.
2. Auto-reject if:
   - No corporate entity (individual applicants)
   - Product in absolute prohibited list (unlicensed pharma, counterfeit, malware, etc.)
   - No working landing page
3. Identify vertical → apply vertical-specific licence rules (iGaming, finance).
4. Send **Advertiser Document Request Pack** → `documents_requested`.

## Phase 2 — Document collection (mandatory)

| Document | Required | Notes |
|----------|----------|-------|
| Certificate of incorporation | Yes | |
| Memorandum / articles (or equivalent) | Yes | |
| Register of directors + UBO declaration | Yes | All ≥ 25% |
| Government ID — all UBOs and signatory | Yes | |
| Audited accounts OR filed statutory accounts | Yes | < 18 months old |
| Management accounts (last 3 months) | If startup (< 2yr) | Must show runway |
| Bank reference letter OR prepay wire confirmation | Yes | |
| Credit check authorisation (signed) | Yes | Run before unsecured terms |
| Product licence(s) | If regulated | iGaming, lending, insurance, etc. |
| Landing page URLs + creative samples | Yes | |
| Privacy policy + terms on LP | Yes | GDPR minimum |
| Postback technical spec | Yes | Test endpoint ready |
| Signed Advertiser Agreement + IO draft | Yes | |
| Insurance / PI (if B2B finance) | Where applicable | |

### Financial thresholds

| Scenario | Requirement |
|----------|-------------|
| New advertiser (< 2yr) | **100% prepay** for first 90 days |
| Established, clean credit | Credit line per Finance policy (max net-15) |
| Score ≥ 40 | Prepay only until 90 days clean delivery |
| Any payment dispute history | Prepay + reserve |

**No offer goes live without Finance sign-off on funding.**

## Phase 3 — Financial due diligence (Finance lead)

1. **Credit check** (Creditsafe / Experian Business / D&B) — store report PDF.
2. Review:
   - Net assets, current ratio, cash
   - CCJs, insolvency notices, winding-up petitions
   - DSO / creditor days if available
3. Calculate **exposure limit:** max monthly payout liability × 1.5.
4. Confirm prepay received OR credit line letter signed.
5. Record in DD pack: `finance_approved_by`, `exposure_limit_gbp`, `payment_terms`.

**Finance veto is binding.**

## Phase 4 — Compliance & product review

| Check | Pass |
|-------|------|
| Licence covers target geos | Yes for iGaming/finance |
| LP claims substantiated | No guaranteed returns, false health claims |
| FTC/ASA/CAP compliance on samples | Disclosures present |
| Data processing | DPA signed if pixel shares PII |
| Sanctions on UBOs | Clear |
| Risk score | Per matrix |

## Phase 5 — Technical validation

1. Test click → conversion → postback in Affise staging.
2. Verify unique transaction ID handling.
3. Confirm cap sync and auto-pause rules.
4. Document offer ID and tracking link.

## Phase 6 — Decision & go-live

| Outcome | Action |
|---------|--------|
| Approve | Compliance + Finance + AM → `approved` → IO countersigned → Affise offer live |
| Enhanced DD | Legal review for complex structures |
| Reject | Document reason code (see rejection SOP) |

## Probation (first 60 days)

- Weekly conversion quality review
- Shorter payment terms to publishers on this advertiser if needed
- Pause offer if discrepancy > 5% without resolution in 5 days
