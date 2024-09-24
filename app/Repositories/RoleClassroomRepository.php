<?php

namespace App\Repositories;

use App\Models\RoleClassroom;

class RoleClassroomRepository
{
    protected $entity;

    function __construct(RoleClassroom $model)
    {
        $this->entity = $model;
    }

    public function create($user_id, $subject_id)
    {
        return $this->entity->create([
            'user_id' => $user_id,
            'subject_id' => $subject_id,
            'role_id' => 2
        ]);
    }

    public function deleteBySubjectAndUser($user_id, $subject_id)
    {
        $this->entity->where('user_id', $user_id)->where('subject_id', $subject_id)->delete();
    }
}
