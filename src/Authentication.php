<?php

namespace Yzpeedro\GeniusPhpSdk;

class Authentication
{
    private const GENIUS_AUTH_URL = "https://api.genius.com";

    public function __construct()
    {
        if (! session_status() == PHP_SESSION_NONE)
            session_start();
    }

    /**
     * @param string $accessToken
     * @return void
     */
    public static function setAccessToken(string $accessToken): void { $_SESSION['genius_access_token'] = $accessToken; }

    /**
     * @return bool
     */
    public static function validate(): bool
    {
        $auth = curl_init(self::GENIUS_AUTH_URL . "/search/?q=Kendrick Lamar");
        curl_setopt_array($auth, [
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [ "Authorization: Bearer " . $_SESSION['genius_access_token'] ]
        ]);
        $res = json_decode(curl_exec($auth));

        if (! isset($res->error))
            return true;

        return false;
    }
}