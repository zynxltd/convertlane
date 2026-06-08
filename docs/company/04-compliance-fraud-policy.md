# Compliance & fraud policy

**Owner:** Head of Compliance · **Review:** Annual

---

## Purpose

Protect advertisers, publishers, and ConvertLane from invalid traffic, misrepresentation, and regulatory harm.

---

## Network rules (all partners)

1. Promote only **approved offers** with **approved creatives** and **approved geos**.  
2. **No incent traffic** unless IO explicitly allows.  
3. **No brand bidding** on advertiser trademarks unless IO allows.  
4. **No bot, proxy, or fraudulent** registration methods.  
5. **Disclose** affiliate relationship per local law (FTC, ASA, CAP, etc.).  
6. **Report** suspected fraud within **24 hours** to compliance@ / partners@.  
7. **Do not** share confidential rates, caps, or advertiser names marked private.  

Details: [10-traffic-creative-policy.md](10-traffic-creative-policy.md).

---

## Fraud types we act on

| Type | Typical signal | Action |
|------|----------------|--------|
| Click fraud | Abnormal CTR, datacenter IPs | Pause sub-ID, investigate |
| Lead fraud | Duplicate data, impossible velocity | Reject conversions, clawback |
| Cookie stuffing | Zero-click conversions | Terminate, withhold payout |
| Brand bidding violation | SEM on trademark | Warning → terminate |
| Misleading creative | Non-compliant claims | Pause creative, fix or terminate |
| Geo fraud | Traffic outside allowed geo | Reject geo-invalid conv |
| Self-referral | Publisher = end user pattern | Reject + terminate |

---

## Investigation process (simple)

| Step | Owner | SLA |
|------|-------|-----|
| 1. Flag raised (Affise, advertiser, manual) | Any | Log in shared sheet |
| 2. Triage | Compliance | 1 business day |
| 3. Publisher contacted for explanation | AM | 2 business days |
| 4. Decision: clear / deduct / terminate | Compliance | 1 business day after response |
| 5. Update Affise + notify advertiser | Finance & Ops | Same day |

**During investigation:** Pause affected sub-IDs or offer cap if risk is material.

---

## Conversion validity

A conversion is **payable** only if:

- Generated through Affise tracking link assigned to approved publisher  
- Within cookie window in IO  
- In allowed geo  
- Meets IO event definition (e.g. funded loan, FTD)  
- Passes advertiser validation (not rejected in postback)  
- Not on internal fraud blocklist  

Advertiser disputes: Finance & Ops pulls Affise logs; Compliance rules if fraud alleged.

---

## Clawbacks & deductions

- Invalid conversions **deducted** from next publisher payout  
- If publisher already paid, **invoice or offset** against future earnings  
- Document every deduction with Affise conversion IDs  

---

## Cap management

- Caps set in Affise match signed IO  
- Over-delivery: AM contacts publisher same day; conversions above cap not payable unless IO amended in writing  
- Auto-pause at 100% cap unless IO allows soft cap with advertiser consent  

---

## Regulatory verticals

| Vertical | Extra requirement |
|----------|-------------------|
| Finance | FCA or local regulator awareness; clear risk warnings on landers |
| iGaming | Valid licence for target geo; age gating |
| Health | No unsubstantiated medical claims; pre-lander approval |
| Dating | SOI/DOI quality standards; no spam |

Compliance maintains a **one-page vertical addendum** per industry — attach to IO when needed.

---

## Escalation

See [12-incident-escalation.md](12-incident-escalation.md).  
Termination: [13-offboarding.md](13-offboarding.md) and [rejection-and-offboarding](../due-diligence/rejection-and-offboarding.md).
