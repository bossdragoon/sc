<?php

$array = $this->print_preview[0];
$array1 = $this->print_table[0];
//require ('connect.php');
require_once('./public/mpdf/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ini_set('memory_limit', '1024M');
ob_start();
?>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
    <style type="text/css">
        <!--
        @page rotated { size: landscape; }
        .style1 {
            font-family: "TH SarabunPSK";
            font-size: 18pt;
            font-weight: bold;
        }
        .style2 {
            font-family: "TH SarabunPSK";
            font-size: 16pt;
            font-weight: bold;
        }
        .style3 {
            font-family: "TH SarabunPSK";
            font-size: 16pt;

        }
        .style5 {cursor: hand; font-weight: normal; color: #000000;}
        .style9 {font-family: Tahoma; font-size: 12px; }
        .style11 {font-size: 12px}
        .style13 {font-size: 9px}
        .style16 {font-size: 9px; font-weight: bold; }
        .style17 {font-size: 12px; font-weight: bold; }
        -->
    </style>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <html>
            <head>
                <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
            </head>
            <body>
                <div class=Section2 >
                    <table width="704" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="291" align="center"><span class="style1"><b>ใบเบิก-จ่ายอุปกรณ์ ของหน่วยงานจ่ายกลาง</span></td>
                        </tr>
                        <tr>
                            <td height="27" align="center"><span class="style1"><b>วันที่ <?php echo $array["supply_date"]; ?> เวร <?php echo ($array['supply_shift'] == "morning") ? "เช้า" : "บ่าย"; ?></span></td>
                        </tr>
                    </table>
                    <hr>
                    <table width="704" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="291" align="left"><span class="style2">ส่งอุปกรณ์ <?php echo $array["supply_consignee_date"].' '.$array["supply_consignee_time"]; ?> วัน/เวลา</span></td>
                            <td width="291" align="right"><span class="style2">รับอุปกรณ์ <?php echo $array["supply_consignor_date"].' '.$array["supply_consignor_time"]; ?> วัน/เวลา</span></td>
                        </tr>
                        <tr>
                            <td height="27" align="left"><span class="style2">จ่ายอุปกรณ์ <?php echo $array["supply_divider_date"].' '.$array["supply_divider_time"]; ?> วัน/เวลา</span></td>
                            <td height="27" align="right"><span class="style2">รับอุปกรณ์ปราศจากเชื้อ <?php echo $array["supply_consignor2_date"].' '.$array["supply_consignor2_time"]; ?> วัน/เวลา</span></td>
                        </tr>
                    </table> 
                    <hr>
                    <table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="style1">
                        <thead>
                            <tr bgcolor="#66CCFF">
                                <th align="center" ><strong>#</strong></td>
                                <th align="center" ><strong>รายการอุปกรณ์</strong></td>
                                <th align="center" ><strong>ส่ง</strong></td>
                                <th align="center" ><strong>รับ</strong></td>
                                <th align="center" ><strong>จ่าย</strong></td>
                                <th align="center" ><strong>ค้าง</strong></td>
                                <th align="center" ><strong>ประเภทเบิก</strong></td>
                                <th align="center" ><strong>หมายเหตุ</strong></td>
                            </tr>
                        </thead>
                        <?php  $num=1;  
                               foreach ($array1 as $row) 
                                    { ?>
                        <tbody>
                            <tr>
                                <td align="center"><?php echo $num; ?></td>
                                <td align="left" class="style3"><?php echo $row['items_name']; ?></td>
                                <td align="center" class="style3"><?php echo $row['supply_items_send']; ?></td>
                                <td align="center" class="style3"><?php echo $row['supply_items_receive']; ?></td>
                                <td align="center" class="style3"><?php echo $row['supply_items_divide']; ?></td>
                                <td align="center" class="style3"><?php echo $row['supply_items_remain']; ?></td>
                                <td align="center" class="style3"><?php echo ($row['supply_items_order_type'] == "Add New Items") ? "Add New Items" : ''; ?></td>
                                <td align="center" class="style3"><?php #echo $array['supply_consignor2_name']; ?></td>
                            </tr>
                        </tbody> <?php $num++; }?> 
<!--                            <tr> 
                                <td></td>
                                <td align="right" rowspan="2">รวม</td>
                                <td align="center" class="style3"><?php echo ($row['supply_items_send']); ?></td>
                                <td align="center" class="style3"><?php echo ($row['supply_items_receive']); ?></td>
                                <td align="center" class="style3"><?php echo ($row['supply_items_divide']); ?></td>
                                <td align="center" class="style3"><?php echo ($row['supply_items_remain']); ?></td>
                            </tr>-->
                    </table>
                </div>
            </body>
        </html>
        <?Php
//        exit();
        $html = ob_get_contents();
        ob_end_clean();
        $mpdf = new mPDF('th', 'A4-P', '0', 'THSaraban');
        $mpdf->autoScriptToLang;    //        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->SetDisplayMode('fullpage');
//        $mpdf->shrink_tables_to_fit = 1;
//        $stylesheet = file_get_contents('style.css');
//        $mpdf->writeHTML($stylesheet, 1);
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output("abcdefg.pdf", 'I'); // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสดง
        ?>     
        <!--ดาวโหลดรายงานในรูปแบบ PDF <a href="MyPDF/MyPDF.pdf">คลิกที่นี้</a>-->