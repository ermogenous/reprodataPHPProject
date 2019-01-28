<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 28/1/2019
 * Time: 10:51 ΠΜ
 */

include("../include/main.php");
include("../include/tables.php");

$db = new Main(1, 'UTF-8');
$db->admin_title = "Tickets placements";


if ($_POST['action'] == 'update'){
    print_r($_POST);
    //find the checkboxes and their ids
    foreach($_POST as $name => $value){
        if (substr($name,0,6) == 'check-' && $value == 1){
            $parts = explode('-', $name);

            //update the ticket
            $data['assigned_user_ID'] = $_POST['assignTo'];
            $db->db_tool_update_row('tickets', $data, 'tck_ticket_ID = '.$parts[1], $parts[1], '', 'execute', 'tck_');


        }


    }


}

$table = new draw_table('tickets', 'cde_value, tck_ticket_ID', 'ASC');
$table->extra_from_section = ' JOIN customers ON cst_customer_ID = tck_customer_ID';
$table->extra_from_section .= ' JOIN codes ON cde_code_ID = cst_city_code_ID';

$table->extras = "tck_assigned_user_ID = '-1' AND tck_status = 'Open'";


$table->generate_data();
$db->enable_jquery_ui();
$db->show_header();
?>

<div class="container">
    <form name="myForm" id="myForm" method="post" action="" onsubmit="">
        <div class="row">
            <div class="col-lg-12">
                <div class="row alert alert-success text-center">
                    <div class="col-12">
                        Tickets
                    </div>
                </div>


                <div class="text-center"><?php $table->show_pages_links(); ?></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr class="alert alert-success">
                            <th scope="col"><?php $table->display_order_links('ID', 'tck_ticket_ID'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Number', 'tck_ticket_number'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Customer', 'cst_name'); ?></th>
                            <th scope="col"><?php $table->display_order_links('Status', 'tck_status'); ?></th>
                            <th scope="col"><?php $table->display_order_links('City', 'cde_value'); ?></th>
                            <th scope="col" width="150">
                                <input type="checkbox" class="form-control" id="checkAll" name="checkAll" value="1"
                                       onclick="checkAllLines()">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = $table->fetch_data()) {
                            ?>
                            <tr class="tck<?php echo $row['tck_status']; ?>Color">
                                <th scope="row"><?php echo $row["tck_ticket_ID"]; ?></th>
                                <td><?php echo $row["tck_ticket_number"]; ?></td>
                                <td><?php echo $row["cst_name"]; ?></td>
                                <td><?php echo $row["tck_status"]; ?></td>
                                <td><?php echo $row["cde_value"]; ?></td>
                                <td>
                                    <input type="checkbox" class="form-control" value="1"
                                           id="check-<?php echo $row['tck_ticket_ID']; ?>"
                                           name="check-<?php echo $row['tck_ticket_ID']; ?>" onclick="verifyChecks();">
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="6" align="right">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-8 text-right">
                                            Assign To:
                                        </div>
                                        <div class="col-2">
                                            <select name="assignTo" id="assignTo" class="form-control"
                                                    onchange="verifyChecks();"
                                                    required>
                                                <option value="">Select User</option>
                                                <?php
                                                $result = $db->query("SELECT * FROM users WHERE usr_is_service = 1 OR usr_is_delivery = 1 ORDER BY usr_name ASC");
                                                while ($user = $db->fetch_assoc($result)) {
                                                    ?>
                                                    <option value="<?php echo $user['usr_users_ID']; ?>"><?php echo $user['usr_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <input type="submit" name="Submit" id="Submit"
                                                   value="Update"
                                                   class="btn btn-secondary"
                                                   onclick="return submitForm();" disabled>
                                            <input type="hidden" name="action" id="action" value="update">
                                        </div>
                                    </div>
                                </div>


                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </form>

</div>
<script>
    function checkAllLines(){
        $("form :input").each(function (index, element) {
            var id = $(this).attr("id"); // returns the object ID
            var value = $(this).val(); // returns the object value

            if ($('#checkAll').is(":checked")){
                if (id.substring(0,6) == 'check-'){
                    $('#' + id).prop("checked", true);
                }
            }
            else {
                if (id.substring(0,6) == 'check-'){
                    $('#' + id).prop("checked", false);
                }
            }

        });
        verifyChecks();
    }//check all

    //check if all are checked then set checkAll to check and vice versa
    function verifyChecks(){
        var totalChecked = 0;
        var totalUnChecked = 0;
        $("form :input").each(function (index, element) {
            var id = $(this).attr("id"); // returns the object ID
            var value = $(this).val(); // returns the object value

            if (id.substring(0,6) == 'check-'){
                if ( $('#' + id).is(':checked') ){
                    totalChecked++;
                }
                else {
                    totalUnChecked++;
                }
            }

        });

        if (totalChecked == 0){
            $('#checkAll').prop('checked',false);
        }
        else if (totalUnChecked == 0){
            $('#checkAll').prop('checked',true);
        }

        //enable disable submit
        let assignedUser = $('#assignTo').val();
        if (assignedUser == ''){
            assignedUser = 0;
        }
        if (totalChecked > 0 && assignedUser > 0){
            $('#Submit').prop("disabled", false);
        }
        else {
            $('#Submit').prop("disabled", true);
        }
    }


    function submitForm(){
        if (confirm('Are you sure you want to update this tickets?')){
            return true;
        }else {
            return false;
        }
    }
</script>
<?php
$db->show_footer();
?>
