<?php

namespace App\Repositories\Contracts;

use App\Model\User;

interface UserRepository
{
    public function create(array $data);

    public function update(User $user, $data);

    public function delete(User $user);
}
