<?php

namespace App\Http\Controllers;

use App\Repositories\UserCourseRepository;
use Illuminate\Http\Request;

class UserCourseController extends Controller
{
    protected $repository;

    public function __construct(UserCourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function enroll(Request $request)
    {
        $course = $request->get('course_id');
        $users = $request->get('users');

        foreach ($users as $user) {
            $this->repository->create($user, $course);
        }

        return redirect()->route('course.view', ['id' => $course]);
    }

    public function delete($courseId, $studentId)
    {
        // Lógica para deletar o aluno do curso
        // Aqui você pode chamar o método do repositório para deletar o aluno do curso
        $this->repository->deleteByCourseAndUser($studentId, $courseId);

        // Redireciona para a visualização do curso
        return redirect()->route('course.view', ['id' => $courseId])->with('success', 'Aluno removido com sucesso.');
    }
}
