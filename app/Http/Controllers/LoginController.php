<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
use App\Services\Offer18AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
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

    public function storePartner(StoreLoginRequest $request): RedirectResponse
    {
        return $this->store($request, 'partner');
    }

    public function storeAdvertiser(StoreLoginRequest $request): RedirectResponse
    {
        return $this->store($request, 'advertiser');
    }

    protected function create(string $portal): View
    {
        return view('pages.auth.login', compact('portal'));
    }

    protected function store(StoreLoginRequest $request, string $portal): RedirectResponse
    {
        $email = (string) $request->validated('email');
        $password = (string) $request->validated('password');

        $result = $portal === 'advertiser'
            ? $this->offer18->loginAdvertiser($email, $password)
            : $this->offer18->loginPartner($email, $password);

        if (! $result['success'] || blank($result['redirect_url'])) {
            throw ValidationException::withMessages([
                'email' => $result['message'] ?? 'These credentials do not match our records.',
            ]);
        }

        return redirect()->away($result['redirect_url']);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('partner.login');
    }
}
