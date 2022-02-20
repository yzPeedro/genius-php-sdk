<?php

namespace Yzpeedro\GeniusPhpSdk;

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

    /**
     * @param string $query
     * @return mixed
     */
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

    /**
     * @param string $id
     * @param bool $songs
     * @param array $extra
     * @return mixed
     */
    public function artist(string $id, bool $songs = false, array $extra = [])
    {
        $url = self::GENIUS_URL . "/artists/$id/songs?" . http_build_query($extra);

        if(! $songs)
            $url = self::GENIUS_URL . "/artists/$id?" . http_build_query($extra);

        $artist = curl_init($url);
        curl_setopt_array($artist, [
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [ "Authorization: Bearer " . $_SESSION['genius_access_token'] ]
        ]);

        return json_decode(curl_exec($artist));
    }
}
