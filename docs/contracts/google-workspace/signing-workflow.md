# Easiest signing workflow (Google eSignature)

**On-site digital signing:** Partners can also sign during onboarding at convertlane.co.uk (Step 3 — agreement + canvas signature). Signed copies are stored in the database and visible in `/compliance`. Google Docs eSignature is optional for IOs or counter-signature.

**Goal:** Partner signs the minimum number of times. You reuse templates; never edit masters.

---

## What gets signed (2 doc types only)

| Partner | Doc 1 — once on approval | Doc 2 — per offer |
|---------|--------------------------|-------------------|
| **Affiliate** | Affiliate Agreement | IO (one per offer they run) |
| **Advertiser** | Advertiser Agreement | IO (one per campaign/offer) |

**Yes — separate Google Doc for each signing event.** One eSignature request per doc. Do not bundle agreement + IO in one request (IO changes every offer; agreement is once).

---

## Master templates (create once, never sign these)

In `ConvertLane — Compliance/Templates/`:

1. **Affiliate Agreement — Template**
2. **Advertiser Agreement — Template**
3. **IO Template — Finance**

Import from the `.txt` files in this folder. Add logo header. Leave signature blocks empty.

---

## Affiliate workflow (3 steps)

### Step 1 — They apply
Partner applies at convertlane.co.uk/apply → you run DD → approve in compliance portal.

### Step 2 — Sign master agreement (once)
1. Open **Affiliate Agreement — Template**
2. **File → Make a copy**
3. Rename: `CL-PUB-001 — Company Name — Affiliate Agreement`
4. Fill: partner name, address, company no., effective date, agreement ID
5. **Delete** any INTERNAL ONLY section if present
6. **Tools → eSignature**
7. Add signers:
   - Signer 1: `partners@convertlane.co.uk` (you)
   - Signer 2: partner contact email
8. Place fields: Signature + Name + Date for each party
9. **Request eSignature**
10. When complete: move signed PDF to `Signed Agreements/CL-PUB-001/`

### Step 3 — Sign IO (each offer)
1. **File → Make a copy** of **IO Template — Finance**
2. Rename: `CL-IO-2026-001 — Company Name — Offer Name`
3. Fill all commercial fields; tick Affiliate / Publisher
4. Delete INTERNAL ONLY section at bottom
5. **Tools → eSignature** → same two signers → **Request**
6. Save signed PDF to `IOs/CL-IO-2026-001/`
7. Log row in IO Register (optional Sheet)

**Then:** Create offer in Offer18, assign affiliate, send panel login.

---

## Advertiser workflow (same pattern)

### Step 1 — Apply + DD + prepay
Approve in compliance portal. **Prepay received** before IO.

### Step 2 — Sign advertiser agreement (once)
1. Copy **Advertiser Agreement — Template**
2. Rename: `CL-ADV-001 — Company Name — Advertiser Agreement`
3. Fill blanks → **Tools → eSignature** → request
4. Signed PDF → `Signed Agreements/CL-ADV-001/`

### Step 3 — Sign IO (per offer)
1. Copy **IO Template — Finance**
2. Rename: `CL-IO-2026-002 — Company Name — Offer Name`
3. Fill blanks; tick Advertiser; complete finance compliance section
4. Fill prepay ref in payment section
5. eSignature → signed PDF → `IOs/`
6. Configure offer in Offer18

---

## Rules (keep it easy)

| Do | Don't |
|----|--------|
| Make a **copy** of template every time | Edit the master template |
| One eSignature request per doc | Combine agreement + IO in one doc |
| Sign agreement **before** first IO | Send IO before agreement signed |
| Advertiser: prepay **before** IO signed | Open caps without prepay on ledger |
| Save signed PDFs to Drive folders | Rely on email attachments only |
| Use partner's **business email** | Use personal Gmail if company email exists |

---

## Folder per partner (optional but tidy)

```
Signed Agreements/
├── CL-PUB-001 — Acme Media/
│   └── Affiliate Agreement — signed.pdf
├── CL-ADV-001 — FinanceBrand Ltd/
│   └── Advertiser Agreement — signed.pdf

IOs/
├── CL-IO-2026-001 — Acme Media — ClearScore CPL/
│   └── IO — signed.pdf
```

---

## Checklist before you hit "Request eSignature"

- [ ] Correct template copied (affiliate vs advertiser vs IO)
- [ ] All `___` blanks filled
- [ ] Wrong payment section deleted or marked N/A (affiliate vs advertiser)
- [ ] INTERNAL ONLY section removed
- [ ] Partner email is correct
- [ ] You are Signer 1, partner is Signer 2

---

## If eSignature is not available on your plan

1. **File → Download → PDF**
2. Email PDF to partner: "Please sign and return"
3. Or use DocuSign free trial / Dropbox Sign for first few partners
4. Save returned PDF to same Drive folders

---

## Summary

**Easiest path:** 3 master templates → **copy + fill + eSignature** per doc → 2 docs per affiliate (agreement once + IO per offer), same for advertisers. Partner gets an email, clicks Sign, done — no Google account needed.
