<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $repository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->repository = $courseRepository;
    }

    public function index()
    {
        $courses = $this->repository->getAllCourses();

        return view('admin.courses.index', [
            'courses' => $courses
        ]);
    }

    public function create(){
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $this->repository->createCourse($request);
        return redirect()->route('courses');
    }
}
