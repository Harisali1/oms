<?php

namespace App\Repositories;


use App\Models\Interfaces\QuizInterface;
use App\Repositories\Interfaces\QuizRepositoryInterface;

/**
 * Class UserRepository
 *
 * @author Yousuf Sadiq <muhammad.sadiq@joeyco.com>
 */
class QuizRepository implements QuizRepositoryInterface
{
    private $model;

    public function __construct(QuizInterface $model)
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

    public function find($id)
    {
        return $this->model::where('id', $id)->first();
    }

    public function findBy($attribute, $value) {
        return $this->model->where($attribute, '=', $value)->first();
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
