# Head of Compliance — role playbook

**Accountable for:** KYC/KYB, sanctions, approve/reject veto, fraud rulings, document retention.

**Backup:** MD (veto only; no routine approvals while you're away unless pre-delegated in writing).

---

## You own

- DD pack completeness ([publisher](../../due-diligence/publisher-checklist.md) / [advertiser](../../due-diligence/advertiser-checklist.md))  
- Risk scoring ([risk-scoring-matrix](../../due-diligence/risk-scoring-matrix.md))  
- Status changes in `/compliance` — audit log always  
- Sanctions / PEP / UBO verification  
- Fraud investigation **decision** (AM gathers facts)  
- Policy maintenance ([03-kyc-kyb-policy.md](../03-kyc-kyb-policy.md), [04](../04-compliance-fraud-policy.md))  
- Encrypted document storage structure  

---

## Daily (30–60 min)

- [ ] New applications in `/compliance` — status `applied`  
- [ ] Send **Stage 2** client doc pack within **2 business days** ([onboarding](../../due-diligence/onboarding/README.md))  
- [ ] Chase packs past deadline → `on_hold` or close  
- [ ] Clear sanctions / ID queue  
- [ ] Review Affise fraud flags with AMs (Wednesdays deep dive)  

---

## Per application workflow

1. **applied** → verify intake → **documents_requested** (email + deadline)  
2. Pack received → **under_review** — complete checklist, score risk  
3. Issues → **on_hold** (notes) or **enhanced_dd**  
4. Clear → set sign-offs in UI → **approved** only if gates pass  
5. Fail → **rejected** ([Stage 10 client letter](../../due-diligence/onboarding/advertiser/client/10-application-declined.md))  

**Never** approve if: sanctions hit, forged docs, score 60+ without MD note, sign-offs incomplete.

---

## Weekly

- [ ] All `documents_requested` under 7 days or chased  
- [ ] Fraud queue empty or documented  
- [ ] Blocklist updated (terminated entities)  

---

## Monthly / quarterly

- [ ] Quarterly monitoring sample ([ongoing-monitoring](../../due-diligence/ongoing-monitoring.md))  
- [ ] Processor/DPA renewal dates  
- [ ] Policy review tickler  

---

## Handoffs

| To | When |
|----|------|
| Publisher Lead | Publisher `approved` — ready for IO |
| Advertiser Lead | Advertiser `approved` — Finance must clear prepay/credit |
| Finance & Ops | `approved` — may create Affise **after** IO + funding gates |
| MD | enhanced_dd, score 60+, PEP, media/regulatory |

---

## If this → then that

| Situation | Action |
|-----------|--------|
| Free email only publisher | Enhanced DD or reject |
| iGaming, no licence visible | Hold until licence verified |
| Sanctions false positive | Document clearance, keep audit note |
| AM pressures approve | Veto — log incident if repeated |
| Bank detail change | Hold payout flag until re-verified ID |
| Advertiser chargeback fraud allegation | Lead investigation; pause sub-IDs |

---

## Tools

- `/compliance?key=…` (move to proper login before scale)  
- Sanctions screening tool (your choice — document vendor)  
- Companies House / OpenCorporates  
- Encrypted drive: `DD/{DD-P-00001}/`  

---

## Files you touch

| Doc | Use |
|-----|-----|
| publisher-sop / advertiser-sop | Step order |
| approval-workflow | Status definitions |
| rejection-and-offboarding | Exit |
| document-retention | 7 years |

---

## Success looks like

- No blank checklist boxes at approval  
- Every reject/hold has notes in audit log  
- No Affise access without your `approved`  
