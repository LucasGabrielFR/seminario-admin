<?php

namespace App\Repositories;

use App\Models\ScaleFunction;
use Illuminate\Http\Request;

class ScaleFunctionRepository
{
    protected $entity;

    function __construct(ScaleFunction $model)
    {
        $this->entity = $model;
    }

    public function getAllFunction()
    {
        return $this->entity->get();
    }

    public function createFuntion($request)
    {
        $this->entity->create($request->all());
    }

    function getFunction($id)
    {
        return $this->entity->find($id);
    }

    function updateFunction(Request $request, $id)
    {
        $function = $this->entity->find($id);
        $function->update($request->all());
    }

    function deleteFunction($id)
    {
        $function = $this->entity->find($id);
        $function->delete();
    }
}
