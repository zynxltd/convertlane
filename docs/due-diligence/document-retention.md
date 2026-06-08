# Document retention & storage

## Storage rules

| Rule | Requirement |
|------|-------------|
| Location | Encrypted cloud (S3/Google Drive) — folder per partner `DD-{id}/` |
| Access | Compliance + Finance only; AM read-only on own partners |
| Naming | `{date}_{doctype}_{partnerid}.pdf` |
| PII | No storage in Slack/email attachments long-term — move to vault within 48h |
| Laravel DB | Metadata + status only; not full ID images in production DB unless encrypted disk |

## Retention periods

| Document type | Minimum retention |
|---------------|-------------------|
| Signed agreements & IOs | 7 years after relationship ends |
| KYC / ID copies | 7 years |
| Financial statements / credit reports | 7 years |
| Sanctions screening results | 7 years |
| Email / audit logs | 7 years |
| Application form data | 7 years |
| Rejected applications | 3 years (fraud: 7 years) |

## Deletion

- Only Compliance Lead may authorise deletion after retention period.
- Log deletion in audit trail.
- GDPR erasure requests: legal review before deletion if active disputes.

## Required folder structure per partner

```
DD-P-00042/
├── 01-application.pdf
├── 02-incorporation.pdf
├── 03-ids/
├── 04-sanctions/
├── 05-traffic-proof/
├── 06-agreements/
├── 07-risk-matrix.pdf
├── 08-finance/          (advertisers)
├── 09-io/
└── audit-log.txt
```
