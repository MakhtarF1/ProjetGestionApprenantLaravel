<?php

namespace App\Services\Interfaces;

interface ApprenantServiceInterface
{
    public function create(array $data);
    public function all(array $filters = []);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function activateAccount($id, $password);
    public function getInactiveApprenants();
    public function createUserAccount($apprenantData);
}
