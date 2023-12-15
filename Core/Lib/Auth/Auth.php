<?php

namespace Core\Lib\Auth;

use Symfony\Component\HttpFoundation\Cookie;

class Auth
{

    public static function attempt(string $identifier, string $secret, $guard = null) : Cookie | null
    {

        if (! $guard)
        {
            $guard = config('auth.default_guard');
        }
        
        $provider = config("auth.guards.$guard.provider");
        $identifier_name = config("auth.guards.$guard.identifier");
        $secret_name = config("auth.guards.$guard.secret");

        $user = db()->find($provider, $identifier, $identifier_name);

        if (! $user)
        {
            return null;
        }

        if (! password_verify($secret, $user[$secret_name]))
        {
            return null;
        }

        unset($user[$secret_name]);

        return new Cookie(config("auth.guards.$guard.cookie.name"), json_encode($user), time() + config("auth.guards.$guard.cookie.expire"));
    }
}