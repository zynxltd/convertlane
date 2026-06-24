@php
    $legalName = config('brand.legal_name');
    $brand = config('brand.name');
    $url = config('brand.url');
@endphp

<x-layouts.app
    title="Privacy Policy"
    description="How {{ $brand }} collects, uses, stores, and protects personal data under UK GDPR and applicable international privacy law."
>
    <x-legal-document
        title="Privacy Policy"
        summary="How we handle personal data for website visitors, applicants, and approved network partners."
    >
        <p>
            This Privacy Policy explains how <strong>{{ $legalName }}</strong> (trading as “<strong>{{ $brand }}</strong>”, “we”, “us”, “our”)
            processes personal data when you visit <a href="{{ $url }}">{{ $url }}</a>, apply to join our performance
            affiliate network, or operate as an approved advertiser or publisher.
        </p>
        <p>
            We are committed to processing personal data lawfully, fairly, and transparently in accordance with the UK
            General Data Protection Regulation (UK GDPR), the Data Protection Act 2018, and applicable international
            privacy laws.
        </p>

        <h2>1. Who is responsible for your data?</h2>
        <x-legal.company-details />
        <p>
            <strong>Contact:</strong>
            <a href="mailto:{{ config('legal.privacy_email') }}">{{ config('legal.privacy_email') }}</a>
            for privacy and data subject requests.
        </p>
        <p>
            Where we process end-user conversion data on behalf of an advertiser, the advertiser is typically the
            <strong>data controller</strong> for that data and we act as a <strong>data processor</strong> under a
            separate data processing agreement where required.
        </p>

        <h2>2. Personal data we collect</h2>
        <p>Depending on how you interact with us, we may collect the following categories of personal data:</p>

        <h3>2.1 Website visitors and enquiries</h3>
        <ul>
            <li>Contact details (name, email, company, message content) when you use our contact or application forms.</li>
            <li>Technical data: IP address, browser type, device identifiers, referring URL, and server logs.</li>
            <li>Cookie and analytics data as described in Section 8.</li>
        </ul>

        <h3>2.2 Partner applications (advertisers and publishers)</h3>
        <ul>
            <li>Business identity: legal entity name, registered address, company number, VAT number, website URLs.</li>
            <li>Contact persons: names, job titles, business email addresses, and telephone numbers.</li>
            <li>Due diligence: ownership and control information, traffic or product descriptions, bank account details for payouts or billing, and documents you provide for KYC/KYB review.</li>
            <li>Sanctions and PEP screening results generated from information you supply.</li>
        </ul>

        <h3>2.3 Approved network partners</h3>
        <ul>
            <li>Account management records, correspondence, and operational notes.</li>
            <li>Performance data: clicks, impressions, conversions, sub-IDs, referrer URLs, IP addresses, user agents, and timestamps via our tracking and reporting systems.</li>
            <li>Financial records: invoices, remittance advice, payment confirmations, and tax documentation.</li>
            <li>Fraud and compliance investigation records where relevant.</li>
        </ul>

        <h3>2.4 Data we do not intentionally collect</h3>
        <p>
            Our services are directed at businesses. We do not knowingly collect personal data from children under 18.
            If you believe we have received such data, contact us and we will delete it promptly.
        </p>

        <h2>3. How we use personal data</h2>
        <table>
            <thead>
                <tr>
                    <th>Purpose</th>
                    <th>Typical lawful basis</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Reviewing and onboarding partner applications</td>
                    <td>Contract; legitimate interests (fraud prevention, network integrity)</td>
                </tr>
                <tr>
                    <td>Operating offers, tracking, reporting, and cap management</td>
                    <td>Contract; legitimate interests</td>
                </tr>
                <tr>
                    <td>Processing publisher payouts and advertiser billing</td>
                    <td>Contract; legal obligation (tax and accounting)</td>
                </tr>
                <tr>
                    <td>Compliance, sanctions screening, and fraud investigation</td>
                    <td>Legal obligation; legitimate interests; contract</td>
                </tr>
                <tr>
                    <td>Responding to support requests and disputes</td>
                    <td>Contract; legitimate interests</td>
                </tr>
                <tr>
                    <td>Improving our website and security</td>
                    <td>Legitimate interests; consent (non-essential cookies where required)</td>
                </tr>
                <tr>
                    <td>Marketing to existing business contacts about {{ $brand }} services</td>
                    <td>Legitimate interests; consent where required by law</td>
                </tr>
            </tbody>
        </table>

        <h2>4. Who we share data with</h2>
        <p>We share personal data only where necessary and under appropriate safeguards:</p>
        <ul>
            <li><strong>Advertisers and publishers:</strong> as required to operate programmes (for example, conversion validation, quality review, or payment reconciliation).</li>
            <li><strong>Tracking and infrastructure providers:</strong> hosting, CDN, email, and affiliate tracking platforms that process data on our instructions.</li>
            <li><strong>Payment processors:</strong> to execute publisher payouts and receive advertiser funds.</li>
            <li><strong>Professional advisers:</strong> lawyers, accountants, and auditors bound by confidentiality.</li>
            <li><strong>Regulators and law enforcement:</strong> where required by law or to protect our legal rights.</li>
        </ul>
        <p>We do <strong>not</strong> sell personal data.</p>

        <h2>5. International transfers</h2>
        <p>
            We primarily use UK and EEA-based service providers. Where personal data is transferred outside the UK or EEA,
            we implement appropriate safeguards such as the UK International Data Transfer Agreement, UK Addendum to EU
            Standard Contractual Clauses, or an adequacy decision, and we assess transfer risk before onboarding processors.
        </p>

        <h2>6. Retention</h2>
        <p>We retain personal data only for as long as necessary for the purposes described above, including:</p>
        <table>
            <thead>
                <tr>
                    <th>Data category</th>
                    <th>Typical retention</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Approved partner records, agreements, and financial data</td>
                    <td>7 years after the relationship ends</td>
                </tr>
                <tr>
                    <td>Performance and tracking statistics</td>
                    <td>7 years (archived annually)</td>
                </tr>
                <tr>
                    <td>Rejected applications (including ID documents)</td>
                    <td>2 years, then deleted or anonymised</td>
                </tr>
                <tr>
                    <td>General business email</td>
                    <td>3 years unless a longer period is required for disputes or legal hold</td>
                </tr>
                <tr>
                    <td>Website server logs</td>
                    <td>90 days unless required for security investigation</td>
                </tr>
            </tbody>
        </table>

        <h2>7. Security</h2>
        <p>
            We apply administrative, technical, and organisational measures appropriate to the risk, including access
            controls, encryption in transit, least-privilege access for staff, and secure storage of due diligence
            documents. No method of transmission over the internet is completely secure; we cannot guarantee absolute security.
        </p>

        <h2>8. Cookies and similar technologies</h2>
        <p>
            Our website may use essential cookies required for security and basic functionality. Where we use analytics
            or marketing cookies that require consent under UK law, we will request your consent via a cookie banner or
            equivalent mechanism.
        </p>
        <p>
            Partner tracking links may set or read cookies and similar identifiers on end users’ devices as part of
            performance measurement. Publishers and advertisers are responsible for their own consent and disclosure
            obligations toward end users in their operating jurisdictions.
        </p>

        <h2>9. Your rights</h2>
        <p>Under UK GDPR, you may have the following rights (subject to conditions and exemptions):</p>
        <ul>
            <li>Right of access to your personal data</li>
            <li>Right to rectification of inaccurate data</li>
            <li>Right to erasure (“right to be forgotten”)</li>
            <li>Right to restrict processing</li>
            <li>Right to data portability</li>
            <li>Right to object to processing based on legitimate interests</li>
            <li>Right to withdraw consent where processing is consent-based</li>
        </ul>
        <p>
            To exercise your rights, email
            <a href="mailto:{{ config('legal.privacy_email') }}">{{ config('legal.privacy_email') }}</a>.
            We respond within one month unless an extension is permitted. We may need to verify your identity before
            disclosing information.
        </p>
        <p>
            You may lodge a complaint with the UK Information Commissioner’s Office (ICO) at
            <a href="https://ico.org.uk" rel="noopener noreferrer">ico.org.uk</a>. We encourage you to contact us first
            so we can try to resolve your concern.
        </p>

        <h2>10. Automated decision-making</h2>
        <p>
            We do not make solely automated decisions about partner approval that produce legal or similarly significant
            effects without human review. Compliance and fraud decisions involve trained staff or contractors.
        </p>

        <h2>11. Changes to this policy</h2>
        <p>
            We may update this Privacy Policy from time to time. The “Last updated” date at the top of this page will
            change when we do. Material changes affecting existing partners will be communicated by email or through the
            partner reporting area where appropriate.
        </p>

        <h2>12. Related documents</h2>
        <ul>
            <li><a href="{{ route('terms') }}">Terms of Service</a></li>
            <li><a href="{{ route('affiliate-agreement') }}">Affiliate (Publisher) Agreement</a></li>
            <li><a href="{{ route('advertiser-agreement') }}">Advertiser Agreement</a></li>
        </ul>
    </x-legal-document>
</x-layouts.app>
