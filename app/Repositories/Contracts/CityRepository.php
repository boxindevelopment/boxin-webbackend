<?php

namespace App\Repositories\Contracts;

use App\Model\City;

interface CityRepository
{
    public function create(array $data);

    public function update(City $city, $data);

    public function delete(City $city);
}
