@php
    $legalName = config('brand.legal_name');
    $brand = config('brand.name');
@endphp

<x-layouts.app
    title="Advertiser Agreement"
    description="Standard advertiser terms for brands and agencies launching offers on the {{ $brand }} performance network."
>
    <x-legal-document
        title="Advertiser Agreement"
        summary="Standard terms that apply when your advertiser application is approved and offers run on our network."
    >
        <p>
            This Advertiser Agreement (“<strong>Agreement</strong>”) is between
            <strong>{{ $legalName }}</strong> (“{{ $brand }}”, “Network”, “we”, “us”) and the legal entity applying or
            approved as an advertiser (“Advertiser”, “you”).
        </p>
        <p>
            By applying, executing an Insertion Order (“IO”), or funding a campaign, you agree to this Agreement, each
            applicable IO, our <a href="{{ route('terms') }}">Terms of Service</a>, and our billing and compliance
            policies provided at onboarding. If an IO conflicts with this Agreement for a specific offer, the
            <strong>IO prevails for that offer</strong>.
        </p>

        <h2>1. Services</h2>
        <ol>
            <li>{{ $brand }} will distribute your <strong>approved offers</strong> to vetted publishers subject to this Agreement and each IO.</li>
            <li>Services include publisher recruitment within our standards, tracking setup, cap and geo management, reporting, fraud screening, and payment collection per our billing policy.</li>
            <li>We do <strong>not</strong> guarantee traffic volume, specific publishers, conversion rates, or market share.</li>
            <li>We may refuse or remove publishers, traffic sources, or creatives that create legal, brand, or fraud risk.</li>
        </ol>

        <h2>2. Advertiser obligations</h2>
        <p>You will:</p>
        <ul>
            <li>Provide accurate offer terms, landing pages, postback URLs, validation rules, and product information;</li>
            <li>Maintain all licences, registrations, and approvals required for your products (including finance, gambling, health, and telecom where applicable);</li>
            <li><strong>Fund campaigns</strong> via prepay or an approved credit line before caps are opened or increased;</li>
            <li>Validate conversions in good faith within agreed service levels;</li>
            <li>Approve or reject disputed conversions with documented reasons;</li>
            <li>Not request or knowingly accept traffic that violates law or our policies;</li>
            <li>Keep publisher identities confidential where we designate them private;</li>
            <li>Notify us within <strong>5 business days</strong> of material changes to your product, licensing, or corporate structure.</li>
        </ul>

        <h2>3. Compliance and due diligence</h2>
        <ol>
            <li>You warrant that application and due diligence information is accurate.</li>
            <li>You indemnify {{ $legalName }} against claims arising from your product, advertising claims, lack of licence, or breach of consumer law — except our gross negligence or wilful misconduct.</li>
            <li>We may pause or remove offers that create regulatory, payment, or reputational risk without liability to you for lost volume where pause is reasonable.</li>
        </ol>

        <h2>4. Fees and billing</h2>
        <ol>
            <li>You pay {{ $brand }} per IO, typically comprising <strong>publisher payout plus network fee</strong> (margin or override stated in the IO or rate card).</li>
            <li>Setup fees, monthly minimums, or technology fees may apply for enterprise accounts as stated in writing.</li>
        </ol>

        <p><strong>Default billing models</strong></p>
        <table>
            <thead>
                <tr>
                    <th>Model</th>
                    <th>When used</th>
                    <th>Summary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Prepay (default)</td>
                    <td>All new advertisers</td>
                    <td>Funds received before offer goes live and before material cap increases</td>
                </tr>
                <tr>
                    <td>Credit line</td>
                    <td>Approved established accounts only</td>
                    <td>Signed credit addendum; Net-15 or Net-30 invoice per approval</td>
                </tr>
            </tbody>
        </table>

        <p><strong>Prepay rules (summary)</strong></p>
        <ul>
            <li>Minimum top-up amounts are stated in your IO or onboarding pack (typically £5,000 / $5,000 / €5,000 equivalent unless agreed otherwise).</li>
            <li>We may pause caps at <strong>90% consumption</strong> and hard-pause at <strong>100%</strong> until replenished.</li>
            <li>Unused prepay balances are refunded on termination minus earned fees and contractual adjustments.</li>
            <li>Late payment on credit accounts may result in immediate cap pause and contractual interest or late fees where permitted by law.</li>
        </ul>

        <h2>5. Tracking and validation</h2>
        <ol>
            <li>Our tracking and reporting platform is the system of record unless the IO specifies otherwise.</li>
            <li>You will implement server-to-server postbacks or provide validation files within <strong>3 business days</strong> of month-end unless the IO differs.</li>
            <li>Disputes must be raised within <strong>14 days</strong> with specific conversion or click IDs. We will investigate with publishers in good faith.</li>
            <li>You remain the <strong>data controller</strong> for end-user personal data collected on your properties. We act as processor where required under a separate data processing agreement.</li>
        </ol>

        <h2>6. Fraud and quality</h2>
        <ol>
            <li>We operate anti-fraud measures but do not warrant zero fraud.</li>
            <li>Either party may reject invalid conversions per the IO definition.</li>
            <li>On material fraud, we may pause the offer and require your cooperation with investigation. You will not bill end users based on rejected fraudulent events.</li>
        </ol>

        <h2>7. Confidentiality</h2>
        <p>
            Non-public commercial terms, unpublished rate cards, and private publisher lists are confidential. Each party
            will use reasonable care and disclose only to personnel and advisers with a need to know.
        </p>

        <h2>8. Term and termination</h2>
        <ol>
            <li>This Agreement continues until terminated.</li>
            <li>Either party may terminate for convenience on <strong>14 days’ written notice</strong>; active IOs wind down per their notice provisions.</li>
            <li>Either party may terminate <strong>immediately</strong> for material breach, fraud, insolvency, or loss of required licence.</li>
            <li>On termination: caps are zeroed; final reconciliation and settlement of valid conversions within <strong>20 business days</strong>, subject to holds for disputes or investigations.</li>
        </ol>

        <h2>9. Limitation of liability</h2>
        <ol>
            <li>Neither party is liable for indirect, consequential, or punitive loss.</li>
            <li>Our total liability is capped at <strong>fees paid by you to {{ $brand }} in the three months</strong> before the claim, except for fraud, death, or personal injury caused by negligence.</li>
        </ol>

        <h2>10. General</h2>
        <ul>
            <li><strong>Governing law:</strong> {{ config('legal.jurisdiction') }}</li>
            <li><strong>Jurisdiction:</strong> Courts of {{ config('legal.jurisdiction') }}</li>
            <li><strong>Entire agreement:</strong> This Agreement, IOs, credit addenda (if any), and referenced policies</li>
            <li><strong>Amendments:</strong> Material published changes with notice to active advertisers where required</li>
            <li><strong>Notices:</strong> Email to registered business contacts</li>
            <li><strong>Force majeure:</strong> Neither party liable for failure caused by events beyond reasonable control (excluding payment obligations already accrued)</li>
        </ul>

        <h2>11. Execution</h2>
        <p>
            For approved advertisers, this Agreement is deemed accepted on the approval date in our onboarding
            correspondence. Counter-signed copies may be issued on request. Enterprise master service agreements
            override conflicting standard terms where executed in writing.
        </p>
    </x-legal-document>
</x-layouts.app>
