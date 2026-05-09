<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function create()
    {
        return Inertia::render('account/Create');
    }

    public function store(AccountRequest $request)
    {
        auth()->user()->account()->create(
            $request->validated()
        );

        return redirect()->route('dashboard');
    }
}
