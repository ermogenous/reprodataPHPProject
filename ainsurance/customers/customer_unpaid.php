<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/6/2019
 * Time: 4:38 ΜΜ
 */

include("../../include/main.php");
include("../../include/tables.php");
//include('insurance_balance_class.php');
include("../../tools/table_list.php");
$db = new Main();
$db->admin_title = "AInsurance Customers Unpaid Installments";

$db->show_empty_header();

$list = new TableList();
$list->setTable('ina_policy_installments', 'CustomerInsuranceUnpaidInstallments')
    ->setSqlFrom('JOIN ina_policies ON inapol_policy_ID = inapi_policy_ID')
    ->setSqlSelect('inapi_policy_installments_ID', 'ID')
    ->setSqlSelect('inapol_policy_number', 'Policy')
    ->setSqlSelect('inapi_document_date', 'Date')
    ->setSqlSelect('(inapi_amount - inapi_paid_amount)', 'Unpaid')
    ->setSqlWhere('inapol_customer_ID = '.$_GET['cid'])
    ->setSqlWhere("AND inapi_paid_status IN ('UnPaid','Partial')")
    //->setSqlFrom('JOIN ac_documents ON acdoc_document_ID = actrn_document_ID')
    ->setSqlOrder('inapi_policy_installments_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('UnPaid Installments')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->setMainFieldID('ID')
    ->setCreateNewLink(false)
    ->setModifyLink('../policy_modify.php?lid=','_blank')
    ->setDisableDeleteICon()
    //->setFunctionIconArea('IconsFunction')
    ->tableFullBuilder();

$db->show_empty_footer();



/*

if ($_GET['cid'] > 0) {

    $table = new draw_table('ina_policy_installments', 'inapi_document_date', 'ASC');
    $table->extra_from_section = ' JOIN ina_policies ON inapol_policy_ID = inapi_policy_ID';
    $table->extras = 'inapol_customer_ID = ' . $_GET['cid']." AND inapi_paid_status IN ('UnPaid','Partial')";
    $table->generate_data();

    $db->show_empty_header();
    */?><!--

    <div class="container">

        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">

                <div class="text-center"><?php /*$table->show_pages_links(); */?></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr class="alert alert-success">
                            <th scope="col"><?php /*$table->display_order_links('ID', 'inapi_policy_installments_ID'); */?></th>
                            <th scope="col"><?php /*$table->display_order_links('Policy', 'cst_name'); */?></th>
                            <th scope="col"><?php /*$table->display_order_links('Due Date', 'inapi_document_date'); */?></th>
                            <th scope="col"><?php /*$table->display_order_links('Unpaid', '(inapi_amount - inapi_paid_amount)'); */?></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
/*                        $totalRows = 0;
                        while ($row = $table->fetch_data()) {
                            $totalRows++;
                            */?>
                            <tr onclick="editLine(<?php /*echo $row["inapol_policy_ID"]; */?>);">
                                <th scope="row"><?php /*echo $row["inapi_policy_installments_ID"]; */?></th>
                                <td><?php /*echo $row["inapol_policy_number"]; */?></td>
                                <td><?php /*echo $db->convert_date_format($row["inapi_document_date"], 'yyyy-mm-dd', 'dd/mm/yyyy'); */?></td>
                                <td><?php /*echo $row["inapi_amount"] - $row["inapi_paid_amount"]; */?></td>
                                <td>
                                    <a href="#"><i class="fas fa-eye" title="Open policy"></i></a>
                                </td>
                            </tr>
                            <?php
/*                        }
                        */?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
    <script>

        var ignoreEdit = false;

        function editLine(id) {
            if (ignoreEdit === false) {
                window.top.location.href = '../policy_modify.php?lid=' + id;
            }
        }

        let totalRows = <?php /*echo $totalRows;*/?>;
        let totalPx = 300 + (totalRows * 30);
        $('#frmCustomerUnpaidTab', window.parent.document).height(totalPx + 'px');
    </script>
    --><?php
/*    $db->show_empty_footer();
}*/
?>
