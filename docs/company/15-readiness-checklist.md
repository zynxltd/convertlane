# Readiness checklist — what you have vs what you still need

Use this before calling the network “live.” **Green** = covered in repo/docs. **Amber** = drafted but needs your action. **Red** = not built yet — assign owner.

---

## A. Documentation (policies & contracts)

| Item | Status | Where / action |
|------|--------|----------------|
| Team RACI & sign-offs | Green | [01-team-and-responsibilities.md](01-team-and-responsibilities.md) |
| Per-role playbooks | Green | [roles/](roles/) |
| Partner lifecycle | Green | [02-partner-lifecycle.md](02-partner-lifecycle.md) |
| KYC/KYB policy + DD SOPs | Green | [03-kyc-kyb-policy.md](03-kyc-kyb-policy.md) + [due-diligence/](../due-diligence/) |
| Fraud & traffic rules | Green | [04](04-compliance-fraud-policy.md), [10](10-traffic-creative-policy.md) |
| Publisher / advertiser agreements | Amber | [05](05-publisher-agreement.md), [06](06-advertiser-agreement.md) — **solicitor sign-off** |
| IO template | Amber | [07-insertion-order-template.md](07-insertion-order-template.md) |
| Payout & billing policy | Green | [08](08-publisher-payout-policy.md), [09](09-advertiser-billing-policy.md) |
| Escalation & offboarding | Green | [12](12-incident-escalation.md), [13](13-offboarding.md) |
| Offer go-live checklist | Green | [14-offer-launch-checklist.md](14-offer-launch-checklist.md) |
| Control gates (no bypass) | Green | [16-control-gates.md](16-control-gates.md) |
| Master ops calendar | Green | [17-ops-calendar.md](17-ops-calendar.md) |
| Small-team operating system | Green | [20-small-team-operating-system.md](20-small-team-operating-system.md) |
| Per-role internal workflows | Green | [workflows/](workflows/00-index.md) |
| Stage-based client + compliance docs | Green | [due-diligence/onboarding/](../due-diligence/onboarding/README.md) |
| Publisher DD checklist (detailed) | Green | [publisher-checklist.md](../due-diligence/publisher-checklist.md) |

---

## B. Technology (this Laravel app)

| Item | Status | Action |
|------|--------|--------|
| Marketing site + apply form | Green | Live |
| Auto-open DD review on apply | Green | `DueDiligenceService::openReview` |
| Compliance portal `/compliance` | Green | Set `COMPLIANCE_ACCESS_KEY`; **add proper auth before production** |
| Sign-off enforcement on approve | Green | Code blocks approve without sign-offs |
| Affise API sync on approve | Amber | Stub in `AffiseService` — **wire + test** |
| Email on new application | Red | Configure mail + notification to Compliance |
| Email document request | Red | Automate or manual from template |
| Admin dashboard (Filament) | Red | SETUP.md Phase 7 — optional but helps AMs |
| Publisher payout ledger | Red | Spreadsheet minimum — see Finance playbook |
| Advertiser prepay ledger | Red | Spreadsheet minimum |
| Offer list on site | Green | `/offers` |
| Secure document upload for DD | Red | Encrypted drive or upload tool — **do not use email for IDs** |

---

## C. External systems

| Item | Status | Action |
|------|--------|--------|
| Affise (tracking + panel) | Amber | Contract, offers, caps, fraud rules |
| Wise Business (payouts) | Amber | Account, verification, batch process |
| Companies House / KYB tools | Amber | Compliance picks one sanctions API |
| Email (partners@) | Amber | Shared inbox + labels per role |
| Accounting (Xero/FreeAgent) | Amber | Invoices, VAT |
| Encrypted file storage | Amber | DD packs — Drive/Dropbox with 2FA |
| Password manager (team) | Amber | 1Password etc. — no shared passwords in Slack |

---

## D. Legal & regulatory

| Item | Status | Action |
|------|--------|--------|
| UK Ltd registered | Amber | Your entity |
| Solicitor-reviewed agreements | Red | Before first paid partner |
| DPAs (Affise, Wise, host) | Red | Compliance + MD |
| Vertical licences verified per offer | Amber | iGaming / finance checklists |
| ICO registration (if required) | Amber | Compliance confirms |

---

## E. “Fail-proof” minimum to go live

All must be true:

- [ ] Five roles named with backups ([roles/00-index.md](roles/00-index.md))
- [ ] `COMPLIANCE_ACCESS_KEY` set; compliance portal tested
- [ ] Document request sent within 2 days of every application
- [ ] No Affise link without `approved` + signed IO ([16-control-gates.md](16-control-gates.md))
- [ ] No advertiser traffic without prepay/credit on ledger
- [ ] Finance payout spreadsheet + Affise export process tested once
- [ ] Weekly stand-up on calendar ([17-ops-calendar.md](17-ops-calendar.md))
- [ ] One full test: fake publisher apply → DD → approve → test offer → test conversion
- [ ] One full test: fake advertiser apply → prepay → offer live

---

## F. What we deliberately keep simple (do not overbuild)

| Keep simple | Why |
|-------------|-----|
| Spreadsheets for cash waterfall | Five people do not need ERP on day one |
| Email + templates for partner comms | CRM later when pipeline > 50 active |
| Compliance portal = key URL + future auth | Good enough until headcount grows |
| Single shared partners@ inbox | Labels: DD, Finance, AM-Pub, AM-Adv |

---

## G. Loose ends to close (common failures)

| Failure mode | Prevention |
|--------------|------------|
| “Approved” but no IO | Gate 4 in [16-control-gates.md](16-control-gates.md) |
| Traffic live, no prepay | Finance gate on [14-offer-launch-checklist.md](14-offer-launch-checklist.md) |
| Pay publisher before advertiser pays | Cash waterfall rule in [09-advertiser-billing-policy.md](09-advertiser-billing-policy.md) |
| Compliance on holiday, approvals continue | OOO rule in [01-team-and-responsibilities.md](01-team-and-responsibilities.md) |
| Cap blown, still paying | Affise auto-pause + weekly cap review |
| Lost ID documents | Encrypted storage + [document-retention](../due-diligence/document-retention.md) |
| Two AMs give conflicting rates | IO signed only by owning AM + MD if >10% change |

---

**Next step:** Each person reads their playbook in [roles/](roles/) and ticks [17-ops-calendar.md](17-ops-calendar.md) for recurring tasks.
