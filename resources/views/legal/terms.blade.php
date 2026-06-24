@php
    $legalName = config('brand.legal_name');
    $brand = config('brand.name');
    $url = config('brand.url');
@endphp

<x-layouts.app
    title="Terms of Service"
    description="Terms governing use of the {{ $brand }} website and performance affiliate network services."
>
    <x-legal-document
        title="Terms of Service"
        summary="Terms that apply when you use our website or apply to become a network partner."
    >
        <p>
            These Terms of Service (“<strong>Terms</strong>”) govern access to and use of the website at
            <a href="{{ $url }}">{{ $url }}</a> and related services operated by
            <strong>{{ $legalName }}</strong> (trading as “<strong>{{ $brand }}</strong>”, “we”, “us”). By using the website or submitting an
            application, you agree to these Terms.
        </p>
        <p>
            If you are approved as an advertiser or publisher, your relationship is also governed by the applicable
            <a href="{{ route('advertiser-agreement') }}">Advertiser Agreement</a> or
            <a href="{{ route('affiliate-agreement') }}">Affiliate Agreement</a> and each signed Insertion Order (“IO”).
            If there is a conflict, the executed partner agreement and IO prevail for that programme.
        </p>

        <h2>1. Definitions</h2>
        <ul>
            <li><strong>Advertiser:</strong> a brand or agency promoting offers through the network.</li>
            <li><strong>Publisher / Affiliate:</strong> a partner promoting approved offers for commission.</li>
            <li><strong>IO:</strong> insertion order or offer schedule setting commercial and technical terms.</li>
            <li><strong>Partner:</strong> any approved advertiser or publisher.</li>
            <li><strong>Platform:</strong> our tracking, reporting, and partner management systems.</li>
        </ul>

        <h2>2. Eligibility</h2>
        <p>
            You must be at least 18 years old and have authority to bind the business entity you represent. You must
            provide accurate information in applications and keep it current. We may refuse or revoke access at our
            discretion, including where onboarding is incomplete or risk thresholds are not met.
        </p>

        <h2>3. Website use</h2>
        <p>You agree not to:</p>
        <ul>
            <li>Use the website in any unlawful manner or for fraudulent purposes.</li>
            <li>Attempt to gain unauthorised access to our systems, other users’ accounts, or partner-only areas.</li>
            <li>Introduce malware, scrape content at scale without permission, or interfere with site operation.</li>
            <li>Misrepresent your identity, traffic sources, or business credentials.</li>
        </ul>
        <p>
            Content on the website is for general information. Offer availability, rates, and caps shown publicly may
            change and are not binding until confirmed in a signed IO for approved partners.
        </p>

        <h2>4. Applications and vetting</h2>
        <p>
            Submitting an application does not guarantee approval. We conduct due diligence including business
            verification, traffic or product review, and sanctions screening. Incomplete applications may be closed
            after seven days without response. We do not provide reasons for every rejection where prohibited by law or
            policy.
        </p>
        <p>
            Tracking links and partner panel access are issued only after written approval and, where applicable,
            execution of the relevant partner agreement and IO.
        </p>

        <h2>5. Network services (summary)</h2>
        <p>{{ $brand }} provides performance marketing intermediary services, including:</p>
        <ul>
            <li>Recruiting and vetting publishers for advertiser offers</li>
            <li>Offer configuration, caps, geo rules, and creative approval workflows</li>
            <li>Click and conversion tracking, reporting, and fraud screening</li>
            <li>Payment collection from advertisers and publisher payouts per agreed terms</li>
        </ul>
        <p>
            We do not guarantee traffic volume, conversion rates, rankings, or specific financial results. Advertisers
            remain responsible for their products, licences, and landing page compliance. Publishers remain
            responsible for their traffic sources and disclosures.
        </p>

        <h2>6. Prohibited conduct (all users and partners)</h2>
        <p>Without limitation, the following are prohibited on and through the network:</p>
        <ul>
            <li>Fraudulent, incentivised-without-permission, or bot-generated traffic</li>
            <li>Brand bidding on trademark terms where not expressly permitted in the IO</li>
            <li>Spam, malware, forced redirects, cookie stuffing, or misleading creatives</li>
            <li>Circumvention of caps, geo restrictions, or tracking</li>
            <li>Rebrokering or resale of tracking links without written consent</li>
            <li>Promotion of offers in geographies or verticals not covered by the IO or licence</li>
        </ul>
        <p>Detailed traffic and creative rules are provided to approved publishers in our Traffic &amp; Creative Policy.</p>

        <h2>7. Intellectual property</h2>
        <p>
            The {{ $brand }} name, logo, website content, and software are owned by or licensed to us. You may not use
            our branding except as expressly permitted. Advertiser creatives are licensed to publishers only for the
            term and scope of the relevant IO.
        </p>

        <h2>8. Confidentiality</h2>
        <p>
            Non-public offer terms, unpublished rates, private advertiser or publisher identities, and operational
            information disclosed to you must be kept confidential except where disclosure is required by law or
            already public through no fault of yours.
        </p>

        <h2>9. Disclaimers</h2>
        <p>
            The website and services are provided on an “as is” and “as available” basis. To the fullest extent
            permitted by law, we disclaim warranties of merchantability, fitness for a particular purpose, and
            non-infringement. We do not warrant uninterrupted or error-free operation of tracking or reporting systems.
        </p>

        <h2>10. Limitation of liability</h2>
        <p>
            Nothing in these Terms excludes liability for death or personal injury caused by negligence, fraud, or
            any liability that cannot be excluded under applicable law.
        </p>
        <p>
            Subject to the above, {{ $legalName }} shall not be liable for indirect, incidental, special, consequential,
            or punitive damages, or for loss of profits, revenue, data, or goodwill, arising from use of the website or
            network services.
        </p>
        <p>
            Our total aggregate liability arising from website use (excluding approved partner agreements) is limited to
            the greater of £100 or the fees you paid to us in the three months preceding the event giving rise to the claim.
        </p>

        <h2>11. Suspension and termination</h2>
        <p>
            We may suspend or terminate website access or partner status immediately for breach of these Terms, partner
            agreements, applicable law, or where necessary to protect the network, advertisers, or publishers. Provisions
            that by nature should survive (confidentiality, liability limits, governing law) survive termination.
        </p>

        <h2>12. Third-party links and services</h2>
        <p>
            The website may link to third-party sites or tools. We are not responsible for their content or privacy
            practices. Partner panel URLs may be hosted by third parties subject to separate terms.
        </p>

        <h2>13. Governing law and disputes</h2>
        <p>
            These Terms are governed by the laws of {{ config('legal.jurisdiction') }}. The courts of
            {{ config('legal.jurisdiction') }} have exclusive jurisdiction, except where mandatory consumer protection
            laws in your country give you non-waivable rights.
        </p>

        <h2>14. Changes</h2>
        <p>
            We may update these Terms by posting a revised version on this page. Continued use after the effective date
            constitutes acceptance where permitted by law. Material changes to partner relationships will be handled
            through partner agreements and direct notice.
        </p>

        <h2>15. Contact</h2>
        <x-legal.company-details />
        <p>
            Questions about these Terms:
            <a href="mailto:{{ config('legal.legal_email') }}">{{ config('legal.legal_email') }}</a>.
        </p>
        <p>See also: <a href="{{ route('privacy') }}">Privacy Policy</a>.</p>
    </x-legal-document>
</x-layouts.app>
