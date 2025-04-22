<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    protected static array $permissions = [
        'book.view', 'book.create', 'book.update', 'book.delete',
        'fourniture.view', 'fourniture.create', 'fourniture.update', 'fourniture.delete',
        'role.view', 'role.create', 'role.update', 'role.delete',
        'user.view', 'user.create', 'user.update', 'user.delete',
        'commande.create', 'commande.store',
        'client.view', 'client.create', 'client.update', 'client.delete',
        'dashboard.view',
    ];

    public function definition(): array
    {
        $permission = array_shift(static::$permissions);

        return [
            'name' => $permission ?? 'default.permission',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
