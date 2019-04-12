<?php

namespace App\Repositories\Contracts;

use App\Model\SpaceSmall;

interface SpaceSmallRepository
{
    public function create(array $data);

    public function update(SpaceSmall $spaceSmall, $data);

    public function delete(SpaceSmall $spaceSmall);
}
