<?php

namespace App\Repositories;

use App\Models\Interfaces\RoleInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;

/**
 *
 * @author Muhammad Adnan <adnanandeem1994@gmail.com>
 * @date   30/09/2020
 */
class RolesRepository implements RoleRepositoryInterface
{
    private $model;

    public function __construct(RoleInterface $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model::all();
    }

    public function create(array $data)
    {
        $model = $this->model::create($data);

        return $model;
    }

    public function findFirst()
    {
        return $this->model::first();
    }

    public function find($id)
    {
        return $this->model::where('id', $id)->first();
    }

    public function update($id, array $data)
    {
        $this->model::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $this->model::where('id', $id)->delete();
    }

    public function zones(){}
    public function shifts($id){}
    public function shiftOrders($id){}
    public function sprintTask($id){}
    public function merchant($id){}
    public function location($id){}
    public function occupiedJoey($id){}
    public function joeyLocation($id){}
}
