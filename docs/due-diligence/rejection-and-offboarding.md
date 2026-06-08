# Rejection & offboarding

## Immediate reject triggers (no negotiation)

| Code | Trigger |
|------|---------|
| R-04 / A-04 | Confirmed sanctions match |
| R-04 | Document forgery |
| R-02 | Refusal to provide mandatory traffic proof |
| R-02 | Admitted bot/incentivised traffic on prohibited offers |
| A-03 | Unlicensed regulated product |
| A-01 | Insolvency or active winding-up |
| * | Internal blocklist match |
| * | Threatening or abusive conduct toward staff |

## Soft reject (may reapply after 12 months with new evidence)

| Code | Trigger |
|------|---------|
| R-01 | Entity < 90 days old without probation path |
| R-06 | Incomplete docs after extension |
| A-01 | Failed credit — may return with prepay |
| R-07 | Risk score 60+ |

## Rejection process

1. Compliance Lead selects reason code(s).
2. Log in `due_diligence_reviews.rejection_reason` + `rejection_notes`.
3. Send templated email (`templates/rejection-notice.md`) — **no detailed fraud accusations in writing** (legal risk); use generic codes.
4. Do **not** create Affise account.
5. Add email domain + company number to watchlist if fraud suspected.

## Post-approval offboarding

| Trigger | Action |
|---------|--------|
| Fraud confirmed in Affise | Immediate pause → terminate → clawback review |
| Sanctions hit on re-screen | Immediate pause → legal review |
| Advertiser non-payment | Pause all offers → Finance chase → offboard |
| Publisher quality < threshold | Warning → cap reduction → terminate |
| Contract breach | Per agreement notice period |

### Offboarding checklist

- [ ] Affise partner/advertiser disabled
- [ ] IO terminated in writing
- [ ] Final payment reconciliation (publishers)
- [ ] Outstanding advertiser invoice collected
- [ ] DD folder marked `offboarded` — retention clock starts
- [ ] Watchlist updated
- [ ] Internal post-mortem if fraud (blameless ops review)
