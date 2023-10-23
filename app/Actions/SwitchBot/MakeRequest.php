<?php

namespace App\Actions\SwitchBot;

use App\Contracts\Action;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class MakeRequest implements Action
{
    private const TO_ENCODING = 'UTF-8';
    private const HASH_ALGORITHM = 'sha256';
    private const BASE_URL = 'https://api.switch-bot.com';

    private array $headers = [];

    private function __construct(private string $token, string $secret)
    {
        $nonce = self::guidv4();
        $t = time() * 1000;
        $data = mb_convert_encoding($this->token . $t . $nonce, self::TO_ENCODING);
        $sign = hash_hmac(self::HASH_ALGORITHM, $data, $secret, true);
        $sign = strtoupper(base64_encode($sign));

        $this->headers['sign'] = $sign;
        $this->headers['nonce'] = $nonce;
        $this->headers['t'] = $t;
    }

    public static function for(string $token, string $secret): self
    {
        return new self($token, $secret);
    }

    public function do(): PendingRequest
    {
        return Http::baseUrl(self::BASE_URL)
            ->contentType('application/json; charset=utf8')
            ->withToken($this->token, null)
            ->withHeaders($this->headers);
    }

    private static function guidv4(string $data = null): string
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen(($data)) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
