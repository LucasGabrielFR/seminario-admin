<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionRepository
{
    protected $entity;

    function __construct(Permission $model)
    {
        $this->entity = $model;
    }

    public function getAllPermissions()
    {
        return $this->entity->get();
    }

    public function createPermission($request)
    {
        $this->entity->create($request->all());
    }

    function getPermission($id)
    {
        return $this->entity->find($id);
    }

    function updatePermission(Request $request, $id)
    {
        $permission = $this->entity->find($id);
        $permission->update($request->all());
    }
}
