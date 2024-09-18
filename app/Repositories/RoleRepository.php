<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleRepository
{
    protected $entity;

    function __construct(Role $model)
    {
        $this->entity = $model;
    }

    public function getAllRoles()
    {
        return $this->entity->get();
    }

    public function createRole($request)
    {
        $this->entity->create($request->all());
    }

    function getRole($id)
    {
        return $this->entity->find($id);
    }

    function updateRole(Request $request, $id)
    {
        $role = $this->entity->find($id);
        $role->update($request->all());
    }
}
