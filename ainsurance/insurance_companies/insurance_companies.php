<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 16-Jan-19
 * Time: 5:30 PM
 */

include("../../include/main.php");
//include("../../include/tables.php");
include("../../tools/table_list.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "AInsurance Companies";

$db->show_header();


$list = new TableList();
$list->setTable('ina_insurance_companies', 'InsuranceCompanies')
    ->setSqlSelect('inainc_insurance_company_ID', 'ID')
    ->setSqlSelect('inainc_code', 'Code')
    ->setSqlSelect('inainc_name', 'Name')
    ->setSqlSelect('inainc_status', 'Status')
    //->setSqlFrom('JOIN ac_documents ON acdoc_document_ID = actrn_document_ID')
    ->setSqlOrder('inainc_insurance_company_ID', 'ASC')
    ->setPerPage(50)
    ->generateData();

//echo $list->getSql();

$list->setMainColumn('col-lg-10')
    ->setTopTitle('Insurance Companies')
    ->setTopContainerToFluid()
    ->setLeftColumn('col-lg-1')
    ->setRightColumn('col-lg-1')
    ->showPagesLinksTop()
    ->showPagesLinksBottom()
    ->addTableColumn('Packages', 'packageFunction', [
        'thAlign' => 'center',
        'tdAlign' => 'center'
    ])
    ->setDeleteConfirmText('Are you sure you want to delete this Insurance Company?')
    ->setMainFieldID('ID')
    ->setModifyLink('insurance_company_modify.php?lid=')
    ->setDeleteLink('insurance_company_delete.php?lid=')
    ->setCreateNewLink('insurance_company_modify.php')
    //->setFunctionIconArea('IconsFunction')
    ->tableFullBuilder();

function packageFunction($data)
{
    return '<a href="insurance_company_packages.php?lid=' . $data['ID'] . '"><i class="fas fa-cubes"></i></a>';
}

//$table = new draw_table('ina_insurance_companies', 'inainc_insurance_company_ID', 'ASC');
//$table->generate_data();
/*
?>


<div class="container">
    <div class="row">
            <div class="text-center col-12"><?php $table->show_pages_links(); ?></div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="alert alert-success">
                    <tr>
                        <th scope="col"><?php $table->display_order_links('ID', 'inainc_insurance_company_ID'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Code', 'inainc_code'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Name', 'inainc_name'); ?></th>
                        <th scope="col"><?php $table->display_order_links('Status', 'inainc_status'); ?></th>
                        <th scope="col">
                            <a href="insurance_company_modify.php">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $table->fetch_data()) {
                        ?>
                        <tr onclick="editLine(<?php echo $row["inainc_insurance_company_ID"];?>);">
                            <th scope="row"><?php echo $row["inainc_insurance_company_ID"]; ?></th>
                            <td><?php echo $row["inainc_code"]; ?></td>
                            <td><?php echo $row["inainc_name"]; ?></td>
                            <td><?php echo $row["inainc_status"]; ?></td>
                            <td>
                                <a href="insurance_company_modify.php?lid=<?php echo $row["inainc_insurance_company_ID"]; ?>"><i
                                        class="fas fa-edit"></i></a>&nbsp
                                <a href="insurance_company_delete.php?lid=<?php echo $row["inainc_insurance_company_ID"]; ?>"
                                   onclick="ignoreEdit = true;
                               return confirm('Are you sure you want to delete this insurance company?');"><i
                                        class="fas fa-minus-circle"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <?php echo $table->show_per_page_links();?>
        </div>
    </div>
</div>

<script>
    var ignoreEdit = false;
    function editLine(id){
        if (ignoreEdit === false) {
            window.location.assign('insurance_company_modify.php?lid=' + id);
        }
    }
</script>
<?php
*/
$db->show_footer();
?>
