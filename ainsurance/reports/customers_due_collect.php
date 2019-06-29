<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/6/2019
 * Time: 5:41 ΜΜ
 */

/**
 * generates HTML table with unpaid installments order by collection date (inapi_document_date)
 * anything below as at is considered overdue
 * anything between asAtDate and upToDate is not due
 * @param $as_at_date -> dd/mm/yyyy
 * @param $upToDate -> show records only upto that date inclusive
 * @return $html
 */
function customers_due_collect($asAtDate, $upToDate = '')
{
    global $db, $main;
    include_once($main["local_url"] . "/ainsurance/policy_class.php");

    if ($upToDate == ''){
        $asAt = $asAtDate;
        $upToDate = $asAtDate;
    }
    else {
        $asAt = $upToDate;
    }

    $sql = "
        SELECT
        *,
        (inapol_premium + inapol_fees + inapol_stamps)as clo_total_premium,
        (SELECT 
          IF (inapit_type = 'Vehicles',group_concat(inapit_vh_registration),group_concat(distinct(inapit_type))) 
        FROM ina_policy_items WHERE inapit_policy_ID = inapol_policy_ID)as clo_item_list,
        IF (inapi_document_date <= '".$db->convert_date_format($asAtDate,'dd/mm/yyyy','yyyy-mm-dd')."',1,0)as clo_overdue
        FROM
        ina_policy_installments
        JOIN ina_policies ON inapol_policy_ID = inapi_policy_ID
        JOIN customers ON cst_customer_ID = inapol_customer_ID
        WHERE
        inapol_underwriter_ID " . Policy::getAgentWhereClauseSql()."
        AND inapi_paid_status IN ('UnPaid','Partial')
        AND inapi_document_date <= '".$db->convert_date_format($asAt,'dd/mm/yyyy','yyyy-mm-dd')."'
        ORDER BY inapi_document_date ASC
        ";
    $result = $db->query($sql);
    $html = '
    <div class="container">
    <div class="table-responsive">
    <table class="table table-hover" id="myTableList">
      <thead>
        <tr>
          <th scope="col" class="d-sm-table-cell">Name</th>
          <th scope="col" class="d-none d-md-table-cell">Policy</th>
          <th scope="col" class="d-none d-md-table-cell">Item</th>
          <th scope="col" class="d-none d-md-table-cell text-center">Total Premium</th>
          <th scope="col" class="d-sm-table-cell text-center">Due Date</th>
          <th scope="col" class="d-sm-table-cell text-center">Due Amount</th>
        </tr>
      </thead>
      <tbody>
  ';


    while ($row = $db->fetch_assoc($result)) {
        $html .= '
            <tr class="'.($row['clo_overdue'] == 1? "alert-danger": "").'"
            >
              <th class="d-sm-table-cell" scope="row">'.$row['cst_name'].' '.$row['cst_surname'].'</th>
              <td class="d-none d-md-table-cell">'.$row['inapol_policy_number'].'</td>
              <td class="d-none d-md-table-cell">'.$row['clo_item_list'].'</td>
              <td class="d-none d-md-table-cell text-center">'.$row['clo_total_premium'].'</td>
              <td class="d-sm-table-cell text-center">'.$db->convert_date_format($row['inapi_document_date'],'yyyy-mm-dd','dd/mm/yyyy').'</td>
              <td class="d-sm-table-cell text-center">'.($row['inapi_amount'] - $row['inapi_paid_amount']).'
              <input type="hidden" id="myLineID" name="myLineID" value="'.$row['inapol_policy_ID'].'">
              </td>
            </tr>
        ';
    }
    $html .= '
        </tbody>
    </table>
</div>
</div>
<script>
    var ignoreEdit = false;

    function editLine(id) {
        if (ignoreEdit === false) {
            window.location.assign("policy_modify.php?lid=" + id);
        }
        ignoreEdit = false;
    }

    $(document).ready(function() {
        $("#myTableList tr").click(function() {
            var href = $(this).find("input[id=myLineID]").val();
            if(href) {
                editLine(href);
            }
        });
    });
</script>
';
    return $html;
}