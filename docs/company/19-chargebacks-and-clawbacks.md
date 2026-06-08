# Chargebacks, reversals & clawbacks

**Owner:** Finance & Operations · **Decisions:** Compliance (fraud) · **Review:** Annual

**Related:** [04-compliance-fraud-policy.md](04-compliance-fraud-policy.md) · [08-publisher-payout-policy.md](08-publisher-payout-policy.md) · [07-insertion-order-template.md](07-insertion-order-template.md) (reversal window)

---

## Terms we use

| Term | Meaning |
|------|---------|
| **Invalid conversion** | Does not meet IO event (wrong geo, bot, cap exceeded) — rejected before payout |
| **Advertiser rejection** | Advertiser disputes validity in reversal window — not yet paid to publisher |
| **Chargeback / reversal** | Advertiser reverses after initially approving — may be after publisher paid |
| **Clawback** | Recovering money from publisher for conversions later deemed invalid |

---

## Where this is set contractually

| Document | Clause area |
|----------|-------------|
| [06-advertiser-agreement.md](06-advertiser-agreement.md) | Validation SLA, dispute process |
| [05-publisher-agreement.md](05-publisher-agreement.md) | Deductions from future payouts |
| [07-insertion-order-template.md](07-insertion-order-template.md) | **Reversal window** field (e.g. 30 days) |
| [08-publisher-payout-policy.md](08-publisher-payout-policy.md) | What we pay / deduct |

---

## IO must define (every offer)

| Field | Example | Why |
|-------|---------|-----|
| Payable event | Funded loan, FTD | Clear definition |
| Reversal window | 30 days from conversion date | Limits dispute period |
| Who validates | Advertiser postback / daily file | |
| Dispute SLA | Advertiser flags within 14 days of month-end | |
| Chargeback risk | Finance / shared / publisher | Who eats invalid after pay |

**Default if silent:** reversal window **30 days**; invalid not paid; post-payment reversals clawback publisher where IO allows.

---

## Process — advertiser rejects conversions

| Step | Owner | Timing |
|------|-----|--------|
| 1 | Advertiser sends dispute list (conversion IDs) | Within IO dispute SLA |
| 2 | Finance pulls Affise log + click path | 2 business days |
| 3 | Publisher Lead contacts publisher for explanation | 2 business days |
| 4 | Compliance rules fraud vs quality vs valid | 2 business days |
| 5 | Decision: uphold / reject / partial | Finance records |
| 6 | Affise status updated to rejected | Finance & Ops |
| 7 | Publisher payout adjusted before 15th if not yet paid | Finance |

**SLA:** Resolve within **5 business days** of complete dispute file.

---

## Process — after publisher already paid

| Step | Owner | Action |
|------|-----|--------|
| 1 | Confirm conversion inside reversal window | Finance |
| 2 | If invalid per ruling | Deduct from **next publisher payout** |
| 3 | If publisher disputes clawback | Compliance final call |
| 4 | If publisher refuses / no future balance | Invoice publisher; consider termination |
| 5 | If advertiser at fault (tracking bug) | Network may absorb — MD decision; do not clawback publisher |

Document every clawback with Affise conversion IDs in remittance email.

---

## Cash-flow protection (chargebacks)

| Risk | Control |
|------|---------|
| Pay publishers before advertiser pays | **Blocked** by [18-credit-and-cashflow](18-advertiser-credit-and-cashflow-procedure.md) |
| High reversal rate on offer | Pause offer; review publisher sub-IDs |
| Credit advertiser, many reversals | Reduce credit limit; move to prepay |
| Subscription chargebacks (health/DTC) | Stricter IO; longer reversal window consideration |

**Risk matrix** scores advertiser chargeback policy: see factor #7 in [risk-scoring-matrix](../due-diligence/risk-scoring-matrix.md).

---

## Who absorbs the loss?

| Situation | Typical outcome |
|-----------|-----------------|
| Clear publisher fraud | Publisher clawback + terminate |
| Grey-area quality | Split or network absorbs once; warn publisher |
| Advertiser tracking error | Advertiser pays; publisher upheld |
| Inside reversal window, valid reject | Not paid to publisher |
| Outside reversal window | Publisher keeps pay unless fraud proven |

---

## Reporting

| Report | Owner | Frequency |
|--------|-------|-----------|
| Invalid rate by offer | Finance & Ops | Monthly |
| Clawbacks pending | Finance | Before each 15th |
| Advertisers with >10% reversals | AM + Compliance | Monthly review |

---

## Escalation

- Suspected systematic fraud → [12-incident-escalation.md](12-incident-escalation.md) P1/P2  
- Legal threat from publisher on clawback → MD + solicitor  
