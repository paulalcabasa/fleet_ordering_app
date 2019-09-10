<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPersons extends Model
{
    //
	protected $table = "IPC_DMS.FS_PROJECT_CONTACT_PERSONS";
    protected $connection = "oracle";
    const CREATED_AT = 'CREATION_DATE';
    const UPDATED_AT = 'UPDATE_DATE';
    
    public function insert_contact_persons($params){
    	$this->insert($params);
    }

    public function get_contact_persons($project_id){
		$query = $this
			->where('project_id', $project_id)
			->get();
		return $query;
	}

    public function get_contacts($project_id){
        $query = $this
            ->selectRaw('contact_person_id,
                        project_id,
                        name,
                        position_title AS position,
                        department,
                        contact_number,
                        email_address AS email')
            ->where('project_id', $project_id)
            ->get();
        return $query;
    }

    public function delete_contact_person($contact_person_id){
        $this->where([
            [ 'contact_person_id', '=', $contact_person_id ]
        ])->delete();
    }

    public function update_contact_person($params){
       $this
            ->where([
                [ 'contact_person_id', '=' , $params['contact_person_id'] ]
            ])
            ->update([
                'name'                  => $params['name'],
                'position_title'        => $params['position_title'],
                'department'            => $params['department'],
                'contact_number'        => $params['contact_number'],
                'email_address'         => $params['email_address'],
                'updated_by'            => $params['updated_by'],
                'update_user_source_id' => $params['update_user_source_id']
            ]);

    }




}
