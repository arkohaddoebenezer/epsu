<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "password" => "required|confirmed|min:8",
                "email" => "required|email|exists:users,email",
            ],
            [
                "password.required" => "You have to supply your new password",
                "password.confirmed" => "Your passwords do not match",
                "password.min" => "Your new password must be at least 8 characters long",

                "email.required" => "No email supplied",
                "email.exists" => "Unknown email supplied",
                "email.email" => "The email you supplied is invalid",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => "Reset failed. " . join(" ", $validator->errors()->all()),
            ]);
        }

        $authenticatedUser = User::where("email", $request->email)->first();

        //update new password with the authenticated user
        try {
            $authenticatedUser->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                "ok" => true,
                "msg" => "Password changed!",
            ]);
        } catch (\Exception $th) {
            return response()->json([
                "ok" => false,
                "msg" => "An internal error occured. Reset failed",
            ]);
        }
    }
}
