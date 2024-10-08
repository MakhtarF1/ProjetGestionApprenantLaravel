<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function all();
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function createMany(array $usersData);
}
