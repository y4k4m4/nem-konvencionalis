<?php

namespace App\Models;

use App;
use App\Support\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Laudis\Neo4j\Contracts\ClientInterface;

class User extends Model implements Authenticatable
{
    public int $id;
    public string $name;
    public string $token;
    public string $password;
    public function __construct($data) {
        $this->id = $data->getId();
        $this->name = $data->getProperty('name');
        $this->token = $data->getProperty('token');
        $this->password = $data->getProperty('password');
    }

    public function getAuthIdentifierName(): string {
        return "id";
    }

    public function getAuthIdentifier(): int {
        return $this->id;
    }

    public function getAuthPassword(): string {
        return $this->password;
    }

    public function getRememberToken(): string {
        return $this->token;
    }

    public function setRememberToken($value): void {
        $this->token = $value;
    }

    public function getRememberTokenName(): string {
        return "token";
    }
}
