<?php

namespace App\Http\Controllers;

use App\Repositories\RoleClassroomRepository;
use Illuminate\Http\Request;

class RoleClassroomController extends Controller
{
    protected $repository;

    public function __construct(RoleClassroomRepository $roleClassroom)
    {
        $this->repository = $roleClassroom;
    }

    public function enroll(Request $request)
    {
        $subject = $request->get('subject_id');
        $users = $request->get('users');

        foreach ($users as $user) {
            $this->repository->create($user, $subject);
        }

        return redirect()->route('subject.view', ['id' => $subject]);
    }

    public function delete($subjectId, $studentId)
    {
        $this->repository->deleteBySubjectAndUser($studentId, $subjectId);
        return redirect()->route('subject.view', ['id' => $subjectId])->with('success', 'Aluno removido com sucesso.');
    }
}
