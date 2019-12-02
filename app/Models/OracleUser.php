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
                    ut.user_type_name,
                    ut.user_type_id
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

    public function get_users(){
        $sql = "SELECT usr.user_id,
                        usa.access_id,
                        usr.first_name,
                        usr.middle_name,
                        usr.last_name,
                        usr.customer_name dealer_name,
                        usr.account_name dealer_account,
                        sut.user_type_name,
                        st.status_name,
                        usa.user_type_id,
                        usr.user_source_id,
                        usr.customer_id,
                        max(login_date) last_login
                FROM ipc_dms.ipc_portal_users_v usr
                    LEFT JOIN ipc_portal.user_system_access usa
                        ON usr.user_id = usa.user_id
                        AND usr.user_source_id = usa.user_source_id
                    LEFT JOIN ipc_portal.system_user_types sut
                        ON sut.user_type_id = usa.user_type_id
                    LEFT JOIN ipc_portal.status st
                        ON st.status_id = usr.status_id
                    LEFT JOIN ipc_portal.user_logs ul
                        ON ul.user_id = usr.user_id
                        AND ul.source_id = usr.user_source_id
                WHERE usa.system_id = 6
                    AND usa.status_id = 1
                GROUP BY
                        usr.user_id,
                        usa.access_id,
                        usr.first_name,
                        usr.middle_name,
                        usr.last_name,
                        usr.customer_name,
                        usr.account_name,
                        sut.user_type_name,
                        st.status_name,
                        usa.user_type_id,
                        usr.user_source_id,
                        usr.customer_id";
        $query = DB::select($sql);
        return $query;
    }

    public function get_approver($user_id, $user_source_id){
        $sql = "SELECT fa.approver_id,
                        usr.first_name || ' ' || usr.last_name name,
                        fa.user_type,
                        fa.requestor_source_id,
                        fa.requestor_user_id,
                        fa.hierarchy,
                        fa.approver_user_id,
                        fa.approver_source_id,
                        fa.status_id,
                        CASE WHEN fa.status_id = 1 THEN 'true' ELSE 'false' end status
                FROM ipc_dms.fs_approvers fa 
                    LEFT JOIN ipc_dms.ipc_portal_users_v usr
                        ON usr.user_id = fa.approver_user_id
                        AND usr.user_source_id = fa.approver_source_id
                WHERE 1 = 1
                    AND fa.requestor_user_id = :user_id
                    AND fa.requestor_source_id = :source_id
                ORDER BY fa.hierarchy ASC";
        $params = [
            'user_id'   => $user_id,
            'source_id' => $user_source_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    public function get_dlr_managers($customer_id){
        $sql = "SELECT usr.user_id,
                        usa.access_id,
                        usr.first_name,
                        usr.middle_name,
                        usr.last_name,
                        usr.customer_name dealer_name,
                        usr.account_name dealer_account,
                        sut.user_type_name,
                        st.status_name,
                        usr.user_source_id
                FROM ipc_dms.ipc_portal_users_v usr
                    LEFT JOIN ipc_portal.user_system_access usa
                        ON usr.user_id = usa.user_id
                        AND usr.user_source_id = usa.user_source_id
                    LEFT JOIN ipc_portal.system_user_types sut
                        ON sut.user_type_id = usa.user_type_id
                    LEFT JOIN ipc_portal.status st
                        ON st.status_id = usr.status_id
                WHERE usa.system_id = 6
                    AND usa.status_id = 1
                    AND sut.user_type_id = 31
                    AND usr.customer_id = :customer_id";

        $params = [
            'customer_id' => $customer_id
        ];

        $query = DB::select($sql,$params);
        return $query;
    }

    /**
     * Fetch User from Oracle or IPC Portal
     * 
     * @param int $user_id
     * @return array \Illuminate\Http\Response
     */
    public function get_user_details($user_id,$source_id)
    {
        $sql = "SELECT 
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
                    tab.name_prefix
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
                        1 source_id,
                        ppf.title name_prefix
                        
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
                        2 source_id,
                        ud.name_prefix
                    FROM ipc_portal.users u
                    LEFT JOIN ipc_portal.user_details ud 
                        ON u.user_id = ud.user_id
                    WHERE u.status_id = 1 
                        AND ud.status_id = 1
                        AND ud.user_id = :user_id) tab
                WHERE source_id = :source_id";
        $query = DB::connection('oracle')
            ->select($sql, [
                'user_id' => $user_id,
                'source_id' => $source_id
            ]);

        return $query[0];
    }

}
