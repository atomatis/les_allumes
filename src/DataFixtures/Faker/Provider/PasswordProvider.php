<?php

declare(strict_types=1);

namespace App\DataFixtures\Faker\Provider;

use Faker\Provider\Base as Faker;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class PasswordProvider extends Faker
{
    public function generatePassword(string $password): string
    {
        $passwordHasher = new NativePasswordHasher();

        return $passwordHasher->hash($password);
    }
}
