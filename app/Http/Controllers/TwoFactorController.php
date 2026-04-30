<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use App\Models\User;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function enable2fa()
    {
        $user = auth()->user();

        try {
            $google2fa = app('pragmarx.google2fa');

            // Generate a new secret if the user does not have one
            if (!$user->two_factor_secret) {
                $user->two_factor_secret = $google2fa->generateSecretKey();
                $user->save();
            }

            // Generate QR code for Google Authenticator
            $qrCodeUrl = $google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $user->two_factor_secret
            );

            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCodeImage = $writer->writeString($qrCodeUrl);

            return view('auth.2fa_enable', [
                'qrCodeImage' => $qrCodeImage,
                'secret' => $user->two_factor_secret
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to enable Two-Factor Authentication. Please try again.');
        }

    }

    public function verify2fa(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric'
        ]);

        $user = auth()->user();
        $google2fa = app('pragmarx.google2fa');

        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);

        if ($valid) {
            $user->two_factor_enabled = 1;
            $user->save();

            return redirect()->route('settings')->with('success', 'Two-Factor Authentication enabled successfully!');
        }

        return back()->with('error', 'Invalid verification code. Please try again.');
    }

    public function disable2fa()
    {
        try {
            $user = auth()->user();

            $user->two_factor_enabled = 0;
            $user->two_factor_secret = null;
            $user->save();

            return redirect()->route('settings')->with('success', 'Two-Factor Authentication disabled successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to disable Two-Factor Authentication. Please try again.');
        }

    }

    public function challenge()
    {
        try {
            if (!session()->has('2fa:user:id')) {
                return redirect()->route('login');
            }

            return view('auth.2fa_challenge');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to verify Two-Factor Authentication. Please try again.');
        }
    }

    public function verifyChallenge(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric'
        ]);

        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login');
        }

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);

        if ($valid) {
            session()->forget('2fa:user:id');
            Auth::login($user);

            $request->session()->regenerate();
            session()->put('isActive', 1);

            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Invalid authentication code. Please try again.');
    }
}
