# Partner onboarding — document pack (by stage)

**Version:** 1.0 · **For review:** ConvertLane internal  
**Legal entity:** ConvertLane Ltd · United Kingdom

This folder contains **two copies of every stage**:

| Copy | Folder | Audience | Use |
|------|--------|----------|-----|
| **Client** | `advertiser/client/` · `publisher/client/` | Partner (email / PDF) | Send as-is; replace `{{placeholders}}` |
| **Compliance** | `advertiser/compliance/` · `publisher/compliance/` | Internal only | Checklist, sign-off, audit trail |

**Do not send compliance documents to partners.**

---

## Workflow alignment

Maps to Laravel status and [approval-workflow.md](../approval-workflow.md):

```
Stage 1  applied              → Acknowledgement
Stage 2  documents_requested  → Document request pack
Stage 3  under_review         → Review in progress (optional client note)
Stage 4  on_hold              → Hold notice + internal hold log
Stage 5  enhanced_dd          → Enhanced DD request (if required)
Stage 6  approved             → Welcome + next steps
Stage 7  (post-approve)       → Agreement & IO execution
Stage 8  (advertiser)         → Prepay / funding instructions
Stage 8  (publisher)          → Payment details & Wise verification
Stage 9  (post-approve)       → Go-live confirmation
Stage 10 rejected             → Rejection notice
```

**Gates:** [16-control-gates.md](../../company/16-control-gates.md) · **Detailed DD:** [advertiser-checklist.md](../advertiser-checklist.md) · [publisher-checklist.md](../publisher-checklist.md)

---

## Advertiser pack

| Stage | Client document | Compliance document |
|-------|-----------------|---------------------|
| 1 | [client/01-application-acknowledgement.md](advertiser/client/01-application-acknowledgement.md) | [compliance/01-intake-record.md](advertiser/compliance/01-intake-record.md) |
| 2 | [client/02-document-request-pack.md](advertiser/client/02-document-request-pack.md) | [compliance/02-document-intake-checklist.md](advertiser/compliance/02-document-intake-checklist.md) |
| 3 | [client/03-review-in-progress.md](advertiser/client/03-review-in-progress.md) | [compliance/03-under-review-worksheet.md](advertiser/compliance/03-under-review-worksheet.md) |
| 4 | [client/04-on-hold-notice.md](advertiser/client/04-on-hold-notice.md) | [compliance/04-on-hold-log.md](advertiser/compliance/04-on-hold-log.md) |
| 5 | [client/05-enhanced-due-diligence-request.md](advertiser/client/05-enhanced-due-diligence-request.md) | [compliance/05-enhanced-dd-checklist.md](advertiser/compliance/05-enhanced-dd-checklist.md) |
| 6 | [client/06-approval-welcome.md](advertiser/client/06-approval-welcome.md) | [compliance/06-approval-sign-off.md](advertiser/compliance/06-approval-sign-off.md) |
| 7 | [client/07-agreement-and-commercial-pack.md](advertiser/client/07-agreement-and-commercial-pack.md) | [compliance/07-agreement-filing-checklist.md](advertiser/compliance/07-agreement-filing-checklist.md) |
| 8 | [client/08-funding-and-prepay-instructions.md](advertiser/client/08-funding-and-prepay-instructions.md) | [compliance/08-funding-gate-sign-off.md](advertiser/compliance/08-funding-gate-sign-off.md) |
| 9 | [client/09-go-live-confirmation.md](advertiser/client/09-go-live-confirmation.md) | [compliance/09-go-live-sign-off.md](advertiser/compliance/09-go-live-sign-off.md) |
| 10 | [client/10-application-declined.md](advertiser/client/10-application-declined.md) | — (use rejection code in audit log) |

**Attachments (client completes):**

