<?php

namespace Yzpeedro\GeniusPhpSdk;

use Yzpeedro\GeniusPhpSdk\Authentication;

class Genius
{
    private const GENIUS_URL = "https://api.genius.com";

    /**
     * @throws GeniusException
     */
    public function __construct(string $accessToken = "")
    {
        if (! session_status() == PHP_SESSION_NONE)
            session_start();

        if (! empty($accessToken))
            Authentication::setAccessToken($accessToken);

        if (! isset($_SESSION['genius_access_token']))
            throw new GeniusException("You must provide your access token first.");
    }

    public function search(string $query = "")
    {
        $search = curl_init(self::GENIUS_URL . "/search?q=" . $query);
        curl_setopt_array($search, [
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [ "Authorization: Bearer " . $_SESSION['genius_access_token'] ]
        ]);

        return json_decode(curl_exec($search));
    }
}
