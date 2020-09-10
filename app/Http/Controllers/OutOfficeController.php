<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OutOfficeRepositoryInterface;
use App\Repositories\ApproverRepositoryInterface;
use Carbon\Carbon;

class OutOfficeController extends Controller
{

    private $outOfficeRepository;
  

    public function __construct(OutOfficeRepositoryInterface $outOfficeRepository)
    {
        $this->outOfficeRepository = $outOfficeRepository;
    }

    public function index(ApproverRepositoryInterface $approverRepository)
    {
        $list = $this->outOfficeRepository->all();
        $approvers = $approverRepository->getApprovers();
        $data = [
            'list' => $list,
            'approvers' => $approvers
        ];
        return view('out_office.list', $data);
    }

    public function show($id)
    {   
        $outOffice = $this->outOfficeRepository->findById($id);
        
        return $outOffice;
    }

    public function update($id)
    {
        $this->outOfficeRepository->update($id);
    }

    public function destroy($id)
    {
        $this->outOfficeRepository->delete($id);
    }

    public function store(Request $request)
    {   
        $this->outOfficeRepository->store([
            'user_id' => $request->form['approver']['user_id'],
            'user_source_id' => $request->form['approver']['user_source_id'],
            'start_date' => $request->form['startDate'],
            'end_date' => $request->form['endDate'],
            'remarks' => $request->form['remarks'],
            'created_by' => session('user')['user_id'],
            'create_user_source' => session('user')['source_id'],
            'creation_date' => Carbon::now()
        ]);

        return response()->json([
            'message' => 'Successfully saved.',
            'list' => $this->outOfficeRepository->all()
        ]);
    }

}