| Document | Location |
|----------|----------|
| Due diligence questionnaire | [advertiser-questionnaire.md](../advertiser-questionnaire.md) |
| UBO declaration | [templates/ubo-declaration.md](../templates/ubo-declaration.md) |
| Credit check authorisation | [client/attachments/credit-check-authorisation.md](advertiser/client/attachments/credit-check-authorisation.md) |
| Credit application (if credit requested) | [../../company/templates/credit-application-advertiser.md](../../company/templates/credit-application-advertiser.md) |
| Master agreement | [../../company/06-advertiser-agreement.md](../../company/06-advertiser-agreement.md) |
| IO template | [../../company/07-insertion-order-template.md](../../company/07-insertion-order-template.md) |

---

## Publisher pack

| Stage | Client document | Compliance document |
|-------|-----------------|---------------------|
| 1 | [client/01-application-acknowledgement.md](publisher/client/01-application-acknowledgement.md) | [compliance/01-intake-record.md](publisher/compliance/01-intake-record.md) |
| 2 | [client/02-document-request-pack.md](publisher/client/02-document-request-pack.md) | [compliance/02-document-intake-checklist.md](publisher/compliance/02-document-intake-checklist.md) |
| 3 | [client/03-review-in-progress.md](publisher/client/03-review-in-progress.md) | [compliance/03-under-review-worksheet.md](publisher/compliance/03-under-review-worksheet.md) |
| 4 | [client/04-on-hold-notice.md](publisher/client/04-on-hold-notice.md) | [compliance/04-on-hold-log.md](publisher/compliance/04-on-hold-log.md) |
| 5 | [client/05-enhanced-due-diligence-request.md](publisher/client/05-enhanced-due-diligence-request.md) | [compliance/05-enhanced-dd-checklist.md](publisher/compliance/05-enhanced-dd-checklist.md) |
| 6 | [client/06-approval-welcome.md](publisher/client/06-approval-welcome.md) | [compliance/06-approval-sign-off.md](publisher/compliance/06-approval-sign-off.md) |
| 7 | [client/07-agreement-and-io-pack.md](publisher/client/07-agreement-and-io-pack.md) | [compliance/07-agreement-filing-checklist.md](publisher/compliance/07-agreement-filing-checklist.md) |
| 8 | [client/08-payment-details-request.md](publisher/client/08-payment-details-request.md) | [compliance/08-payout-verification.md](publisher/compliance/08-payout-verification.md) |
| 9 | [client/09-go-live-confirmation.md](publisher/client/09-go-live-confirmation.md) | [compliance/09-go-live-sign-off.md](publisher/compliance/09-go-live-sign-off.md) |
| 10 | [client/10-application-declined.md](publisher/client/10-application-declined.md) | — |

**Attachments:**

| Document | Location |
|----------|----------|
| Publisher questionnaire | [publisher-questionnaire.md](../publisher-questionnaire.md) |
| UBO declaration | [templates/ubo-declaration.md](../templates/ubo-declaration.md) |
| Payment details form | [../../company/templates/publisher-payment-details.md](../../company/templates/publisher-payment-details.md) |
| Master agreement | [../../company/05-publisher-agreement.md](../../company/05-publisher-agreement.md) |

---

## Sending checklist (ops)

Before each send:

1. Replace all `{{placeholders}}` (partner name, ID, dates, links).  
2. Use corporate email: `compliance@convertlane.co.uk` (DD) or `partners@convertlane.co.uk` (commercial).  
3. Save sent PDF/email to DD folder: `DD-{type}-{id}/correspondence/`.  
4. Update `/compliance` status to match stage.  
5. Log audit note if status changes.

---

## Policies referenced (internal)

| Topic | Document |
|-------|----------|
| KYC/KYB policy | [03-kyc-kyb-policy.md](../../company/03-kyc-kyb-policy.md) |
| Credit & cash flow | [18-advertiser-credit-and-cashflow-procedure.md](../../company/18-advertiser-credit-and-cashflow-procedure.md) |
| Chargebacks | [19-chargebacks-and-clawbacks.md](../../company/19-chargebacks-and-clawbacks.md) |
| Offboarding | [13-offboarding.md](../../company/13-offboarding.md) |
