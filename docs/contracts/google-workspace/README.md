# Google Workspace — contracts setup

Import these into your **ConvertLane — Compliance** Shared Drive → `Templates/`.

All three contracts use **Google Docs**.

**Signing workflow (start here):** [signing-workflow.md](signing-workflow.md)

---

## Import all templates (Google Docs)

1. Go to [Google Docs](https://docs.google.com) → **Blank document**
2. **File → Open → Upload** → select the `.txt` file
3. Format: add ConvertLane logo header, Arial 11, page numbers
4. Save to `Templates/` with the names below

| Template | Upload file | Save as |
|----------|-------------|---------|
| Affiliate agreement | `affiliate-agreement.txt` | Affiliate Agreement — Template |
| Advertiser agreement | `advertiser-agreement.txt` | Advertiser Agreement — Template |
| Insertion Order (IO) | `io-template.txt` | IO Template — Finance |

**Per partner / per offer:** File → **Make a copy** → fill blanks → export signed PDF.

---

## IO workflow

1. Copy **IO Template — Finance** from `Templates/`
2. Rename: `CL-IO-2026-001 — Partner Name`
3. Fill all fields; tick relevant checkboxes (Affiliate vs Advertiser, vertical, payment section)
4. Delete the **INTERNAL ONLY** section at the bottom before sending to partner
5. Sign → save PDF to `IOs/`
6. Log the IO in `io-register.csv` (optional Sheet) or your IO Register doc

---

## Optional: IO register (Google Sheet)

Track all IOs in one place — import `io-register.csv` as a separate spreadsheet:

| IO number | Partner | Type | Offer | Vertical | Status | Signed date |
|-----------|---------|------|-------|----------|--------|-------------|

---

## Folder layout (Google Drive)

```
ConvertLane — Compliance/
├── Templates/
│   ├── Affiliate Agreement — Template    (Google Doc)
│   ├── Advertiser Agreement — Template   (Google Doc)
│   └── IO Template — Finance             (Google Doc)
├── IOs/
│   └── CL-IO-2026-001 — Partner Name.pdf
├── Signed Agreements/
└── DD-P-001/  DD-A-001/
```

---

## Source files (repo)

| Document | Markdown | Google Doc import |
|----------|------------|-------------------|
| Affiliate agreement | `../affiliate-agreement.md` | `affiliate-agreement.txt` |
| Advertiser agreement | `../advertiser-agreement.md` | `advertiser-agreement.txt` |
| IO template | `../insertion-order-template.md` | `io-template.txt` |
