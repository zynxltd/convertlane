# Launch finance ledgers (Google Sheets)

Minimum spreadsheets from the [30-day checklist](../30-day-checklist.md). Import each CSV as its own Google Sheet.

---

## Import

1. Go to [Google Sheets](https://sheets.google.com) → **Blank spreadsheet**
2. **File → Import → Upload** → select the `.csv` file
3. Import location: **Replace spreadsheet**
4. Separator: **Comma**
5. Rename and save to your ops folder (e.g. `ConvertLane — Compliance/` or a Finance shared folder)

| File | Save as |
|------|---------|
| `advertiser-prepay-ledger.csv` | Advertiser Prepay Ledger |
| `affiliate-payout-ledger.csv` | Affiliate Payout Ledger |

---

## Advertiser prepay ledger

| Column | Use |
|--------|-----|
| **Advertiser** | Legal / trading name |
| **IO#** | e.g. `CL-IO-2026-001` (match [IO register](../../contracts/google-workspace/io-register.csv)) |
| **Prepay received** | Cleared funds (GBP) — bank/Wise reference matched |
| **Cap** | Max spend enabled in Offer18 for this IO (GBP) |
| **Balance** | Remaining prepay after spend — update from Offer18 vs ledger |

**Rules:** No Offer18 cap until prepay is on this sheet. Daily check: caps vs spend in Offer18 + balance here.

**Suggested formatting (after import):**

- Row 1: bold, freeze
- Columns C–E: **Format → Number → Currency** (GBP)
- **Balance:** manual entry from Offer18 spend, or `=C2-D2` only if Cap tracks cumulative spend (adjust to your workflow)

---

## Affiliate payout ledger

| Column | Use |
|--------|-----|
| **Affiliate** | Publisher name |
| **Approved conv** | Count of advertiser-approved conversions (Offer18 export) |
| **Amount due** | Payout total (GBP) for the period |
| **Paid Y/N** | `Y` when Wise/bank payout sent; `N` until paid |

**Rules:** No payout until conversions are approved **and** advertiser prepay covers liability for that offer.

**Suggested formatting (after import):**

- Row 1: bold, freeze
- Column C: currency (GBP)
- Column D: data validation **List of items:** `Y,N`

---

## Related

| Item | Location |
|------|----------|
| IO register | [io-register.csv](../../contracts/google-workspace/io-register.csv) |
| 30-day checklist | [30-day-checklist.md](../30-day-checklist.md) |
| Control gates | [16-control-gates.md](../../company/16-control-gates.md) |
