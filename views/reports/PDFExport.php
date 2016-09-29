<?php

ob_start();
require_once('./public/mpdf/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
$mpdf = new mPDF('th', 'A4', '0', 'THSaraban'); //ถ้าต้องการแนวนอนเท่ากับ A4-L
$mpdf->SetAutoFont();
$mpdf->SetDisplayMode('fullpage');
//$mpdf->shrink_tables_to_fit = 1;
$mpdf->WriteHTML('<table border=1 width="100%" style="border:1px solid black; border-collapse:collapse;">' . $_POST['tempTable'] . '</table>');

$mpdf->Output("{$_POST['report-title']}.pdf", 'I'); // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสดง

exit;
?>