<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): RedirectResponse
    {
        $v = Validator::make($request->only('email'), [
            'email' => 'required|email',
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }
        $email = $request->input('email');
        NewsletterSubscriber::firstOrCreate(
            ['email' => $email],
            ['is_active' => true]
        );
        return back()->with('success', 'Merci ! Vous êtes inscrit à notre newsletter.');
    }
}
