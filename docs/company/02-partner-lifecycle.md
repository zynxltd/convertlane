# Partner lifecycle

One path for publishers. One path for advertisers. Same compliance spine.

---

## Publisher journey

```
Apply (website) → DD pack requested → Under review → Approved → IO per offer → Affise live → Monthly payout
                                      ↓
                                   Rejected / On hold
```

| Stage | Owner | Max time | Output |
|-------|-------|----------|--------|
| Application | System | — | `applications` record |
| Document request | Compliance | 2 business days | [Publisher Stage 2 client pack](../due-diligence/onboarding/publisher/client/02-document-request-pack.md) |
| Partner submits pack | Partner | 7 business days | Files in secure storage |
| Review | Compliance + Publisher Lead | 5 business days | Checklist complete, risk score |
| Approval | Compliance + Publisher Lead | — | Status `approved`, Affise partner created |
| IO per offer | Publisher Lead | 2 business days | Signed IO |
| Go live | Finance & Ops | 1 business day | Links in Affise, caps set |
| Ongoing | Publisher Lead | Quarterly | [ongoing-monitoring](../due-diligence/ongoing-monitoring.md) |

**Publisher panel:** Issued only after `approved`. Probation: first 30 days — weekly stats review.

---

## Advertiser journey

```
Apply → DD pack → Financial check → Prepay OR credit approved → IO → Offer live → Invoice / top-up
```

| Stage | Owner | Output |
|-------|-------|--------|
| Application | System | `applications` record |
| DD + licence check (if iGaming/health/finance) | Compliance | Checklist + risk score |
| Prepay received **or** credit approved | Finance | Ledger reference |
| IO + offer brief | Advertiser Lead | Signed IO |
| Affise offer + caps | Finance & Ops | Offer ID documented |
| Traffic allowed | — | Publishers assigned per IO |

**Rule:** No publisher traffic to advertiser offer until prepay/credit gate is green.

---

## Offer lifecycle (existing advertiser)

| Step | Owner |
|------|--------|
| Advertiser requests new offer / geo | Advertiser Lead |
| Compliance checks vertical licence still valid | Compliance |
| IO drafted from [07-insertion-order-template.md](07-insertion-order-template.md) | Advertiser Lead |
| Finance confirms budget / prepay slice | Finance |
| Affise configured | Finance & Ops |
| Publishers invited (approved only) | Publisher Lead |
| Listed on `/offers` (optional marketing) | Ops / MD |

See [14-offer-launch-checklist.md](14-offer-launch-checklist.md).

---

## Status reference (Laravel compliance UI)

| Status | Partner can get links? |
|--------|------------------------|
| `applied` | No |
| `documents_requested` | No |
| `under_review` | No |
| `enhanced_dd` | No |
| `on_hold` | No |
| `approved` | Yes (per IO) |
| `rejected` | No |
| `offboarded` | No — links disabled |

Full definitions: [approval-workflow](../due-diligence/approval-workflow.md).

---

## Documents per partner type

| Type | Agreement | IO | Onboarding (by stage) | DD checklist |
|------|-----------|-----|------------------------|--------------|
| Publisher | [05-publisher-agreement.md](05-publisher-agreement.md) | Per offer | [onboarding/publisher](../due-diligence/onboarding/README.md) | [publisher-checklist](../due-diligence/publisher-checklist.md) |
| Advertiser | [06-advertiser-agreement.md](06-advertiser-agreement.md) | Per offer | [onboarding/advertiser](../due-diligence/onboarding/README.md) | [advertiser-checklist](../due-diligence/advertiser-checklist.md) |

---

## Success metrics (simple)

| Metric | Target |
|--------|--------|
| Application → decision | ≤ 10 business days (complete pack) |
| Publisher payout on time | ≥ 98% by 15th |
| Advertiser prepay before live | 100% |
| Fraud rate (invalid / total conv) | < 5% per offer (investigate if above) |
| DD pack completeness at first request | ≥ 80% |

Review monthly in stand-up — adjust targets once you have six months of data.
