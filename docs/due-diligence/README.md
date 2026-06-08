# ConvertLane — Partner Due Diligence (KYC/KYB)

**Policy:** No partner goes live without completing the full DD pack and receiving written Compliance + Commercial sign-off.

**Company-wide pack (team roles, agreements, payouts, policies):** [docs/company/README.md](../company/README.md)

## Onboarding by stage (start here for review)

**Master index:** [onboarding/README.md](onboarding/README.md)

| Copy | Purpose |
|------|---------|
| **`onboarding/*/client/`** | Professional emails & letters — **send to partners** |
| **`onboarding/*/compliance/`** | Stage checklists & sign-offs — **internal only** |

| Partner type | Client + compliance stages | Detailed DD checklist |
|--------------|---------------------------|------------------------|
| Advertiser | [onboarding/advertiser/](onboarding/advertiser/client/01-application-acknowledgement.md) | [advertiser-checklist.md](advertiser-checklist.md) |
| Publisher | [onboarding/publisher/](onboarding/publisher/client/01-application-acknowledgement.md) | [publisher-checklist.md](publisher-checklist.md) |

| Partner type | SOP | Questionnaire |
|--------------|-----|---------------|
| Publisher / Affiliate | [publisher-sop.md](publisher-sop.md) | [publisher-questionnaire.md](publisher-questionnaire.md) |
| Advertiser | [advertiser-sop.md](advertiser-sop.md) | [advertiser-questionnaire.md](advertiser-questionnaire.md) |

## Shared documents

- [risk-scoring-matrix.md](risk-scoring-matrix.md) — Factor tables (0/5/10/15 per line)
- [risk-scoring-guide.md](risk-scoring-guide.md) — **How** score is calculated (internal vs third-party checks)
- [18-advertiser-credit-and-cashflow-procedure.md](../company/18-advertiser-credit-and-cashflow-procedure.md) — Credit, prepay, cash waterfall
- [19-chargebacks-and-clawbacks.md](../company/19-chargebacks-and-clawbacks.md) — Reversals and publisher clawbacks
- [approval-workflow.md](approval-workflow.md) — States, sign-offs, SLAs
- [rejection-and-offboarding.md](rejection-and-offboarding.md) — Hard stops and exit
- [ongoing-monitoring.md](ongoing-monitoring.md) — Quarterly reviews, triggers
- [document-retention.md](document-retention.md) — What to keep, how long

## Roles

| Role | Responsibility |
|------|----------------|
| **Compliance Lead** | KYB/KYC, sanctions, legal entity, final veto |
| **Commercial AM** | Offer fit, caps, IO — cannot override Compliance veto |
| **Finance** | Credit check, prepay, payout verification |
| **Ops** | Affise setup only after `approved` status |

## Hard rules (non-negotiable)

1. **No panel access** until status = `approved` in Laravel + Affise.
2. **No IO signed** until DD pack complete and risk score ≤ threshold.
3. **Prepay or credit line** required for all advertisers before traffic goes live.
4. **Sanctions / PEP screening** on every beneficial owner ≥ 25%.
5. **Anonymous or shell entities** — auto-reject unless enhanced DD approved by Compliance Lead.
6. **Traffic proof** required for publishers — screenshots, analytics access, or Loom walkthrough.
7. **All documents** stored encrypted; 7-year retention minimum.

## Laravel integration

- Applications capture initial data → `applications` table
- Full DD pack → `due_diligence_reviews` table (see migration)
- Internal review UI: `/compliance` (middleware: `compliance` — configure auth before production)
