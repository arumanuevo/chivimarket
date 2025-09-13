<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // Redirige al proveedor (Google)
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    // Maneja el callback de Google
   public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
    
            $user = User::where('email', $googleUser->email)->first();
    
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(24)),
                    'google_id' => $googleUser->id,
                ]);
            } else {
                // Actualizar el google_id si el usuario ya existe pero no tiene google_id
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }
            }
    
            $token = $user->createToken('SocialToken')->accessToken;
    
            // Redirigir al frontend con el token
           // return redirect(env('FRONTEND_URL') . '?token=' . $token);
           return redirect(env('FRONTEND_URL2') . '?token=' . $token);
    
        } catch (\Exception $e) {
            // Loguear el error para depuraci���n
            \Log::error('Error al autenticar con Google: ' . $e->getMessage());
            return response()->json(['error' => 'Error al autenticar con Google: ' . $e->getMessage()], 500);
        }
    }
    
    // Redirige a Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->scopes(['email'])->redirect();
    }
    
    // Maneja el callback de Facebook
   public function handleFacebookAccessToken(Request $request)
{
    $accessToken = $request->input('access_token');

    // Obtener el perfil del usuario desde Facebook
    $response = Http::get("https://graph.facebook.com/me", [
        'fields' => 'id,name',
        'access_token' => $accessToken,
    ]);

    if ($response->failed()) {
        return response()->json(['error' => 'Error al obtener los datos del usuario de Facebook'], 400);
    }

    $facebookUser = $response->json();

    // Buscar o crear el usuario en tu base de datos
    $user = User::where('facebook_id', $facebookUser['id'])->first();

    if (!$user) {
        // Generar un email único basado en el ID de Facebook
        $email = $facebookUser['id'] . '@facebook.com';

        $user = User::create([
            'name' => $facebookUser['name'],
            'email' => $email,
            'password' => bcrypt(Str::random(24)),
            'facebook_id' => $facebookUser['id'],
        ]);
    }

    // Crear un token de acceso con Laravel Passport
    $token = $user->createToken('FacebookToken')->accessToken;

    return response()->json(['token' => $token]);
}

public function handleTwitterCallback()
{
    try {
        $twitterUser = Socialite::driver('twitter')->stateless()->user();
        $user = User::where('email', $twitterUser->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $twitterUser->name,
                'email' => $twitterUser->email,
                'password' => bcrypt(Str::random(24)),
                'twitter_id' => $twitterUser->id,
            ]);
        } else {
            if (empty($user->twitter_id)) {
                $user->twitter_id = $twitterUser->id;
                $user->save();
            }
        }

        $token = $user->createToken('SocialToken')->accessToken;
        return redirect(env('FRONTEND_URL') . '?token=' . $token);

    } catch (\Exception $e) {
        \Log::error('Error al autenticar con Twitter: ' . $e->getMessage());
        return response()->json(['error' => 'Error al autenticar con Twitter: ' . $e->getMessage()], 500);
    }
}

}
