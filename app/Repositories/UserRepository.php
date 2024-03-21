<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

class UserRepository
{
    protected $entity;

    function __construct(User $model)
    {
        $this->entity = $model;
    }

    public function getAllUsers()
    {
        return $this->entity->orderBy('name')->get();
    }

    public function createUser($user)
    {
        $this->entity->create($user);
    }

    public function updateUser(Request $request, $id)
    {
        $user = $this->entity->find($id);
        $user->update($request->all());
    }

    public function deleteUser($user)
    {
        $user->delete();
    }

    public function getUserById($id)
    {

        return $this->entity->find($id);
    }
}
