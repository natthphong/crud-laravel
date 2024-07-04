<?php


namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Auth implements JWTSubject
{
    use Notifiable;

    public function getJWTIdentifier()
    {
        return (string) $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
