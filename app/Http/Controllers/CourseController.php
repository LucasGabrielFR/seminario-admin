<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CourseRepository;
use App\Repositories\UserRepository;
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

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $this->repository->createCourse($request);
        return redirect()->route('courses');
    }

    public function edit($id)
    {
        $course = $this->repository->getCourse($id);

        if (!$course)
            return redirect()->back();

        return view('admin.courses.edit', [
            'course' => $course
        ]);
    }

    public function update(Request $request, $id)
    {
        $course = $this->repository->getCourse($id);
        if (!$course)
            return redirect()->back();

        $this->repository->updateCourse($request, $id);
        return redirect()->route('courses');
    }

    public function view($id)
    {
        $userRepository = new UserRepository(new User());
        $users = $userRepository->getAllUsers();

        $course = $this->repository->getCourse($id);
        if (!$course)
            return redirect()->back();

        return view('admin.courses.view', [
            'course' => $course,
            'users' => $users
        ]);
    }

    public function delete($id)
    {
        $course = $this->repository->getCourse($id);
        if (!$course)
            return redirect()->back();

        $this->repository->deleteCourse($course);

        return redirect()->route('courses');
    }
}
