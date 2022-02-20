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

    /**
     * @param string $raw_annotatable_url
     * @param string $canonical_url
     * @param string $og_url
     * @return mixed
     */
    public function webPage(string $raw_annotatable_url, string $canonical_url = "", string $og_url = "")
    {
        $data = [
            "raw_annotatable_url" => $raw_annotatable_url,
            "canonical_url" => $canonical_url,
            "og_url" => $og_url
        ];

        $webPage = curl_init(self::GENIUS_URL . "/web_pages/lookup/?" . http_build_query($data));
        curl_setopt_array($webPage, [
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [ "Authorization: Bearer " . $_SESSION['genius_access_token'] ]
        ]);

        return json_decode(curl_exec($webPage));
    }

    /**
     * @param string $id
     * @param array $extra
     * @return mixed
     */
    public function song(string $id, array $extra = [])
    {
        $song = curl_init(self::GENIUS_URL . "/songs/$id?" . http_build_query($extra));
        curl_setopt_array($song, [
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [ "Authorization: Bearer " . $_SESSION['genius_access_token'] ]
        ]);

        return json_decode(curl_exec($song));
    }

    /**
     * @param string $web_page_id
     * @param array $extra
     * @return mixed
     * @throws GeniusException
     */
    public function referents(string $web_page_id = "", array $extra = [])
    {
        if (! empty($web_page_id) && isset($extra["song_id"]))
            throw new GeniusException("You may pass only one of song_id and web_page_id, not both.");

        $referents = curl_init(self::GENIUS_URL . "/referents/?web_page_id=$web_page_id&" . http_build_query($extra));
        curl_setopt_array($referents, [
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [ "Authorization: Bearer " . $_SESSION['genius_access_token'] ]
        ]);

        return json_decode(curl_exec($referents));
    }

    /**
     * @param string $id
     * @param array $extra
     * @return mixed
     */
    public function annotations(string $id, array $extra = [])
    {
        $annotations = curl_init(self::GENIUS_URL . "/annotations/$id" . http_build_query($extra));
        curl_setopt_array($annotations, [
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [ "Authorization: Bearer " . $_SESSION['genius_access_token'] ]
        ]);

        return json_decode(curl_exec($annotations));
    }
}
