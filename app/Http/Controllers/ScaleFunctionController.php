<?php

namespace App\Http\Controllers;

use App\Repositories\ScaleFunctionRepository;
use Illuminate\Http\Request;

class ScaleFunctionController extends Controller
{
    protected $repository;

    public function __construct(ScaleFunctionRepository $scaleFunctionRepository)
    {
        $this->repository = $scaleFunctionRepository;
    }

    public function index()
    {
        $functions = $this->repository->getAllFunction();
        return view(
            'admin.scales.functions.index',
            [
                'functions' => $functions
            ]
        );
    }

    public function create()
    {
        return view('admin.scales.functions.create');
    }

    public function store(Request $request)
    {
        $this->repository->createFuntion($request);
        return redirect()->route('scale-functions');
    }

    public function edit($id)
    {
        $function = $this->repository->getFunction($id);

        if (!$function)
            return redirect()->back();

        return view(
            'admin.scales.functions.edit',
            [
                'function' => $function
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $function = $this->repository->getFunction($id);

        if (!$function)
            return redirect()->back();

        $this->repository->updateFunction($request, $id);
        return redirect()->route('scale-functions');
    }

    public function delete($id)
    {
        $function = $this->repository->getFunction($id);
        if (!$function)
            return redirect()->back();

        $this->repository->deleteFunction($id);
        return redirect()->route('scale-functions');
    }
}
