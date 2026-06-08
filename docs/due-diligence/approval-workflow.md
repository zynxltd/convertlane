# Approval workflow

**Stage documents (client + compliance):** [onboarding/README.md](onboarding/README.md)

## Status machine

```
applied → documents_requested → under_review → enhanced_dd → approved
                              ↘              ↘
                                on_hold        rejected
                              ↘
                                offboarded (post-approval exit)
```

| Status | Meaning | Who acts |
|--------|---------|----------|
| `applied` | Web form submitted | System |
| `documents_requested` | Missing items; 7-day deadline | Compliance |
| `under_review` | Full pack received | Compliance + Finance + AM |
| `enhanced_dd` | High risk (score 40–59) or red flag | Compliance Lead only |
| `on_hold` | Waiting on partner (bank ref, licence, etc.) | AM |
| `approved` | All sign-offs; Affise + IO allowed | Compliance Lead |
| `rejected` | Failed DD; no appeal without new entity | Compliance Lead |
| `offboarded` | Terminated post-approval | Compliance Lead |

## Sign-off matrix

| Gate | Publisher | Advertiser | Signatory |
|------|-----------|------------|-----------|
| Identity & entity verified | ✓ | ✓ | Compliance |
| Sanctions / PEP clear | ✓ | ✓ | Compliance |
| Traffic / offer legitimate | ✓ | ✓ | AM + Compliance |
| Financial viability | Optional | **Required** | Finance |
| Credit / prepay in place | N/A | **Required** | Finance |
| IO / rate card agreed | ✓ | ✓ | AM |
| Risk score within band | ✓ | ✓ | Compliance |
| Affise account created | ✓ | ✓ | Ops |

**Minimum approvers:** Compliance Lead + one of (Finance for advertisers, AM for publishers).

## SLAs

| Stage | SLA |
|-------|-----|
| First response after application | 2 business days |
| Document request sent | Within 2 business days of application |
| Partner document deadline | 7 business days (extensions only with Compliance approval) |
| Review completion once pack complete | 5 business days |
| Enhanced DD | 10 business days |

## Audit trail

Every status change must log:

- `changed_by` (user email)
- `from_status` / `to_status`
- `notes` (mandatory on reject, on_hold, enhanced_dd)
- `timestamp`

Stored in `due_diligence_reviews` and `due_diligence_audit_logs`.
