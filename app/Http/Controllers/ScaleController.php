<?php

namespace App\Http\Controllers;

use App\Models\ScaleFunction;
use App\Models\User;
use App\Repositories\ScaleFunctionRepository;
use App\Repositories\ScaleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ScaleController extends Controller
{
    protected $repository;
    function __construct(ScaleRepository $scaleRepository)
    {
        $this->repository = $scaleRepository;
    }
    function index()
    {
        $scales = $this->repository->getAllScales();
        return view(
            'admin.scales.index',
            [
                'scales' => $scales
            ]
        );
    }
    public function create()
    {
        $scaleFunctionsRepository = new ScaleFunctionRepository(new ScaleFunction());
        $scaleFunctions = $scaleFunctionsRepository->getAllFunction();

        $usersRepository = new UserRepository(new User());
        $users = $usersRepository->getAllUsers();
        return view(
            'admin.scales.create',
            [
                'scaleFunctions' => $scaleFunctions,
                'users' => $users
            ]
        );
    }
}
