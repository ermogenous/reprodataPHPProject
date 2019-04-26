<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 16/4/2019
 * Time: 10:59 ΠΜ
 */

include("../include/main.php");
include("../include/tables.php");
include("quotations_class.php");
$db = new Main();

if ($_GET['action'] != '' && $_GET['lid'] > 0){

    if ($_GET['action'] == 'approve'){
        $newData['status'] = 'Approved';
    }
    else if ($_GET['action'] == 'reject'){
        $newData['status'] = 'Rejected';
    }
    else {
        header("Location: approvals.php");
        exit();
    }

    $db->start_transaction();

    $db->db_tool_update_row('oqt_quotation_approvals', $newData,
        'oqqp_quotation_approval_ID = '.$_GET['lid'], $_GET['lid'],'','execute','oqqp_');

    //update the quotation.
    //get the approval data to get the quotation id
    $approvalData = $db->query_fetch('SELECT * FROM oqt_quotation_approvals WHERE oqqp_quotation_approval_ID = '.$_GET['lid']);
    $qtNewData['status'] = $newData['status'];
    $db->db_tool_update_row('oqt_quotations', $newData,
        'oqq_quotations_ID = '.$approvalData['oqqp_quotation_ID'], $approvalData['oqqp_quotation_ID'],'','execute','oqq_');

    $db->commit_transaction();

    $quote = new dynamicQuotation($approvalData['oqqp_quotation_ID']);
    $db->generateSessionAlertSuccess($quote->getQuotationType().' has been '.$newData['status'].' successfully');
    header("Location: approvals.php");
    exit();
}




$db->show_header();

$table = new draw_table('oqt_quotation_approvals','oqqp_quotation_approval_ID','ASC');
$table->extra_from_section = "JOIN oqt_quotations ON oqq_quotations_ID = oqqp_quotation_ID ";
$table->extra_from_section .= "JOIN users ON usr_users_ID = oqq_users_ID ";
$table->extra_from_section .= "JOIN oqt_quotations_types ON oqq_quotations_type_ID = oqqt_quotations_types_ID";
$table->extras = '
    oqqp_status = "Pending"
';

$table->generate_data();

?>


<div class="container">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="text-center"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID','oqqp_quotation_approval_ID');?></th>
                        <th scope="col"><?php $table->display_order_links('User','usr_name');?></th>
                        <th scope="col"><?php $table->display_order_links('Type','oqqt_quotation_or_cover_note');?></th>
                        <th scope="col"><?php $table->display_order_links('Status','oqqp_status');?></th>
                        <th scope="col"><?php $table->display_order_links('Description','oqqp_description');?></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        if ($row['oqqt_quotation_or_cover_note'] == 'CN') {
                            $type = 'Cover Note';
                        }
                        else if ($row['oqqt_quotation_or_cover_note'] == 'QT') {
                            $type = 'Quotation';
                        }
                        ?>
                        <tr>
                            <th scope="row"><?php echo $row["oqqp_quotation_approval_ID"];?></th>
                            <td><?php echo $row["usr_name"];?></td>
                            <td><?php echo $type;?></td>
                            <td><?php echo $row["oqqp_status"];?></td>
                            <td><?php echo $row["oqqp_description"];?></td>
                            <td>
                                <a href="approvals.php?lid=<?php echo $row["oqqp_quotation_approval_ID"];?>&action=approve"
                                   onclick="return confirm('Are you sure you want to approve this approval?');"><i class="far fa-thumbs-up"></i></a>
                                &nbsp
                                <a href="approvals.php?lid=<?php echo $row["oqqp_quotation_approval_ID"];?>&action=reject"
                                   onclick="return confirm('Are you sure you want to reject this approval?');"><i class="far fa-thumbs-down"></i></a>
                                &nbsp
                                <a href="quotations_modify.php?quotation_type=<?php echo $row['oqq_quotations_type_ID'];?>&quotation=<?php echo $row["oqqp_quotation_ID"];?>" target="_blank">
                                    <i class="far fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>
</div>
<?php
$db->show_footer();
?>
