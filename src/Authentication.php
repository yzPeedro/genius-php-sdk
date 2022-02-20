<?php

class Authentication
{
    public function __construct()
    {
        if (! session_status() == PHP_SESSION_NONE)
            session_start();
    }

    public static function setClientId(string $clientId)
    {
        $_SESSION["client_id"] = $clientId;
    }

    public static function setClientSecret(string $clientSecret)
    {
        $_SESSION["client_secret"] = $clientSecret;
    }

    public static function unsetAuth()
    {
        session_destroy();
    }
}