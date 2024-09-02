<?php

namespace App\Repositories;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectRepository
{
    protected $entity;

    public function __construct(Subject $model)
    {
        $this->entity = $model;
    }

    public function getAllSubjects()
    {
        return $this->entity->all();
    }

    public function createSubject(Request $request)
    {
        $this->entity->create($request->all());
    }

    public function getSubject($id)
    {
        return $this->entity->find($id);
    }

    public function updateSubject(Request $request, $id)
    {
        $subject = $this->entity->find($id);
        $subject->update($request->all());
    }

    function getSubjectByCode($code) {
        return $this->entity->where('code', $code)->first();
    }

    public function deleteSubject($subject)
    {
        $subject->delete();
    }
}
