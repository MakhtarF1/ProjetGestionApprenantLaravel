<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
    public function createUser(array $data);
    public function getAllUsers();
    public function getUser($id);
    public function updateUser($id, array $data);
    public function deleteUser($id);
}
