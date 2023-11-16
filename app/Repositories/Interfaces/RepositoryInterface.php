<?php

namespace App\Repositories\Interfaces;

/**
 * Interface RepositoryInterface
 *
 * @author Yousuf Sadiq <muhammad.sadiq@joeyco.com>
 */
interface RepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);

    public function zones();

    public function shifts($id);

    public function shiftOrders($id);

    public function sprintTask($id);

    public function merchant($id);

    public function location($id);

    public function occupiedJoey($id);

    public function joeyLocation($id);
}
