@php
    $legalName = config('brand.legal_name');
    $brand = config('brand.name');
@endphp

<x-layouts.app
    title="Affiliate Agreement"
    description="Standard publisher and affiliate terms for approved partners on the {{ $brand }} performance network."
>
    <x-legal-document
        title="Publisher / Affiliate Agreement"
        summary="Standard terms that apply when your publisher application is approved and you promote offers on our network."
    >
        <p>
            This Publisher / Affiliate Agreement (“<strong>Agreement</strong>”) is between
            <strong>{{ $legalName }}</strong> (“{{ $brand }}”, “Network”, “we”, “us”) and the legal entity applying or
            approved as a publisher (“Publisher”, “Affiliate”, “you”).
        </p>
        <p>
            By submitting an application, executing an Insertion Order (“IO”), or using tracking links after approval,
            you agree to this Agreement together with each applicable IO, our
            <a href="{{ route('terms') }}">Terms of Service</a>, and the Traffic &amp; Creative Policy provided at
            onboarding. If an IO conflicts with this Agreement for a specific offer, the <strong>IO prevails for that offer</strong>.
        </p>

        <h2>1. Appointment</h2>
        <ol>
            <li>{{ $brand }} operates a performance affiliate network connecting advertisers with vetted publishers.</li>
            <li>Upon written or electronic approval, we appoint you on a <strong>non-exclusive, revocable</strong> basis to promote offers listed in the partner reporting area or separate IO.</li>
            <li>You may not use tracking links, pixels, or APIs until we set your account status to <strong>approved</strong> in writing.</li>
            <li>We may add, pause, or remove offers at any time. You must stop promotion immediately when an offer is paused or terminated.</li>
        </ol>

        <h2>2. Publisher obligations</h2>
        <p>You will:</p>
        <ul>
            <li>Promote only using <strong>approved links, creatives, landing pages, and pre-landers</strong> for each offer;</li>
            <li>Comply with all applicable laws, including advertising standards, consumer protection, and privacy rules in every territory where you send traffic;</li>
            <li>Provide clear <strong>affiliate disclosures</strong> (for example, “Ad”, “Sponsored”, or “Affiliate link”) where required by the ASA/CAP Code, FTC guides, or local law;</li>
            <li>Use <strong>opt-in email lists only</strong> where email traffic is permitted, and provide proof of consent on request;</li>
            <li>Not use prohibited traffic types (incentivised traffic, brand bidding, bots, malware, cookie stuffing, etc.) unless the IO expressly permits them;</li>
            <li>Not <strong>rebroker, resell, or sublicense</strong> your tracking links or sub-IDs without our written consent;</li>
            <li>Maintain accurate company, tax, and payment information;</li>
            <li>Notify us within <strong>24 hours</strong> of suspected fraud, data breaches, or material changes to your traffic sources;</li>
            <li>Cooperate with compliance audits and provide reasonable evidence of traffic quality when requested.</li>
        </ul>
        <p>
            Unless listed and permitted in your IO, traffic sources are <strong>not allowed</strong>. Default position on
            brand bidding: <strong>prohibited</strong> unless the IO states otherwise.
        </p>

        <h2>3. Compliance and KYC</h2>
        <ol>
            <li>You warrant that all information in your application and due diligence pack is accurate and complete.</li>
            <li>You will notify us within <strong>5 business days</strong> of changes to directors, ultimate beneficial owners (25% or more), registered address, or bank details.</li>
            <li>We may conduct sanctions, PEP, and adverse media screening at onboarding and periodically thereafter.</li>
            <li>We may suspend or terminate immediately for false information, failed screening, or regulatory risk.</li>
        </ol>

        <h2>4. Compensation and payment</h2>
        <ol>
            <li>Commission is set per IO (CPA, CPL, CPS, hybrid, or other model stated in writing).</li>
            <li>We pay only <strong>approved conversions</strong> that meet the IO definition and pass advertiser validation and our fraud review.</li>
            <li>We may deduct invalid conversions, chargebacks, duplicate events, prior overpayments, and agreed adjustments.</li>
        </ol>

        <p><strong>Default payment terms</strong> (unless the IO states otherwise):</p>
        <table>
            <thead>
                <tr>
                    <th>Term</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Payment cycle</td>
                    <td>Net-30</td>
                </tr>
                <tr>
                    <td>Payment date</td>
                    <td>15th calendar day of each month for the prior calendar month</td>
                </tr>
                <tr>
                    <td>Minimum threshold</td>
                    <td>£100 or $100 equivalent</td>
                </tr>
                <tr>
                    <td>Method</td>
                    <td>Bank transfer to your nominated business account, or another method we agree in writing</td>
                </tr>
                <tr>
                    <td>Currencies</td>
                    <td>GBP, USD, or EUR as agreed in the IO</td>
                </tr>
            </tbody>
        </table>

        <p>
            You are responsible for your own taxes. We may withhold payment until required tax forms are received.
            We are not liable for advertiser insolvency beyond our obligation to pay you from funds properly allocated
            to your approved conversions under our published policies.
        </p>

        <h3>4.1 What we do not pay</h3>
        <ul>
            <li>Conversions generated before your approval date or outside permitted geos</li>
            <li>Traffic from prohibited sources or in breach of the IO</li>
            <li>Conversions under active fraud investigation (held until cleared)</li>
            <li>Events exceeding caps unless the IO is formally amended</li>
        </ul>

        <h2>5. Reporting and performance data</h2>
        <p>
            Our tracking and reporting platform is the primary system of record unless an IO specifies otherwise. You
            must review statistics regularly and raise discrepancies within <strong>14 days</strong> of month-end with
            specific click or conversion IDs. Late disputes may be declined where records are no longer available.
        </p>

        <h2>6. Confidentiality</h2>
        <p>
            Non-public offer rates, caps, advertiser identities (where marked private), unpublished IO terms, and
            network operational information are <strong>confidential</strong>. You may not disclose them except to your
            employees and contractors with a need to know who are bound by equivalent obligations.
        </p>

        <h2>7. Intellectual property</h2>
        <p>
            Advertisers grant a limited licence to use approved creatives solely to promote offers during the term.
            You grant us a licence to use your company name and logo in case studies or marketing materials only with
            your prior written consent.
        </p>

        <h2>8. Term and termination</h2>
        <ol>
            <li>This Agreement begins on approval and continues until terminated.</li>
            <li>Either party may terminate for convenience on <strong>7 days’ written notice</strong>.</li>
            <li>We may terminate <strong>immediately</strong> for material breach, fraud, policy violation, regulatory order, or insolvency.</li>
            <li>On termination: tracking links are deactivated; final payment is processed per our payout policy for approved conversions recorded before the effective termination date, subject to holds for investigation.</li>
        </ol>

        <h2>9. Indemnity</h2>
        <p>
            You will indemnify and hold harmless {{ $legalName }}, its directors, and employees against claims, losses,
            and reasonable costs arising from your traffic, creatives, data practices, breach of this Agreement, or
            violation of law — except to the extent caused by our gross negligence or wilful misconduct.
        </p>

        <h2>10. Limitation of liability</h2>
        <ol>
            <li>Neither party is liable for indirect, consequential, or punitive loss, or loss of profit or goodwill.</li>
            <li>Our total liability under this Agreement is capped at the <strong>commissions paid or payable to you in the three months</strong> before the event giving rise to the claim, except for fraud, death, or personal injury caused by negligence.</li>
        </ol>

        <h2>11. General</h2>
        <table>
            <thead>
                <tr>
                    <th>Topic</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Governing law</td>
                    <td>{{ config('legal.jurisdiction') }}</td>
                </tr>
                <tr>
                    <td>Jurisdiction</td>
                    <td>Courts of {{ config('legal.jurisdiction') }}</td>
                </tr>
                <tr>
                    <td>Assignment</td>
                    <td>You may not assign without our consent; we may assign to a group company on notice</td>
                </tr>
                <tr>
                    <td>Entire agreement</td>
                    <td>This Agreement, IOs, and policies referenced at onboarding</td>
                </tr>
                <tr>
                    <td>Amendments</td>
                    <td>Material changes published on this page with notice to active partners where required</td>
                </tr>
                <tr>
                    <td>Notices</td>
                    <td>Email to registered business contacts</td>
                </tr>
            </tbody>
        </table>

        <h2>12. Execution</h2>
        <p>
            For approved partners, this Agreement is deemed accepted on the approval date shown in our onboarding
            correspondence. Counter-signed PDF or e-sign copies may be issued for your records. Custom negotiated terms
            in a signed master agreement override conflicting standard terms.
        </p>
    </x-legal-document>
</x-layouts.app>
