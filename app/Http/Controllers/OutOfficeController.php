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

        $user = session('user');
        if($user['user_type_id'] == 32 || $user['user_type_id'] == 33 || $user['user_type_id'] == 57){
            $list = $this->outOfficeRepository->findByUser($user['user_id'], $user['source_id']);
        }
        else {
            $list = $this->outOfficeRepository->all();
        }
        $approvers = $approverRepository->getApprovers();
        $data = [
            'list' => $list,
            'approvers' => $approvers,
            'user' => $user
        ];
        return view('out_office.list', $data);
    }

    public function show($id)
    {   
        $outOffice = $this->outOfficeRepository->findById($id);
        
        return $outOffice;
    }

    public function update(Request $request)
    {
        $this->outOfficeRepository->update([
            'user_id' => $request->form['approver']['user_id'],
            'user_source_id' => $request->form['approver']['user_source_id'],
            'start_date' => $request->form['startDate'],
            'end_date' => $request->form['endDate'],
            'remarks' => $request->form['remarks'],
            'updated_by' => session('user')['user_id'],
            'update_user_source' => session('user')['source_id'],
            'update_date' => Carbon::now(),
            'id' => $request->form['id']
        ]);

        $list = [];
        $user = session('user');
        if($user['user_type_id'] == 32 || $user['user_type_id'] == 33){
            $list = $this->outOfficeRepository->findByUser($user['user_id'], $user['source_id']);
        }
        else {
            $list = $this->outOfficeRepository->all();
        }

        return response()->json([
            'message' => 'Successfully saved.',
            'list' => $list
        ]);

    }

    public function destroy($id)
    {
        

        $this->outOfficeRepository->delete($id);

        $list = [];
        $user = session('user');
        if($user['user_type_id'] == 32 || $user['user_type_id'] == 33){
            $list = $this->outOfficeRepository->findByUser($user['user_id'], $user['source_id']);
        }
        else {
            $list = $this->outOfficeRepository->all();
        }

        return response()->json([
            'message' => 'Successfully deleted.',
            'list' => $list
        ]);
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
        
        $list = [];
        $user = session('user');
        if($user['user_type_id'] == 32 || $user['user_type_id'] == 33){
            $list = $this->outOfficeRepository->findByUser($user['user_id'], $user['source_id']);
        }
        else {
            $list = $this->outOfficeRepository->all();
        }

        return response()->json([
            'message' => 'Successfully saved.',
            'list' => $list
        ]);
    }

}
