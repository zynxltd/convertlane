# Risk scoring — how it works

**Owner:** Head of Compliance

---

## Short answer

| Question | Answer |
|----------|--------|
| Is risk score from a third party? | **No.** It is calculated **internally** using [risk-scoring-matrix.md](risk-scoring-matrix.md). |
| What uses third parties? | **Sanctions/PEP screening**, **business credit reports**, **company registry** — separate checks. |
| Where is score stored? | Laravel `/compliance` → `risk_score` + `risk_band` |
| Who enters the score? | Compliance Lead (manual), after completing matrix |

---

## How to calculate (step by step)

1. Open [risk-scoring-matrix.md](risk-scoring-matrix.md).  
2. Use **Publisher** or **Advertiser** table (10 factors each).  
3. For each factor, pick **one** points column (0, 5, 10, or 15).  
4. **Sum** all points → total score (0–150 theoretical max; typically 0–80).  
5. Map total to band:

| Total | Band | Action |
|-------|------|--------|
| 0–19 | Low | Standard approval if pack complete |
| 20–39 | Medium | AM + Compliance sign-off |
| 40–59 | High | Enhanced DD; advertisers usually **prepay only** |
| 60+ | Critical | **Reject** unless MD + Compliance written exception |

6. Apply **automatic escalations** (matrix bottom) — may force minimum band High even if score lower.  
7. Enter score in compliance portal: `updateRiskScore` / UI field.  
8. Save completed matrix PDF in DD folder: `DD-A-00123-risk-2026-05-23.pdf`

---

## Third-party vs internal (clear split)

| Check | Type | Provider examples | Feeds risk score? |
|-------|------|-------------------|-------------------|
| Risk matrix (10 factors) | **Internal manual** | — | **Yes — this IS the score** |
| Sanctions / PEP | **Third party** | ComplyAdvantage, World-Check, OFSI | No — separate pass/fail; auto-escalate if hit |
| Business credit report | **Third party** | Creditsafe, Experian, D&B | Informs factor #2/#3 on advertiser table; Finance decides prepay vs credit |
| Companies House / registry | **Official registry** | companieshouse.gov.uk | Informs entity factors |
| ID verification | **Manual + optional tool** | Onfido, Jumio (optional) | Informs identity factors |
| Traffic analytics | **Publisher proof** | GA, screenshots | Informs publisher traffic factors |

**Do not** plug credit bureau score directly into `risk_score` field — use matrix for consistency.

---

## Advertiser-specific: finance factors on matrix

| Matrix row | What to verify |
|------------|----------------|
| #2 Financial statements | Accounts < 18mo, solvency |
| #3 Credit / prepay | Prepay received = 0 pts; unsecured credit without approval = 15 pts |
| #7 Chargeback / refund policy | Fair refund policy documented = 0 pts |

Finance may require **prepay** even when total score is Low — Finance veto is separate from score.

---

## Automatic rules (override maths)

Even if score is Low, escalate to **High** minimum if:

- Sanctions match uncleared  
- iGaming without licence for geo  
- Refusal to provide incorporation or ID  

**Reject** (no exception without Board/MD minute) if:

- Confirmed fraud history  
- Confirmed sanctions match  
- Fake documents  

Listed in matrix § Automatic reject.

---

## Code (system behaviour)

`DueDiligenceService::calculateRiskBand($score)` reads bands from `config/compliance.php`:

```php
'low' => 0–19, 'medium' => 20–39, 'high' => 40–59, 'critical' => 60+
```

Approval **blocked** if `critical` band unless exception in notes.  
Advertiser approval **blocked** without `finance_approved` regardless of score.

---

## Review cadence

- New partner: full matrix at first approval  
- Annual or trigger: re-score per [ongoing-monitoring.md](ongoing-monitoring.md)  
- Material change (new UBO, new vertical): partial re-score documented in audit log  
