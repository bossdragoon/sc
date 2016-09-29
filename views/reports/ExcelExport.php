<?php
ob_start();

header("Content-Type: application/vnd.ms-excel");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename={$_POST['report-title']}.xls");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border=1>
<?php echo $_POST['tempTable']; ?>
</table>