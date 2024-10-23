<?php

namespace App\Http\Controllers;

use App\Models\Scale;
use App\Models\ScaleFunction;
use App\Models\ScaleResponsible;
use App\Models\User;
use App\Repositories\ScaleFunctionRepository;
use App\Repositories\ScaleRepository;
use App\Repositories\ScaleResponsibleRepository;
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

    public function store(Request $request)
    {
        $scaleName = $request->name;
        $weeks = $request->week_count;
        $currentWeek = 1;
        $status = 1;

        $scale = new Scale();
        $scale->name = $scaleName;
        $scale->weeks = $weeks;
        $scale->current_week = $currentWeek;
        $scale->status = $status;

        $this->repository->createScale($scale);

        foreach ($request->weeks as $week) {
            foreach ($week['days'] as $days) {
                foreach ($days as $day) {
                    foreach ($day as $function) {
                        if (is_array($function)) {
                            ScaleResponsible::create([
                                'user_id' => $function['responsible_id'],
                                'scale_id' => $scale->id,
                                'function_id' => $function['function_id'],
                                'week' => $week['week'],
                                'day' => $function['day']
                            ]);
                        }
                    }
                }
            }
        }

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        // $scale = $this->repository->getScale($id);
        // $scaleFunctionsRepository = new ScaleFunctionRepository(new ScaleFunction());
        // $scaleFunctions = $scaleFunctionsRepository->getAllFunction();
        // $usersRepository = new UserRepository(new User());
        // $users = $usersRepository->getAllUsers();
        // $scaleResponsiblesRepository = new ScaleResponsibleRepository(new ScaleResponsible());

        // $scaleResponsibles = $scaleResponsiblesRepository->getScaleResponsiblesByScale($id);

        // //Selected users não tem usuários repetidos, basta pegar apenas um id de cada
        // $responsibleUsers = $scaleResponsibles->pluck('user_id')->unique()->values()->all();

        // $selectedUsers = [];
        // //foreach dos responsible users
        // foreach ($responsibleUsers as $user) {
        //     $selectedUsers[] = $usersRepository->getUserById($user);
        // }

        // $responsibleFunctions = $scaleResponsibles->pluck('function_id')->unique()->values()->all();

        // $selectedFunctions = [];
        // //foreach dos responsible functions
        // foreach ($responsibleFunctions as $function) {
        //     $selectedFunctions[] = $scaleFunctionsRepository->getFunction($function);
        // }



        // return view(
        //     'admin.scales.create',
        //     [
        //         'scale' => $scale,
        //         'scaleFunctions' => $scaleFunctions,
        //         'users' => $users,
        //         'selectedUsers' => $selectedUsers,
        //         'selectedFunctions' => $selectedFunctions
        //     ]
        // );
    }

    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {
        $scale = $this->repository->getScale($id);
        if (!$scale)
            return redirect()->back();

        $scaleResponsiblesRepository = new ScaleResponsibleRepository(new ScaleResponsible());

        $scaleResponsiblesRepository->deleteScaleResponsiblesByScale($id);
        $this->repository->deleteScale($id);

        return redirect()->back();
    }
}
