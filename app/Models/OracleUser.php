<?php

namespace App\Models;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OracleUser extends Authenticatable
{
    protected $guard = 'oracle_users';
    protected $connection = 'oracle';
    protected $table = 'fnd_user';
    protected $primaryKey = 'user_id';

    /**
     * Fetch User from Oracle or IPC Portal
     * 
     * @param string $user_name, $password, $system_id
     * @return array \Illuminate\Http\Response
     */
    public function user($user_name, $password, $system_id)
    {
        $query = DB::connection('oracle')
            ->select('
                SELECT 
                    tab.user_id,
                    tab.user_name,
                    tab.first_name,
                    tab.middle_name,
                    tab.last_name,
                    tab.division,
                    tab.department,
                    tab.section,
                    tab.customer_id,
                    tab.source_id,
                    tab.email,
                    ut.user_type_name
                FROM 
                    (SELECT
                        usr.user_id,
                        usr.user_name,
                        ppf.first_name,
                        ppf.middle_names middle_name,
                        ppf.last_name,
                        ppf.attribute2 division,
                        ppf.attribute3 department,
                        ppf.attribute4 section,
                        usr.email_address email,
                        NULL customer_id,
                        1 source_id
                    FROM fnd_user usr 
                    LEFT JOIN per_all_people_f ppf
                    ON usr.employee_id = ppf.person_id
                    WHERE usr.user_name = :user_name
                    AND usr.end_date IS NULL
                    AND IPC_DECRYPT_ORA_USR_PWD(usr.encrypted_user_password) = :password
                    UNION
                    SELECT u.user_id,
                        u.user_name,
                        ud.first_name,
                        ud.middle_name,
                        ud.last_name,
                        ud.division,
                        ud.department,
                        ud.section,
                        ud.email,
                        u.customer_id,
                        2 source_id
                    FROM 
                    ipc_portal.users u
                    LEFT JOIN ipc_portal.user_details ud 
                    ON u.user_id = ud.user_id
                    WHERE u.status_id = 1 
                    AND ud.status_id = 1
                    AND u.user_name = :user_name
                    AND u.passcode = :password) 
                tab
                LEFT JOIN ipc_portal.user_system_access usa
                ON tab.user_id = usa.user_id
                LEFT JOIN ipc_portal.system_user_types ut
                ON usa.user_type_id = ut.user_type_id
                LEFT JOIN ipc_portal.systems sys
                ON usa.system_id = sys.system_id
                WHERE 1 = 1
                AND sys.system_id = :system_id
            ', [
                'user_name' => $user_name,
                'password'  => $password,
                'system_id' => $system_id
            ]);

        return $query;
    }

    /**
     * Fetch User from Oracle or IPC Portal
     * 
     * @param int $user_id
     * @return array \Illuminate\Http\Response
     */
    public function get($user_id)
    {
        $query = DB::connection('oracle')
            ->select('
                SELECT 
                    tab.user_id,
                    tab.user_name,
                    tab.first_name,
                    tab.middle_name,
                    tab.last_name,
                    tab.division,
                    tab.department,
                    tab.section,
                    tab.customer_id,
                    tab.source_id,
                    tab.email,
                    ut.user_type_name
                FROM 
                    (SELECT
                        usr.user_id,
                        usr.user_name,
                        ppf.first_name,
                        ppf.middle_names middle_name,
                        ppf.last_name,
                        ppf.attribute2 division,
                        ppf.attribute3 department,
                        ppf.attribute4 section,
                        usr.email_address email,
                        NULL customer_id,
                        1 source_id
                    FROM fnd_user usr 
                    LEFT JOIN per_all_people_f ppf
                    ON usr.employee_id = ppf.person_id
                    WHERE usr.user_id = :user_id
                    AND usr.end_date IS NULL
                    UNION
                    SELECT 
                        u.user_id,
                        u.user_name,
                        ud.first_name,
                        ud.middle_name,
                        ud.last_name,
                        ud.division,
                        ud.department,
                        ud.section,
                        ud.email,
                        u.customer_id,
                        2 source_id
                    FROM 
                    ipc_portal.users u
                    LEFT JOIN ipc_portal.user_details ud 
                    ON u.user_id = ud.user_id
                    WHERE u.status_id = 1 
                    AND ud.status_id = 1
                    AND ud.user_id = :user_id) 
                tab
                LEFT JOIN ipc_portal.user_system_access usa
                ON tab.user_id = usa.user_id
                LEFT JOIN ipc_portal.system_user_types ut
                ON usa.user_type_id = ut.user_type_id
                LEFT JOIN ipc_portal.systems sys
                ON usa.system_id = sys.system_id
                WHERE 1 = 1
                AND sys.system_id = :system_id
            ', [
                'user_id' => $user_id,
                'system_id' => config('app.system_id')
            ]);

        return $query;
    }
}
