# Publisher / affiliate due diligence SOP

**Owner:** Compliance Lead · **Review cycle:** Annual · **Version:** 1.0

## Objective

Verify that every publisher is a legitimate business, promotes traffic ethically, can be paid safely, and will not damage advertiser brands or ConvertLane's licence to operate.

## Phase 1 — Application triage (Day 0–2)

1. Receive application from `/apply` → status `applied`.
2. Auto-reject if:
   - Free email only (gmail/yahoo/outlook) **and** no company website
   - Website unreachable or for-sale/parked
   - Country on internal blocklist
3. Run domain WHOIS — flag if registered < 90 days.
4. Send **Document Request Pack** (email template: `templates/document-request-publisher.md`) → status `documents_requested`.
5. Set deadline: **7 business days**.

## Phase 2 — Document collection (mandatory)

| Document | Required | Notes |
|----------|----------|-------|
| Certificate of incorporation / registration | Yes | Match legal name exactly |
| Proof of address (utility/bank, < 3 months) | Yes | Registered or trading address |
| Government ID — directors / UBOs ≥ 25% | Yes | Passport or driving licence |
| VAT / tax ID (if applicable) | If registered | UK: UTR + VAT cert |
| Wise Business verification screenshot OR bank letter | Yes | Payout account must match entity |
| Traffic proof package | Yes | See below |
| Signed Affiliate Agreement | Yes | Wet ink or DocuSign |
| Sanctions / PEP declaration form | Yes | All UBOs listed |
| Reference contact (2) | Preferred | Prior network or advertiser |

### Traffic proof package (all that apply)

- Google Analytics guest access **or** 3 months screenshots (sessions, sources, geo)
- Ad platform access (Meta/Google/TikTok) **or** screenshots
- Examples of 3 live campaigns / pages (URLs)
- Email list: size, opt-in method, sample signup flow (if email traffic)
- For paid: average daily spend last 90 days

**Insufficient proof → on_hold or reject. No exceptions for "trust me".**

## Phase 3 — Verification checks

| Check | Tool / method | Pass criteria |
|-------|---------------|---------------|
| Company exists | Companies House / OpenCorporates / local registry | Active, name match |
| Directors | Registry + ID cross-check | Names match ID |
| Sanctions | ComplyAdvantage / OFAC / HMT list (manual OK at start) | No match or cleared false positive |
| PEP | Self-declaration + commercial DB if available | Documented clearance |
| Website | Manual review + VirusTotal URL | No malware; content matches declared vertical |
| Brand bidding history | Ask + Google search `company + coupon` | Disclose any prior violations |
| Internal blocklist | Spreadsheet / DB | Not listed |
| Risk score | [risk-scoring-matrix.md](risk-scoring-matrix.md) | Band acceptable |

## Phase 4 — Interview (Medium+ risk or new entity < 1 year)

30-minute video call (recorded with consent):

- Walk through traffic sources live
- Explain last 3 campaigns and metrics
- Confirm understanding of prohibited traffic
- Confirm payout details match entity

## Phase 5 — Decision

| Outcome | Action |
|---------|--------|
| Approve | Compliance + AM sign-off → `approved` → Ops creates Affise partner (probation caps) |
| Enhanced DD | Score 40–59 → Compliance Lead review → may approve with caps |
| Reject | [rejection-and-offboarding.md](rejection-and-offboarding.md) → email + internal log |
| On hold | Missing items only; one extension max (7 days) |

## Phase 6 — Probation (first 90 days)

- Lower caps (e.g. 20 conversions/day unless proven)
- Weekly quality review
- Hold payment if fraud score spikes in Affise
- No private offers until 30 clean days

## Phase 7 — Ongoing

See [ongoing-monitoring.md](ongoing-monitoring.md).
