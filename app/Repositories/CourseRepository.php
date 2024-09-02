<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseRepository
{
    protected $entity;

    public function __construct(Course $model)
    {
        $this->entity = $model;
    }

    public function getAllCourses()
    {
        return $this->entity->all();
    }

    public function createCourse(Request $request)
    {
        $this->entity->create($request->all());
    }

    public function getCourse($id)
    {
        return $this->entity->find($id);
    }

    public function updateCourse(Request $request, $id)
    {
        $course = $this->entity->find($id);
        $course->update($request->all());
    }

    public function deleteCourse($course)
    {
        $course->delete();
    }
}
