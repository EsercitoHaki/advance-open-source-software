<?php

namespace App\Repositories;

interface AuthRepositoryInterface
{
    public function create(array $data);
    public function findByEmail(string $email);
}