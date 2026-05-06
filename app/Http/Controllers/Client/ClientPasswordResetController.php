<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\ClientResetPasswordMail;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ClientPasswordResetController extends Controller
{
    // ── صفحة طلب الـ reset ──
    public function showForgotForm()
    {
        return view('clients.auth.forgot-password');
    }

    // ── إرسال الـ email ──
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:clients,email',
        ], [
            'email.exists' => 'Aucun compte client trouvé avec cet email.',
        ]);

        // حذف التوكن القديم
        DB::table('client_password_resets')
            ->where('email', $request->email)
            ->delete();

        // توليد توكن جديد
        $token = Str::random(64);

        DB::table('client_password_resets')->insert([
            'email'      => $request->email,
            'token'      => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetUrl = route('client.password.reset.form', [
            'token' => $token,
            'email' => $request->email,
        ]);

        Mail::to($request->email)->send(
            new ClientResetPasswordMail($resetUrl, $request->email)
        );

        return back()->with('status', 'Un lien de réinitialisation a été envoyé à votre email.');
    }

    // ── صفحة إدخال الـ password الجديد ──
    public function showResetForm(Request $request, $token)
    {
        return view('clients.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // ── حفظ الـ password الجديد ──
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // جيب الـ record
        $record = DB::table('client_password_resets')
            ->where('email', $request->email)
            ->first();

        // تحقق من الـ token والـ expiry (60 دقيقة)
        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Lien invalide ou expiré.']);
        }

        if (now()->diffInMinutes($record->created_at) > 60) {
            DB::table('client_password_resets')->where('email', $request->email)->delete();
            return back()->withErrors(['token' => 'Ce lien a expiré. Veuillez en demander un nouveau.']);
        }

        // update الـ password
        $client = Client::where('email', $request->email)->firstOrFail();
        $client->password = Hash::make($request->password);
        $client->save();

        // حذف الـ token
        DB::table('client_password_resets')->where('email', $request->email)->delete();

        return redirect()->route('clients.login')
            ->with('status', 'Mot de passe réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
    }
}