<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Facades\UserFirebaseFacade;

class UserFirebaseRepository implements UserRepositoryInterface
{
    public function create(array $data)
    {
        return UserFirebaseFacade::create($data);
    }

    public function all()
    {
        return UserFirebaseFacade::all();
    }

    public function find($id)
    {
        return UserFirebaseFacade::find($id);
    }

    public function save($id, array $data)
    {
        return UserFirebaseFacade::save($id, $data);
    }

    public function delete($id)
    {
        return UserFirebaseFacade::delete($id);
    }
}
