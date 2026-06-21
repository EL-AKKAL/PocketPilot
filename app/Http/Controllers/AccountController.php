<?php

namespace App\Http\Controllers;

use App\Concerns\HasToast;
use App\Http\Requests\AccountRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
{
    use HasToast;

    public function create()
    {
        return Inertia::render('account/Create');
    }

    public function store(AccountRequest $request)
    {
        Auth::user()->account()->create(
            $request->validated()
        );

        $this->toast('account created successfully');

        return redirect()->route('dashboard');
    }
}
