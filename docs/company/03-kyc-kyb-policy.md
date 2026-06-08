# KYC / KYB policy

**Owner:** Head of Compliance · **Effective:** On adoption · **Review:** Annual

---

## Purpose

Verify who we do business with before money or tracking flows. Applies to **all publishers (affiliates)** and **advertisers**.

---

## Scope

| Partner | KYB (business) | KYC (people) |
|---------|-----------------|--------------|
| Publisher | Company or sole trader registration | Directors + UBOs ≥ 25% |
| Advertiser | Company registration + vertical licences where required | Directors + UBOs ≥ 25% + signatory ID |

---

## Minimum requirements

### All partners

- Legal entity name matching official registry  
- Registered address + proof  
- Company registration number (UK: Companies House; foreign: equivalent)  
- List of directors and beneficial owners (≥ 25%) — [UBO declaration](../due-diligence/templates/ubo-declaration.md)  
- Government-issued photo ID for each UBO and authorised signatory  
- Sanctions and PEP screening (document date on file)  
- Completed questionnaire ([publisher](../due-diligence/publisher-questionnaire.md) or [advertiser](../due-diligence/advertiser-questionnaire.md))  
- Signed master agreement before first IO  

### Publishers additionally

- Proof of traffic ownership (analytics, Search Console, or platform access)  
- Description of traffic sources per vertical applied for  
- Corporate email preferred; free-email-only → enhanced DD or reject  

### Advertisers additionally

- Proof of product/offer legitimacy (landing page, licence if regulated)  
- **Prepay** or **approved credit line** before traffic (see [09-advertiser-billing-policy.md](09-advertiser-billing-policy.md))  
- Finance sign-off on viability  

---

## Risk bands (summary)

Full matrix: [risk-scoring-matrix](../due-diligence/risk-scoring-matrix.md).

| Score | Band | Action |
|-------|------|--------|
| 0–39 | Low | Standard approval (two sign-offs) |
| 40–59 | Medium | Enhanced DD — Compliance Lead approval only |
| 60+ | High | Reject unless MD + Compliance written exception |

---

## Automatic declines (no exception without MD + Compliance written record)

- Sanctions match (uncleared)  
- False or forged documents  
- Shell company with no operating proof  
- Publisher cannot demonstrate traffic source  
- Advertiser in prohibited vertical without licence  
- Prior termination from ConvertLane for fraud (same entity / UBO)  
- Refusal to provide UBO information  

---

## Enhanced due diligence triggers

- High-risk geo (maintain internal list)  
- Crypto-only settlement request  
- iGaming without visible licence  
- Finance offers without FCA or equivalent where required  
- Score 40–59  
- PEP (not auto-decline — case-by-case with MD)  

---

## Storage & retention

- Store in encrypted drive or compliance tool  
- Link record in Laravel `due_diligence_reviews`  
- **Retain 7 years** after relationship ends  
- Details: [document-retention](../due-diligence/document-retention.md)

---

## Re-verification

| Trigger | Action |
|---------|--------|
| Change of UBO or director | Full ID + sanctions within 10 business days |
| New vertical (advertiser) | Licence check |
| Annual refresh | Lightweight KYB refresh for active partners (Compliance calendar) |
| Unusual payout detail change | Finance holds payout until Compliance clears |

---

## Roles

| Task | Role |
|------|------|
| Request documents | Compliance |
| Verify registry & IDs | Compliance |
| Sanctions / PEP | Compliance |
| Traffic / offer legitimacy | AM + Compliance |
| Credit / prepay | Finance |
| Final approve / reject | Compliance (veto) + AM + Finance (advertisers) |

**Detailed SOPs:** [docs/due-diligence/](../due-diligence/)
