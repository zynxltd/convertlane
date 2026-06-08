<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordResetRequest;
use App\Mail\PanelPasswordResetMail;
use App\Services\Offer18AuthService;
use App\Support\BrandContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    public function __construct(
        protected Offer18AuthService $offer18,
    ) {}

    public function createPartner(): View
    {
        return $this->create('partner');
    }

    public function createAdvertiser(): View
    {
        return $this->create('advertiser');
    }

    public function storePartner(StorePasswordResetRequest $request): RedirectResponse
    {
        return $this->store($request, 'partner');
    }

    public function storeAdvertiser(StorePasswordResetRequest $request): RedirectResponse
    {
        return $this->store($request, 'advertiser');
    }

    protected function create(string $portal): View
    {
        return view('pages.auth.password-reset', compact('portal'));
    }

    protected function store(StorePasswordResetRequest $request, string $portal): RedirectResponse
    {
        $email = (string) $request->validated('email');

        if (! $this->offer18->isConfigured()) {
            return redirect()
                ->route($portal === 'advertiser' ? 'advertiser.password.request' : 'partner.password.request')
                ->with('error', 'Password reset is not available online yet. Email '.config('brand.support_email').' for help.');
        }

        $result = $portal === 'advertiser'
            ? $this->offer18->resetAdvertiserPassword($email)
            : $this->offer18->resetPartnerPassword($email);

        $sentRoute = $portal === 'advertiser' ? 'advertiser.password.sent' : 'partner.password.sent';

        if ($result['success'] && filled($result['password'])) {
            $portalLabel = $portal === 'advertiser' ? 'Advertiser' : 'Partner';
            $loginUrl = $portal === 'advertiser'
                ? BrandContact::route('advertiser.login')
                : BrandContact::route('partner.login');

            try {
                Mail::to($email)->send(new PanelPasswordResetMail(
                    $portalLabel,
                    $result['password'],
                    $loginUrl,
                ));
            } catch (\Throwable $e) {
                Log::error('Failed to email panel password reset', [
                    'portal' => $portal,
                    'email' => $email,
                    'message' => $e->getMessage(),
                ]);

                return redirect()
                    ->route($portal === 'advertiser' ? 'advertiser.password.request' : 'partner.password.request')
                    ->withInput()
                    ->with('error', 'We reset your password but could not send the email. Contact '.config('brand.support_email').'.');
            }
        }

        return redirect()
            ->route($sentRoute)
            ->with('email', $email);
    }

    public function sentPartner(): View
    {
        return $this->sent('partner');
    }

    public function sentAdvertiser(): View
    {
        return $this->sent('advertiser');
    }

    protected function sent(string $portal): View
    {
        return view('pages.auth.password-reset-sent', [
            'portal' => $portal,
            'email' => session('email'),
        ]);
    }
}
