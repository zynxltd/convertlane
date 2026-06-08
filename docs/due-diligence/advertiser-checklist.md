# Advertiser DD checklist (detailed)

**Partner ID:** `DD-A-________` · **Application date:** __________ · **Reviewer:** __________

**SOP:** [advertiser-sop.md](advertiser-sop.md) · **Credit/cash:** [18-advertiser-credit-and-cashflow-procedure.md](../company/18-advertiser-credit-and-cashflow-procedure.md) · **Risk score:** [risk-scoring-guide.md](risk-scoring-guide.md)

Use this checklist during review. Each line has **Owner**, **How**, **Pass**, and **Evidence**.

---

## A. Application intake

### A1. Application form complete
| | |
|---|---|
| **Owner** | Advertiser Lead |
| **How** | Open `/compliance` review or application email; every required field filled (entity, contacts, vertical, geos, URLs). |
| **Pass** | No blank mandatory fields; billing contact matches signatory or authorised AP. |
| **Evidence** | Application export / email thread in `DD-A-xxx/01-intake/` |

- [ ] Done

### A2. Legal entity (not individual)
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Confirm applicant is Ltd/LLC/PLC etc. Sole traders only if UK with UTR + business bank; otherwise reject. |
| **Pass** | Registered company name on form matches certificate. |
| **Evidence** | Certificate of incorporation |

- [ ] Done

### A3. Product / vertical identified
| | |
|---|---|
| **Owner** | Advertiser Lead |
| **How** | Classify vertical (iGaming, finance, health, utility, etc.); note regulated vs not. |
| **Pass** | Vertical written on checklist header; drives licence checklist in section D. |
| **Evidence** | Application + LP review note |

- [ ] Vertical: ______

### A4. Target geos listed
| | |
|---|---|
| **Owner** | Advertiser Lead |
| **How** | List countries from application; cross-check LP and licence coverage. |
| **Pass** | Geos explicit; no “worldwide” without per-geo licence plan. |
| **Evidence** | Application + IO draft geos |

- [ ] Geos: ______

### A5. Landing page URL live
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Open URL in clean browser; confirm loads, HTTPS, matches product; not parked domain. |
| **Pass** | Live LP; product matches application; no malware/phishing flags. |
| **Evidence** | Screenshot dated ______ in `03-product/` |

- [ ] URL: ______

### A6. Initial risk score
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Complete [risk-scoring-matrix.md](risk-scoring-matrix.md) (advertiser table); enter total in `/compliance`. |
| **Pass** | Score + band recorded; escalations applied if triggered. |
| **Evidence** | `DD-A-xxx-risk-YYYY-MM-DD.pdf` |

- [ ] Score: ______ Band: ______

---

## B. Corporate & identity

### B1. Certificate of incorporation
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Request PDF; verify issue date, company number, legal name. |
| **Pass** | Document < 3 years old or current extract; name matches application. |
| **Evidence** | `02-corporate/incorporation.pdf` |

- [ ] Done

### B2. Articles / constitution
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Obtain memorandum/articles or equivalent; skim objects clause for gambling/finance if relevant. |
| **Pass** | On file; objects not contradictory to stated business. |
| **Evidence** | `02-corporate/articles.pdf` |

- [ ] Done

### B3. Directors + UBO register
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Request signed UBO declaration listing all ≥25% owners + directors; compare to registry. |
| **Pass** | All UBOs named; matches Companies House (or explain discrepancy). |
| **Evidence** | `02-corporate/ubo-register.pdf` |

- [ ] Done

### B4. ID — authorised signatory
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Passport or driving licence + proof of address if policy requires; name matches signatory on agreement. |
| **Pass** | Valid ID, not expired; photo readable. |
| **Evidence** | `02-corporate/id-signatory.pdf` (secure store) |

- [ ] Done

### B5. ID — all UBOs ≥ 25%
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Collect ID for each UBO on register; same standard as signatory. |
| **Pass** | One file per UBO; no missing owner. |
| **Evidence** | `02-corporate/id-ubo-*.pdf` |

- [ ] Done

### B6. Registry verification
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Look up company on official registry (e.g. Companies House); confirm active, address, directors. |
| **Pass** | Status **Active**; no strike-off; number matches cert. |
| **Evidence** | Registry screenshot — company #: ______ |

- [ ] Done

### B7. Signatory authority verified
| | |
|---|---|
| **Owner** | Compliance |
| **How** | If signatory not sole director: board resolution or power of attorney authorising IO/agreement signature. |
| **Pass** | Resolution on letterhead or filed authority; dated within 12 months. |
| **Evidence** | `02-corporate/signatory-authority.pdf` |

- [ ] Done

---

## C. Financial due diligence (Finance lead)

**Procedure:** [18-advertiser-credit-and-cashflow-procedure.md](../company/18-advertiser-credit-and-cashflow-procedure.md)

### C1. Credit check authorisation signed
| | |
|---|---|
| **Owner** | Finance |
| **How** | Send authorisation template with credit application; must be signed before bureau pull. |
| **Pass** | Signed PDF on file dated before credit report. |
| **Evidence** | `04-finance/credit-auth-signed.pdf` |

