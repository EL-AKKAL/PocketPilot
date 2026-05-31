<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function create()
    {
        return Inertia::render('account/Create');
    }

    public function store(AccountRequest $request)
    {
        Auth::user()->account()->create(
            $request->validated()
        );

        return redirect()->route('dashboard');
    }
}
