# Risk scoring matrix

**Score each line item. Sum total. Compliance Lead approves band override only.**

## Scoring bands

| Total score | Band | Action |
|-------------|------|--------|
| 0–19 | **Low** | Standard DD; approve if pack complete |
| 20–39 | **Medium** | Full DD; AM + Compliance sign-off |
| 40–59 | **High** | Enhanced DD mandatory; Finance review (advertisers) |
| 60+ | **Critical** | **Auto-reject** unless Compliance Lead documents exception |

---

## Publisher / affiliate factors

| # | Factor | 0 pts | 5 pts | 10 pts | 15 pts |
|---|--------|-------|-------|--------|--------|
| 1 | Entity age | 3+ years | 1–3 years | < 1 year | No verifiable entity |
| 2 | Jurisdiction | UK/IE/US/EU low-risk | Other Tier-2 | Tier-3 / offshore | Sanctioned / high-risk list |
| 3 | Company registry match | Exact match | Minor discrepancy | Cannot verify | Shell / nominee only |
| 4 | Traffic proof | Analytics + history | Screenshots only | Self-reported only | Refuses proof |
| 5 | Vertical experience | 2+ years same vertical | < 2 years | New to vertical | Prohibited vertical attempt |
| 6 | References | 2 verifiable refs | 1 ref | None | Negative ref / fraud rumour |
| 7 | Domain / site quality | Established site 12mo+ | New site 6–12mo | New < 6mo | Parked / thin / PBN signals |
| 8 | Sanctions / PEP | Clear | — | PEP (low) | Hit or refuse screening |
| 9 | Prior network termination | Never | — | Rumour unverified | Confirmed termination for fraud |
| 10 | Payment profile | Wise verified business | Personal Wise | Crypto-only request | Obfuscated payout |

---

## Advertiser factors

| # | Factor | 0 pts | 5 pts | 10 pts | 15 pts |
|---|--------|-------|-------|--------|--------|
| 1 | Entity & licence | Licensed + verified | Regulated no licence needed | Unlicensed regulated vertical | False licence claims |
| 2 | Financial statements | Audited / filed accounts < 18mo | Management accounts | No accounts | Insolvent / CCJ / winding-up |
| 3 | Credit / prepay | Prepay received | Credit line approved | Net-30 unsecured | Refuses prepay / credit check |
| 4 | Product / landing | Compliant LPs live | LP pending approval | Aggressive claims | Misleading / illegal product |
| 5 | Postback / tech | Tested successfully | Partial test | No test | Tracking manipulation |
| 6 | Beneficial owners | All identified < 25% | One opaque | Cannot identify UBOs | Offshore trust chain |
| 7 | Chargeback / refund policy | Documented fair policy | Unclear | High-risk model | No refunds on subscriptions |
| 8 | Brand reputation | Known brand | Startup funded | Unknown | Adverse media / litigation |
| 9 | IO history | Clean with other networks | First offer | Dispute history | Fraud allegation |
| 10 | Sanctions / PEP | Clear | — | PEP | Hit |

---

## Automatic escalations (minimum band = High)

- Any sanctions match (even false positive until cleared)
- Advertiser in iGaming without licence for target geo
- Finance vertical without FCA permissions where required
- Publisher requests brand bidding on restricted offers
- Use of incentivised traffic without disclosure
- VPN/proxy traffic sources admitted
- Refusal to provide certificate of incorporation or ID

## Automatic reject (no exception without Board minute)

- Confirmed fraud on any network
- Sanctions confirmed match
- Fake documents
- Entity on internal blocklist
- Under 18 or individual account for B2B network (unless sole trader with UTR + verified)

---

## Record keeping

Store completed matrix PDF/spreadsheet in DD folder:  
`DD-{partner_id}-{type}-{date}.pdf`