- [ ] Done

### C2. Credit report obtained
| | |
|---|---|
| **Owner** | Finance |
| **How** | Order report from Creditsafe / Experian Business / D&B; review score, CCJs, filings. |
| **Pass** | Report < 90 days old; no undisclosed insolvency. |
| **Evidence** | Date: ______ Provider: ______ `04-finance/credit-report.pdf` |

- [ ] Done

### C3. Statutory or management accounts
| | |
|---|---|
| **Owner** | Finance |
| **How** | Statutory accounts < 18 months OR last 3 months management accounts if startup. |
| **Pass** | Figures legible; period ends within policy window. |
| **Evidence** | `04-finance/accounts.pdf` |

- [ ] Done

### C4. Key figures reviewed
| | |
|---|---|
| **Owner** | Finance |
| **How** | Record revenue, net assets, runway (startups), CCJs; compare to exposure formula. |
| **Pass** | Solvent enough for requested terms OR prepay-only documented. |
| **Evidence** | Finance memo in DD notes |

- [ ] Revenue: ______ Net assets: ______ Runway: ______ CCJs: ______

### C5. Exposure limit calculated
| | |
|---|---|
| **Owner** | Finance |
| **How** | `Expected monthly payout × 1.5`; cap per policy; enter in compliance UI. |
| **Pass** | Limit documented; ≤ policy max for band. |
| **Evidence** | `exposure_limit_gbp` in `/compliance` |

- [ ] Limit: £ ______

### C6. Payment terms set
| | |
|---|---|
| **Owner** | Finance |
| **How** | Choose Prepay / Credit (Net-15/30) / Hybrid; credit needs [credit application](../company/templates/credit-application-advertiser.md) + MD if required. |
| **Pass** | Terms match risk (score ≥40 → prepay only unless exception). |
| **Evidence** | Credit addendum signed OR prepay invoice sent |

- [ ] Terms: ______

### C7. Prepay received (if prepay path)
| | |
|---|---|
| **Owner** | Finance |
| **How** | Confirm cleared funds on Wise/bank; allocate to offer in ledger. |
| **Pass** | Amount ≥ IO minimum; ref matched. |
| **Evidence** | Amount: £ ______ Date: ______ Ref: ______ |

- [ ] Done / N/A (credit)

### C8. Finance sign-off
| | |
|---|---|
| **Owner** | Finance |
| **How** | Tick `finance_approved` in `/compliance`; sign this checklist. |
| **Pass** | Funding path clear before Compliance approves. |
| **Evidence** | Compliance UI + signature below |

- [ ] **Finance sign-off** — Name: ______ Date: ______

---

## D. Regulatory & product

### D1. Licence required?
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Use vertical rules: iGaming, lending, insurance, crypto = usually yes per geo. |
| **Pass** | Y/N documented with rationale. |
| **Evidence** | Compliance note |

- [ ] Y / N

### D2. Licence number & geos
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Collect licence PDF; list number and jurisdictions. |
| **Pass** | Licence covers **all** target geos on IO. |
| **Evidence** | Number: ______ Geos: ______ |

- [ ] Done / N/A

### D3. Licence verified on regulator site
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Check regulator public register; screenshot status Active. |
| **Pass** | Register shows same entity name and valid dates. |
| **Evidence** | Screenshot in `03-product/licence-verify.png` |

- [ ] Done / N/A

### D4. Landing pages compliant
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Review claims, disclaimers, age gates (gambling), APR examples (finance). |
| **Pass** | No prohibited claims; CAP/ASA-style fairness for UK traffic. |
| **Evidence** | LP review checklist note |

- [ ] Done

### D5. Privacy policy + terms on LP
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Footer links work; privacy covers tracking/pixels if used. |
| **Pass** | Both pages live; GDPR basics present for EU/UK users. |
| **Evidence** | URLs saved in DD pack |

- [ ] Done

### D6. Prohibited claims check
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Cross-check [10-traffic-creative-policy.md](../company/10-traffic-creative-policy.md) and fraud policy prohibited list. |
| **Pass** | No guaranteed returns, fake testimonials, unlicensed health cures, etc. |
| **Evidence** | Signed compliance line on creative samples |

- [ ] Done

