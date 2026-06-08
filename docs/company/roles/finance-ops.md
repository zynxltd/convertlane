# Finance & Operations — role playbook

**Accountable for:** Money in/out, Affise configuration, reconciliations, payout run on the 15th.

**Backup:** Compliance Lead (payout holds); MD (large batches).

---

## You own

- **Advertiser:** prepay receipt, credit approvals (with MD), invoicing, collections  
- **Publisher:** payment details ([template](../templates/publisher-payment-details.md)), payout run, deductions  
- **Affise:** offer/partner setup per [14-launch](../14-offer-launch-checklist.md)  
- **Ledger:** simple spreadsheet — cash in, publisher liability, paid out  
- **Reconciliation:** Affise vs advertiser vs Wise  
- Compliance holds on payout (flag in shared sheet)  

---

## Daily (30–45 min)

- [ ] Affise cap alerts — pause if prepay exhausted  
- [ ] Prepay balances vs active caps  
- [ ] IO queue waiting for Affise setup  
- [ ] Wise messages / bank incoming  

---

## Weekly

- [ ] Advertiser ledger vs caps (Wednesday)  
- [ ] Payout preview when approaching month-end  
- [ ] Affise test links on new offers verified  

---

## Monthly (non-negotiable)

| Date | Task |
|------|------|
| 1st–3rd | Export Affise prior month |
| 3rd–7th | Reconcile with AMs + advertiser |
| 5th | Compliance clears fraud holds |
| 7th–10th | Build Wise batch; MD check if large |
| **15th** | Send publisher payouts |
| 20th | Invoice credit advertisers |

Full detail: [08-publisher-payout-policy](../08-publisher-payout-policy.md), [09-advertiser-billing-policy](../09-advertiser-billing-policy.md).

---

## Affise setup (Ops)

Only after Gates 2–5 pass:

1. Create partner (approved publisher) or offer (advertiser)  
2. Match IO: payout, geo, cap, cookie  
3. Test click + conversion + postback  
4. Assign publishers to offer  
5. Log Affise IDs on IO / launch checklist  

**Never** create partner before Compliance `approved`.

---

## Ledger columns (minimum)

| Column | Purpose |
|--------|---------|
| Date | |
| Type | Prepay in / Payout out / Invoice |
| Partner | |
| Offer ID | |
| Amount | |
| Currency | |
| Reference | Wise / invoice # |
| Balance after | Running cash |

Rule: **Do not pay publishers** if advertiser funds for that offer are not collected (MD exception only in writing).

---

## Handoffs

| To | When |
|----|------|
| Compliance | Payment detail change; fraud hold |
| Publisher Lead | Payout sent confirmation |
| Advertiser Lead | Low prepay, invoice disputes |
| MD | Cash shortfall, overdue advertiser >21 days |

---

## If this → then that

| Situation | Action |
|-----------|--------|
| Prepay not arrived, AM wants live | Cap stays 0 |
| Publisher overpaid last month | Deduct this month; email publisher |
| Affise ≠ advertiser stats | 5-day dispute process; AM owns comms |
| Wise fail | Retry next business day; notify publisher |
| New bank details | Compliance clear before pay |

---

## Tools

- Wise Business  
- Affise admin  
- Xero/FreeAgent (or spreadsheet)  
- Affise export CSV archive folder  

---

## Files

- [credit-application](../templates/credit-application-advertiser.md)  
- [18-advertiser-credit-and-cashflow-procedure](../18-advertiser-credit-and-cashflow-procedure.md)  
- [19-chargebacks-and-clawbacks](../19-chargebacks-and-clawbacks.md)  
- [publisher-payment-details](../templates/publisher-payment-details.md)  
- [14-offer-launch-checklist](../14-offer-launch-checklist.md)  

---

## Success looks like

- 15th payouts on time  
- Every payout line ties to Affise conversion IDs  
- Affise always matches signed IO  
- Zero “ghost” partners in Affise without DD approval  
