<?php

namespace App\Repositories;

use App\Model\Banner;
use App\Repositories\Contracts\BannerRepository as BannerRepositoryInterface;

class BannerRepository implements BannerRepositoryInterface
{
    protected $model;

    public function __construct(Banner $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
    
    public function all()
    {
        return $this->model->where('deleted_at', NULL)->orderBy('updated_at', 'DESC')->orderBy('id','DESC')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
    
    public function update(Banner $banner, $data)
    {
        return $banner->update($data);
    }

    public function delete(Banner $banner)
    {
        return $banner->delete();
    }
    
}