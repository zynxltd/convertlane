# Ongoing partner monitoring

**Principle:** Approval is not permanent. Re-screen and re-score on triggers.

## Scheduled reviews

| Partner type | Frequency | Owner |
|--------------|-----------|-------|
| Publisher — probation | Weekly (90 days) | AM |
| Publisher — established | Quarterly | AM + Compliance sample |
| Advertiser — all | Monthly financial check | Finance |
| Advertiser — high exposure | Bi-weekly cap vs prepay balance | Finance |
| All UBOs | Annual sanctions re-screen | Compliance |

## Automated triggers (Affise + finance)

| Signal | Action |
|--------|--------|
| Fraud score spike | Auto-pause + AM within 4h |
| Discrepancy > 5% | Hold publisher payment pending review |
| Cap exceeded | Auto-pause offer |
| Advertiser balance < 2 weeks runway | Finance alert → pause new caps |
| Chargeback rate > 2% (advertiser) | Compliance review |

## Quarterly publisher sample (min 10% of active base)

- [ ] Traffic source still matches DD file
- [ ] Spot-check 5 conversions per publisher
- [ ] Creative / LP still compliant
- [ ] Sanctions re-screen
- [ ] Update risk score if material change

## Annual advertiser refresh

- [ ] Updated accounts or management accounts
- [ ] Licence renewal verified (regulated)
- [ ] Credit limit recalculated
- [ ] IO terms still valid

## Watchlist

Maintain `storage/compliance/watchlist.csv` (or DB table):

- Company registration numbers
- Domains
- Director names
- Email domains

**Any application matching watchlist → auto `under_review` + Compliance only.**
