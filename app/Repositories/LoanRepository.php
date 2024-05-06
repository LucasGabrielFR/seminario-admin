<?php

namespace App\Repositories;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanRepository
{
    protected $entity;

    function __construct(Loan $model)
    {
        $this->entity = $model;
    }

    public function getAllLoans()
    {
        return $this->entity->orderBy('status')->get();
    }

    public function createLoan($loan)
    {
        $this->entity->create($loan);
    }

    public function returnLoan($id)
    {
        $loan = $this->entity->find($id);
        $loan->update([
            'status' => 2,
            'date_return' => date('Y-m-d H:i:s')
        ]);
    }

    public function extendMin($id)
    {
        $loan = $this->entity->find($id);

        $newLimitDate = date('Y-m-d', strtotime('+7 days'));

        $loan->update([
            'date_limit' => $newLimitDate
        ]);
    }


    public function extendMax($id)
    {$loan = $this->entity->find($id);

        $newLimitDate = date('Y-m-d', strtotime('+15 days'));

        $loan->update([
            'date_limit' => $newLimitDate
        ]);
    }

    public function deleteCategory($category)
    {
        $category->delete();
    }

    public function getCategory($id)
    {

        return $this->entity->find($id);
    }
}
