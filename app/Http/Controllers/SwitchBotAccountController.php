<?php

namespace App\Http\Controllers;

use App\Http\Requests\SwitchBotAccount\StoreRequest;
use App\Models\SwitchBotAccount;
use App\Models\User;

class SwitchBotAccountController extends Controller
{
    public function store(StoreRequest $request)
    {
        $user = User::find(auth()->id());

        $user->switchBotAccount()->create($request->validated());

        return back()->with('message', 'Success!');
    }

    public function show()
    {
        $user = User::find(auth()->id());

        $account = $user->switchBotAccount;

        return view('switch-bot.accounts.show')->with('account', $account);
    }

    public function destroy(SwitchBotAccount $account)
    {
        $account->delete();

        return back()->with('message', 'Success!');
    }
}
