<?php
$array = $this->print_preview[0];
$array1 = $this->print_table[0];
//require ('connect.php');
require_once('./public/mpdf/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ini_set('memory_limit', '1024M');
ob_start();
$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$space2 = '&nbsp;&nbsp;';
?>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
    <style type="text/css">
        <!--
        @page rotated { size: landscape; }
        .style1 {
            font-family: "TH SarabunPSK";
            font-size: 18px;
            font-weight: bold;
        }
        .style2 {
            font-family: "TH SarabunPSK";
            font-size: 16px;
            font-weight: bold;
        }
        .style3 {
            font-family: "TH SarabunPSK";
            font-size: 20px;

        }
        .style5 {cursor: hand; font-weight: normal; color: #000000;}
        .style9 {font-family: Tahoma; font-size: 12px; }
        .style11 {font-size: 12px}
        .style13 {font-size: 9px}
        .style16 {font-size: 9px; font-weight: bold; }
        .style17 {font-size: 12px; font-weight: bold; }
        
        footer {
            clear: both;
    position: relative;
    z-index: 10;
    height: 3em;
    margin-top: -3em;
         }

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
                            <td width="291" align="center"><span class="style3"><b><h3>ใบเบิก-จ่ายอุปกรณ์ ของหน่วยงานจ่ายกลาง</h1></b></span></td>
                        </tr>
                        <tr>
                            <td height="27" align="center"><span class="style1"><b>วันที่ <?php echo $array["supply_date"]; ?> เวร <?php echo ($array['supply_shift'] == "morning") ? "เช้า" : "บ่าย"; ?></span></td>
                        </tr>
                    </table>
                    <hr>
                        <table width="704" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="291" height="27" align="left"><span class="style2">ส่งอุปกรณ์ ::  <b><?php echo $array["supply_consignee_name"] . $space . '</b> ' . ($array["supply_consignee_date"] ? 'วันที่ :: <b>' . $array["supply_consignee_date"] . $space . '</b> เวลา :: <b>' . $array["supply_consignee_time"] . '</b> น.' : '...............................  วันที่ ...............................  เวลา ............................... น.') ?> </span></td>
                            </tr>
                            <tr>
                                <td width="291" height="27"  align="left"><span class="style2">รับอุปกรณ์ ::  <b><?php echo $array["supply_consignor_name"] . $space . '</b> ' . ($array["supply_consignor_date"] ? 'วันที่ :: <b>' . $array["supply_consignor_date"] . $space . '</b> เวลา :: <b>' . $array["supply_consignor_time"] . '</b> น.' : '...............................  วันที่ ...............................  เวลา ............................... น.') ?> </span></td>
                            </tr>
                            <tr>
                                <td width="291" height="27" align="left"><span class="style2">จ่ายอุปกรณ์ ::  <b><?php echo $array["supply_divider_name"] . $space . '</b> ' . ($array["supply_divider_date"] ? 'วันที่ :: <b>' . $array["supply_divider_date"] . $space . '</b> เวลา :: <b>' . $array["supply_divider_time"] . '</b> น.' : '...............................  วันที่ ...............................  เวลา ............................... น.') ?> </span></td>
                            </tr>
                            <tr>
                                <td width="291" height="27" align="left"><span class="style2">รับอุปกรณ์ปราศจากเชื้อ ::  <b><?php echo $array["supply_consignor2_name"] . $space . '</b> ' . ($array["supply_consignor2_date"] ? 'วันที่ :: <b>' . $array["supply_consignor2_date"] . $space . '</b> เวลา :: <b>' . $array["supply_consignor2_time"] . '</b> น.' : '...............................  วันที่ ...............................  เวลา ............................... น.') ?> </span></td>
                            </tr>
                        </table> 
                        <hr>
                            <table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="style1">
                                <thead>
                                    <tr bgcolor="#66CCFF">
                                        <th align="center" width="50px" height="30px"><strong>#</strong></td>
                                            <th align="center" width="300px"><strong>รายการอุปกรณ์</strong></td>
                                                <th align="center" width="50px"><strong>ส่ง</strong></th>
                                                    <th align="center" width="50px"><strong>รับ</strong></th>
                                                        <th align="center" width="50px"><strong>จ่าย</strong></th>
                                                            <th align="center" width="50px"><strong>ค้าง</strong></th>
                                                                <th align="center" width="100px"><strong>ประเภทเบิก</strong></th>
                                                                    <th align="center" width="150px"><strong>หมายเหตุ</strong></th>
                                                                        </tr>
                                                                        </thead>
                                                                        <?php
                                                                        $num = 1;
                                                                        foreach ($array1 as $row) {
                                                                            ?>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" height="25px"><?php echo $num; ?></td>
                                                                                    <td align="left" class="style3"><?php echo $space2 . $row['items_name']; ?></td>
                                                                                    <td align="center" class="style3"><?php echo $row['supply_items_send']; ?></td>
                                                                                    <td align="center" class="style3"><?php echo $row['supply_items_receive']; ?></td>
                                                                                    <td align="center" class="style3"><?php echo $row['supply_items_divide']; ?></td>
                                                                                    <td align="center" class="style3"><?php echo $row['supply_items_remain']; ?></td>
                                                                                    <td align="center" class="style3"><?php echo ($row['supply_items_order_type'] == "Add New Items") ? "Add" : ''; ?></td>
                                                                                    <td align="center" class="style3"><?php #echo $array['supply_consignor2_name'];   ?></td>
                                                                                </tr>
                                                                            </tbody> <?php $num++;
                                                                    }
                                                                        ?> 
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
                                                                        $mpdf->SetHTMLFooter('
                                                                                <table width="100%" style="vertical-align: bottom; font-family: TH SarabunPSK; font-size: 10pt; color: #000000; font-weight: normal;">
                                                                                    <tr>
                                                                                        <td width="33%" style="font-weight: normal; text-align: center;">................................................</td>
                                                                                        <td width="33%" style="text-align: center; ">................................................</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="33%" style="font-weight: normal; text-align: center;">(................................................)</td>
                                                                                        <td width="33%" style="text-align: center; ">(................................................)</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="33%" style="font-weight: normal; text-align: center; font-weight: bold;">ชื่อผู้รับ</td>
                                                                                        <td width="33%" style="text-align: center; font-weight: bold;">ชื่อผู้จ่าย</td>
                                                                                    </tr>
                                                                                </table>
                                                                                ');
                                                                        $mpdf->WriteHTML($html, 2);
                                                                        $mpdf->Output("SupplyCenter.pdf", 'I'); // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสดง
                                                                        ?>     
                                                                        <!--ดาวโหลดรายงานในรูปแบบ PDF <a href="MyPDF/MyPDF.pdf">คลิกที่นี้</a>-->