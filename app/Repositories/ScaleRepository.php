<?php

namespace App\Repositories;

use App\Models\Scale;
use Illuminate\Http\Request;

class ScaleRepository
{
    protected $entity;

    function __construct(Scale $model)
    {
        $this->entity = $model;
    }

    public function getAllScales()
    {
        return $this->entity->get();
    }

    public function createScale($request)
    {
        $this->entity->create($request->all());
    }

    function getScale($id)
    {
        return $this->entity->find($id);
    }

    function updateScale(Request $request, $id)
    {
        $scale = $this->entity->find($id);
        $scale->update($request->all());
    }

    function deleteScale($id)
    {
        $scale = $this->entity->find($id);
        $scale->delete();
    }
}
