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

    public function create($courseId){
        return view('admin.subjects.create', [
            'courseId' => $courseId
        ]);
    }

    public function store(Request $request){
        $this->repository->createSubject($request);
        return redirect()->route('course.view', ['id' => $request->course_id]);
    }
}
