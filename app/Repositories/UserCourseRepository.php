<?php

namespace App\Repositories;

use App\Models\UserCourse;

class UserCourseRepository
{
    protected $entity;

    function __construct(UserCourse $model)
    {
        $this->entity = $model;
    }

    public function create($user_id, $course_id)
    {
        return $this->entity->create([
            'user_id' => $user_id,
            'course_id' => $course_id,
            'status' => 1
        ]);
    }

    public function deleteByCourseAndUser($user_id, $course_id)
    {
        $this->entity->where('user_id', $user_id)->where('course_id', $course_id)->delete();
    }
}
