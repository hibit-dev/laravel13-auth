<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;

class TextFileUserProvider implements UserProvider
{
    public function retrieveById($identifier): ?Authenticatable
    {
        $users = $this->loadUsers();

        if (!isset($users[$identifier])) {
            return null;
        }

        return new User(['email' => $identifier, 'password' => $users[$identifier]]);
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $users = $this->loadUsers();
        $email = $credentials['email'] ?? null;

        if (!$email || !isset($users[$email])) {
            return null;
        }

        return new User(['email' => $email, 'password' => $users[$email]]);
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return Hash::check($credentials['password'], $user->getAuthPassword());
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): void
    {
    }

    protected function loadUsers(): array
    {
        $file = config('auth.providers.custom_auth_provider.path');

        if (!file_exists($file)) {
            return [];
        }

        $users = [];
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            [$email, $hash] = explode(':', $line, 2);
            $users[$email] = $hash;
        }

        return $users;
    }
}
