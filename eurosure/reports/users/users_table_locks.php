<?php
/**
 * Created by PhpStorm
 * User: m.ermogenous
 * Date: 14/10/2021
 * Time: 8:57 π.μ.
 */

include("../../../include/main.php");
include("../../lib/odbccon.php");

$db = new Main(1);
$db->admin_title = "Eurosure - Synthesis Users Table Locks";

$db->show_header();

$sybase = new ODBCCON('SySystem');

$orderBy = 'sylck_tabl_name ASC';
if ($_GET['order'] != '') {
    $orderBy = $_GET['order'].' ASC';
}

$sql = "
SELECT syplocks.sylck_comp_code ,
syplocks.sylck_tabl_name ,
syplocks.sylck_tabl_serl ,
syplocks.sylck_tabl_lock ,
syplocks.sylck_user_idty ,
syplocks.sylck_computer_name
FROM
syplocks
LEFT OUTER JOIN sypusers ON syplocks.sylck_user_idty = sypusers.syus_user_idty,
sypcompa
WHERE
( syplocks.sylck_comp_code = sypcompa.syco_reco_code )
//and (:Arg_companies_restriction_on <> 'Y' or (:Arg_companies_restriction_on = 'Y'
//and ( syco_company_group = :arg_company_group)) )
ORDER BY
".$orderBy;
$result = $sybase->query($sql);
?>

<div class="container">
    <div class="row">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col"><a href="users_table_locks.php?order=sylck_comp_code">Company</a></th>
                <th scope="col"><a href="users_table_locks.php?order=sylck_tabl_name">Table</a></th>
                <th scope="col"><a href="users_table_locks.php?order=sylck_tabl_serl">Serial</a></th>
                <th scope="col"><a href="users_table_locks.php?order=sylck_user_idty">User</a></th>
                <th scope="col"><a href="users_table_locks.php?order=sylck_computer_name">Computer</a></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            while ($row = $sybase->fetch_assoc($result)){
                $i++;
            ?>
            <tr>
                <th scope="row"><?php echo $i;?></th>
                <td><?php echo $row['sylck_comp_code'];?></td>
                <td><?php echo $row['sylck_tabl_name'];?></td>
                <td><?php echo $row['sylck_tabl_serl'];?></td>
                <td><?php echo $row['sylck_user_idty'];?></td>
                <td><?php echo $row['sylck_computer_name'];?></td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>

    </div>
</div>

<?php
$db->show_footer();
?>
