<?php

namespace App\Repositories;
use App\Model\Warehouse;
use App\Model\User;
use App\Model\Box;
use App\Model\Space;
use App\Repositories\Contracts\DashboardRepository as DashboardRepositoryInterface;
use DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    protected $warehouse;
    protected $user;
    protected $box;
    protected $space;

    public function __construct(Warehouse $warehouse, User $user, Box $box, Space $space)
    {
        $this->warehouse = $warehouse;
        $this->user      = $user;
        $this->box       = $box;
        $this->space     = $space;
    }
    
    public function countWarehouse()
    {
        return $this->warehouse->where('deleted_at', NULL)->count();
    }

    public function countUser()
    {
        return $this->user->where('deleted_at', NULL)->count();
    }

    public function countBox()
    {
        return $this->box->where('deleted_at', NULL)->count();
    }

    public function countSpace()
    {
        return $this->space->where('deleted_at', NULL)->count();
    }

}