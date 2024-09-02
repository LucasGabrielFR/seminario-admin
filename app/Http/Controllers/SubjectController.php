<?php

namespace App\Http\Controllers;

use App\Repositories\SubjectRepository;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $repository;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->repository = $subjectRepository;
    }

    public function create($courseId)
    {
        return view('admin.subjects.create', [
            'courseId' => $courseId
        ]);
    }

    public function store(Request $request)
    {
        $this->repository->createSubject($request);
        return redirect()->route('course.view', ['id' => $request->course_id]);
    }

    public function checkCode($code)
    {
        $subject = $this->repository->getSubjectByCode($code);

        if (!$subject) {
            return response()->json(false);
        }

        return response()->json(true);
    }

    public function edit($id)
    {
        $subject = $this->repository->getSubject($id);
        return view('admin.subjects.edit', [
            'subject' => $subject
        ]);
    }

    public function update(Request $request, $id)
    {
        $subject = $this->repository->getSubject($id);
        if (!$subject)
            return redirect()->back();

        $this->repository->updateSubject($request, $id);
        return redirect()->route('course.view', ['id' => $request->course_id]);
    }

    public function delete($id)
    {
        $subject = $this->repository->getSubject($id);
        if (!$subject)
            return redirect()->back();

        $this->repository->deleteSubject($subject);

        return redirect()->route('course.view', ['id' => $subject->course_id]);
    }
}
