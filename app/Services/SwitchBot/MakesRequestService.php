<?php

namespace App\Services\SwitchBot;

use App\Actions\SwitchBot\MakeRequest;
use App\Contracts\Service;

class MakesRequestService implements Service
{
    public static function makeRequest()
    {
        $account = auth()->user()->switchBotAccount;

        throw_if(blank($account));

        return MakeRequest::for($account->token, $account->secret)->do();
    }
}
