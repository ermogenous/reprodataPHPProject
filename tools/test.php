<?php
/**
 * Created by PhpStorm.
 * User: micac
 * Date: 27/11/2019
 * Time: 11:46 ΠΜ
 */

//phpinfo();
print_r(scandir('C://xampp/temporary_files'));
?>
<form action="" method="post" enctype="multipart/form-data">
    <label for="file">Filename:</label>
    <input type="file" name="file" id="file" />
    <br />
    <input type="submit" name="submit" value="Submit" />
</form>
