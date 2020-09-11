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

    public function findByUser($userId, $userSource)
    {
        $outOffice = new OutOffice;
        return $outOffice->getByUser($userId, $userSource);
    }

    public function update($request)
    {
        $outOffice = OutOffice::findOrFail($request['id']);
        $outOffice->approver_user_id = $request['user_id'];
        $outOffice->approver_source_id = $request['user_source_id'];
        $outOffice->start_date = $request['start_date'];
        $outOffice->end_date = $request['end_date'];
        $outOffice->remarks = $request['remarks'];
        $outOffice->updated_by = $request['updated_by'];
        $outOffice->update_user_source = $request['update_user_source'];
        $outOffice->update_date = $request['update_date'];
        $outOffice->save();
    }

    public function delete($id)
    {
        OutOffice::where('id', $id)->delete();   
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