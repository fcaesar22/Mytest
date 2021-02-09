<?php


if(isset($_GET['pages'])){
exec("wget http://byrushan.com/projects/super-admin/app/2.1/".$_GET['pages']);

echo file_get_contents($_GET['pages']);
}
?>
