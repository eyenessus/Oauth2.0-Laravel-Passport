<?php

namespace App\Models;
use Laravel\Passport\Client as BaseClient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends BaseClient
{
    public function skipsAuthorization(): bool
    {
        return $this->firstParty();
    }
    use HasFactory;
}