### D7. Refund / subscription terms documented
| | |
|---|---|
| **Owner** | Compliance |
| **How** | For subscription/DTC: capture refund window, cancellation, chargeback policy text. |
| **Pass** | Fair policy documented (feeds risk matrix #7). |
| **Evidence** | LP terms excerpt or advertiser written policy |

- [ ] Done

### D8. DPA signed (if applicable)
| | |
|---|---|
| **Owner** | Compliance |
| **How** | If pixel/postback shares PII, execute DPA schedule to advertiser agreement. |
| **Pass** | DPA signed before live data processing. |
| **Evidence** | `05-legal/dpa-signed.pdf` or N/A noted |

- [ ] Done / N/A

---

## E. Sanctions & integrity

### E1. Sanctions screening — all UBOs
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Run **third-party** sanctions tool (ComplyAdvantage / World-Check / OFSI) on company + each UBO + signatory. |
| **Pass** | No confirmed match; false positives documented and cleared. |
| **Evidence** | Date: ______ Report PDF; set `sanctions_clear` in UI |

- [ ] Done

### E2. PEP clearance
| | |
|---|---|
| **Owner** | Compliance |
| **How** | PEP screen in same tool or dedicated PEP check; escalate if PEP identified. |
| **Pass** | Cleared or enhanced DD + MD approval on file. |
| **Evidence** | Screening report |

- [ ] Done

### E3. Adverse media / litigation search
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Google/news search + litigation registers; document material hits. |
| **Pass** | No undisclosed fraud/scam litigation; or escalated and accepted. |
| **Evidence** | Search log in DD notes |

- [ ] Done

### E4. Internal blocklist clear
| | |
|---|---|
| **Owner** | Compliance |
| **How** | Check entity name, domains, UBO names against internal blocklist spreadsheet. |
| **Pass** | No match. |
| **Evidence** | Blocklist check date: ______ |

- [ ] Done

---

## F. Technical & commercial

### F1. Postback spec received
| | |
|---|---|
| **Owner** | Advertiser Lead |
| **How** | Collect technical doc: URL, params, event mapping, test credentials. |
| **Pass** | Spec complete enough for Affise test. |
| **Evidence** | `06-technical/postback-spec.pdf` |

- [ ] Done

### F2. Test conversion successful
| | |
|---|---|
| **Owner** | Advertiser Lead |
| **How** | Click test link → complete event → confirm postback in Affise staging. |
| **Pass** | Postback received with correct transaction ID. |
| **Evidence** | Affise offer ID: ______ screenshot/log |

- [ ] Done

### F3. Caps defined
| | |
|---|---|
| **Owner** | Advertiser Lead + Finance |
| **How** | Set daily/monthly caps aligned with prepay/credit limit. |
| **Pass** | Caps ≤ funded exposure. |
| **Evidence** | IO + Affise cap settings |

- [ ] Daily: ______ Monthly: ______

### F4. Payout model & rate
| | |
|---|---|
| **Owner** | Advertiser Lead |
| **How** | Confirm CPA/CPL/CPS and rate on IO; matches agreement. |
| **Pass** | Signed IO draft matches commercial terms. |
| **Evidence** | IO draft v______ |

- [ ] Model: ______ Rate: ______

### F5. IO draft agreed
| | |
|---|---|
| **Owner** | Advertiser Lead |
| **How** | Send [IO template](../company/07-insertion-order-template.md); include **reversal window**; negotiate caps/geos. |
| **Pass** | Both parties agree draft; reversal window filled. |
| **Evidence** | `05-legal/io-draft.pdf` |

- [ ] Done

### F6. Advertiser Agreement signed
| | |
|---|---|
| **Owner** | Advertiser Lead |
| **How** | Send [06-advertiser-agreement.md](../company/06-advertiser-agreement.md); credit schedule if credit. |
| **Pass** | Fully executed PDF. |
| **Evidence** | `05-legal/agreement-signed.pdf` |

- [ ] Done

### F7. AM sign-off
| | |
|---|---|
| **Owner** | Advertiser Lead |
| **How** | Confirm commercial fit, caps, test pass; tick `am_signed_off` in UI. |
| **Pass** | Ready for Compliance final approval. |
| **Evidence** | UI + signature |

- [ ] **AM sign-off** — Name: ______ Date: ______

---

## G. Risk decision

| Field | Value |
|-------|-------|
| Final risk score | |
| Band | |
| Override reason (if any) | |

| | |
|---|---|
| **Owner** | Compliance |
| **How** | Re-run matrix if facts changed; confirm sign-offs: sanctions, compliance, AM, finance (advertisers). |
| **Pass** | All gates in [16-control-gates.md](../company/16-control-gates.md) green. |
| **Evidence** | `/compliance` status → approve |

- [ ] **Compliance sign-off** — Name: ______ Date: ______
- [ ] **Decision** — Approve / Reject / Enhanced DD

---

## H. Ops (post-approval)

### H1. Advertiser funded per Finance terms
| | |
|---|---|
| **Owner** | Finance |
| **How** | Prepay balance or credit headroom on ledger before cap enable. |
| **Pass** | Ledger row matches offer ID. |
| **Evidence** | Ledger screenshot |

- [ ] Done

### H2. Affise advertiser / offer live
| | |
|---|---|
| **Owner** | Advertiser Lead |
| **How** | Create advertiser + offer; caps synced; tracking links to approved publishers only. |
| **Pass** | Offer visible; test link works in production. |
| **Evidence** | Affise offer ID: ______ |

- [ ] Done

### H3. Publishers not auto-approved on this offer
| | |
|---|---|
| **Owner** | Publisher Lead |
| **How** | Offer requires manual publisher approval per network policy. |
| **Pass** | No open “all pubs” unless MD exception. |
| **Evidence** | Affise offer settings screenshot |

- [ ] Done

---

**Reject reason code:** A-01 financial / A-02 licence / A-03 product / A-04 sanctions / A-05 tech / A-06 entity / A-07 other: ______
