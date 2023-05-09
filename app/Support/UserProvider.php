<?php namespace App\Support;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider as BaseUserProvider;
use Illuminate\Support\Str;
use Laudis\Neo4j\Contracts\ClientInterface;

class UserProvider implements BaseUserProvider {
    private ClientInterface $client;
    public function __construct() {
        $this->client = \App::make(ClientInterface::class);
    }

    private function getUser(string $query) {
        $results = $this->client->run($query)->getResults();
        if ($results->count() > 0) {
            return new User($results->first()['user']);
        } else {
            return null;
        }
    }

    public function retrieveById($identifier): User|null {
        return $this->getUser("MATCH(user:USER) WHERE ID(user)=$identifier RETURN user");
    }

    public function retrieveByToken($identifier, $token): User {
        return $this->getUser("MATCH(user:USER{token:$token}) RETURN user");
    }

    public function updateRememberToken(Authenticatable $user, $token): void {
        $this->client->run("MATCH(user:USER)
            SET user.token=\"$token\"
            RETURN user
        ");
        $user->token = $token;
    }

    public function retrieveByCredentials(array $credentials): User|null {
        $pw = \Hash::make('1234');
        $this->client->run("MERGE(user:USER{name:\"user\", password:\"$pw\", token:\"\"}) RETURN user");
        return $this->getUser("
            MATCH(user:USER{name:\"${credentials['username']}\"})
            RETURN user
        ");
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool {
        return \Hash::check($credentials['password'], $user->getAuthPassword());
    }
}
