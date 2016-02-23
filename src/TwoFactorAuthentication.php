<?php
namespace Fortytwo\TwoFactorAuthentication;

class TwoFactorAuthentication
{
    public function HookAuthentication($user, $password)
    {
        return $user;
    }
}
