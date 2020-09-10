<?php

namespace App\Repositories;
use App\Models\OutOffice;
use App\Repositories\OutOfficeRepositorInterface;

class OutOfficeRepository implements OutOfficeRepositoryInterface
{

    protected $guarded = [];

    public function all()
    {
        $outOffice = new OutOffice;
        return $outOffice->getAll();
    }

    public function findById($id)
    {
        $outOffice = new OutOffice;
        return $outOffice->findById();
    }

    public function update($id)
    {
        $outOffice = OutOffice::where('id', $id)->firstOrFail();

        $outOffice->update(
            request()->only('approver_user_id')
        ); 

        return redirect('/out-of-office/' . $id);
    }

    public function delete($id)
    {
        $outOffice = OutOffice::where('id', $id)->delete();   
    }

    public function store($request)
    {
        $outOffice = new OutOffice;
        $outOffice->approver_user_id = $request['user_id'];
        $outOffice->approver_source_id = $request['user_source_id'];
        $outOffice->start_date = $request['start_date'];
        $outOffice->end_date = $request['end_date'];
        $outOffice->remarks = $request['remarks'];
        $outOffice->created_by = $request['created_by'];
        $outOffice->create_user_source = $request['create_user_source'];
        $outOffice->creation_date = $request['creation_date'];
        $outOffice->save();
    }

}