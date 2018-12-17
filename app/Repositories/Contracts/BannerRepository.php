<?php

namespace App\Repositories\Contracts;

use App\Model\Banner;

interface BannerRepository
{
    public function create(array $data);

    public function update(Banner $banner, $data);

    public function delete(Banner $banner);
}
