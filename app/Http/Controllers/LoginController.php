<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)):
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }

    public function resetpassword(Request $request)
    {
        //
        // $request = $request->except(['_token', '_method']);

        if ($request->password != $request->confirmpassword) {
            return back()->with('error', 'รหัสผ่านไม่ถูกต้อง');
        }

        $user = User::where('email', $request->email)
            ->where('tel', $request->tel)->first();

        if ($user != true) {
            return back()->with('error', 'ข้อมูลไม่ถูกต้อง');
        }

        $request->validate([
            'password' => 'required|min:8',

        ]);

        $user->password = $request->password;
        $user->save();

        return redirect()->route('login.show')
            ->with('reset', 'เปลี่ยนรหัสผ่านสำเร็จ');
    }
}
