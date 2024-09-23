<?php

namespace App\Repositories\Interfaces;

interface ApprenantRepositoryInterface
{
    public function create(array $data);
    public function all(array $filters = []);
    public function find($id);
    public function save($id, array $data);
    public function delete($id);
    public function getInactive();
}
