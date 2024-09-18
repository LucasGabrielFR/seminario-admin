<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $repository;

    public function __construct(RoleRepository $roleRepository)
    {

        $this->repository = $roleRepository;
    }

    function index()
    {
        $roles = $this->repository->getAllRoles();

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    function create()
    {
        return view('admin.roles.create');
    }

    function store(Request $request)
    {
        $this->repository->createRole($request);
        return redirect()->route('roles');
    }

    function edit($id)
    {
        $role = $this->repository->getRole($id);

        if(!$role)
            return redirect()->back();

        return view('admin.roles.edit', [
            'role' => $role
        ]);
    }

    function update(Request $request, $id)
    {
        $role = $this->repository->getRole($id);
        if(!$role)
            return redirect()->back();

        $this->repository->updateRole($request, $id);
        return redirect()->route('roles');
    }

    function delete($id)
    {
    }
}
