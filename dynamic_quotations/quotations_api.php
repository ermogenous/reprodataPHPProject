<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 8/5/2019
 * Time: 2:03 ΜΜ
 */

include("../include/main.php");
$db = new Main(1);
$db->working_section = 'Quotations API';
$db->apiGetReadHeaders();

if ($_GET['section'] == 'quotations_search_autofill') {

    $sql = "SELECT 
              CONCAT(oqq_insureds_name, ' ', oqq_insureds_id) as value,
              CONCAT(oqq_insureds_name, ' ', oqq_insureds_id) as label,
              oqq_insureds_name as clo_name,
              oqq_insureds_id as clo_id,
              oqq_insureds_tel as clo_tel,
              oqq_insureds_mobile as clo_mobile,
              oqq_insureds_address as clo_address,
              oqq_insureds_email as clo_email,
              oqq_insureds_contact_person as clo_contact_person,
              oqq_insureds_postal_code as clo_postal_code
              FROM oqt_quotations 
              WHERE 
              (
                CONCAT(oqq_insureds_name, ' ', oqq_insureds_id) LIKE '%" . $_GET['term'] . "%'
			    OR CONCAT(oqq_insureds_tel, ' ', oqq_insureds_mobile) LIKE '%" . $_GET['term'] . "%'
			  )
			  AND 
			  oqq_users_ID = ".$db->user_data['usr_users_ID']."
			  GROUP BY
			  oqq_insureds_name,
              oqq_insureds_id,
              oqq_insureds_tel,
              oqq_insureds_mobile,
              oqq_insureds_address,
              oqq_insureds_email,
              oqq_insureds_contact_person,
              oqq_insureds_postal_code
              LIMIT 0,25";

    $result = $db->query($sql);
    while ($row = $db->fetch_assoc($result)) {
        $data[] = $row;
    }

    $db->update_log_file_custom($sql, 'Quotations API:quotations_search_autofill GET:'.print_r($_GET,true));
}
else {
    $db->update_log_file_custom('NONE', 'Quotations API:none GET:'.print_r($_GET,true));
}


echo json_encode($data);
exit();