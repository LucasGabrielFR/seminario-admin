<?php

namespace App\Repositories;

use App\Models\UserPermission;

class UserPermissionRepository
{
    protected $entity;

    function __construct(UserPermission $model)
    {
        $this->entity = $model;
    }

    public function create($user_id, $permission_id)
    {
        $this->entity->create([
            'user_id' => $user_id,
            'permission_id' => $permission_id
        ]);
    }

    public function deleteByUser($user_id)
    {
        $this->entity->where('user_id', $user_id)->delete();
    }
}
