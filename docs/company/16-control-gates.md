# Control gates — nothing goes live without passing

**Rule:** If a gate fails, **stop**. Fix or reject. No verbal exceptions without MD + Compliance written note in audit log.

---

## Gate 1 — Application received

| Check | Owner | System |
|-------|-------|--------|
| Form complete | System | `/apply` |
| DD review opened | System | `due_diligence_reviews` |
| Compliance notified | Compliance | Email/Slack (set up if missing) |

**Fail:** Incomplete application → request missing fields, status `documents_requested` or close after 7 days.

---

## Gate 2 — Due diligence complete

| Check | Owner |
|-------|-------|
| Correct checklist 100% ticked | Compliance |
| Risk score calculated & band OK | Compliance |
| Sanctions clear | Compliance |
| Traffic proof (pub) / licence (adv) | Compliance + AM |
| Sign-offs in compliance UI | Compliance + AM + Finance (adv) |

**Status required:** `approved` (not `on_hold`, not `enhanced_dd` without Lead sign-off).

**Fail:** → `rejected` or `on_hold` with notes. **No Affise.**

---

## Gate 3 — Master agreement signed

| Partner | Document |
|---------|----------|
| Publisher | [05-publisher-agreement.md](05-publisher-agreement.md) |
| Advertiser | [06-advertiser-agreement.md](06-advertiser-agreement.md) |

Stored in DD folder. Dated signatures.

**Fail:** No tracking links, no IO discussion.

---

## Gate 4 — IO signed (per offer)

| Check | Owner |
|-------|-------|
| IO matches commercial discussion | Owning AM |
| Compliance vertical OK | Compliance |
| Caps/geos/traffic match Affise plan | Finance & Ops |

**Fail:** Affise cap stays at zero.

---

## Gate 5 — Advertiser funding (advertisers only)

| Check | Owner |
|-------|-------|
| Prepay received **or** credit approved | Finance |
| Ledger reference matches offer ID | Finance |
| Balance covers cap | Finance |

**Fail:** Offer paused. Publishers not added.

---

## Gate 6 — Affise configured

| Check | Owner |
|-------|-------|
| [14-offer-launch-checklist.md](14-offer-launch-checklist.md) complete | Finance & Ops |
| Test click + conversion | Finance & Ops |
| Only approved publishers assigned | Publisher Lead |

**Fail:** Do not announce offer publicly.

---

## Gate 7 — Ongoing (monthly)

| Check | Owner | When |
|-------|-------|------|
| Cap vs delivery | AMs | Weekly |
| Fraud flags | Compliance | Weekly |
| Advertiser balance | Finance | Weekly |
| Publisher payout reconciled | Finance | Before 15th |
| Active partner DD refresh | Compliance | Quarterly |

---

## Quick reference card (print)

```
APPLY → DD APPROVED → AGREEMENT → IO → [PREPAY] → AFFISE → LIVE
         ↑              ↑          ↑      ↑         ↑
      Compliance    Compliance   AM    Finance    Ops
```

Any skip = process breach. Log incident if it already happened.
