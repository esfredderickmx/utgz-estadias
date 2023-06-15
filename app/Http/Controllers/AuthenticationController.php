<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller {

  public function openLoginForm() {
    return redirect()->back()->with('openLoginModal', true);
  }

  public function openResetForm(Request $request, $token = null) {
    return redirect()->route('home')->with([
      'token' => $token,
      'email' => $request->email,
      'openResetModal' => true
    ]);
  }

  public function logout() {
    Auth::logout();

    Session::flush();
    Session::invalidate();
    Session::regenerateToken();

    return redirect()->route('home')->with('info', 'Sesión finalizada correctamente.');
  }

  public function login(Request $request) {
    $request['username'] = $request['login_username'] . '@utgz.edu.mx';
    $request['password'] = $request['login_password'];
    $request['remember'] = $request['login_password'];

    $validated = $request->validate([
      'username' => 'required',
      'password' => 'required',
    ]);

    $username = $validated['username'];
    $password = $validated['password'];
    $remember = $request->input('remember') ? true : false;

    if (Auth::attempt(['email' => $username, 'password' => $password], $remember)) {
      $request->session()->regenerate();

      return redirect()->back()->with('success', 'Sesión iniciada correctamente.');
    }

    return redirect()->back()->withErrors('El usuario y/o la contraseña son incorrectos.');
  }

  public function forgot(Request $request) {
    $request['email'] = $request['forgot_email'] . '@utgz.edu.mx';

    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink(
      $request->only('email')
    );
    return $status === Password::RESET_LINK_SENT
      ? back()->with('success', __($status))
      : back()->withErrors(['email' => __($status)]);
  }

  public function reset(Request $request) {
    $request['email'] = $request['reset_email'];
    $request['password'] = $request['reset_password'];
    $request['password_confirmation'] = $request['reset_password_confirmation'];

    $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => [
        'required',
        'confirmed',
        'min:8',
        'not_in:' . $request->email,
        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
      ],
    ]);

    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function ($user, $password) {
        $user->forceFill([
          'password' => $password,
        ])->save();

        event(new PasswordReset($user));
      }
    );

    return $status === Password::PASSWORD_RESET
      ? redirect()->route('auth.form')->with('success', __($status))
      : back()->withErrors(['email' => [__($status)]]);
  }
}
