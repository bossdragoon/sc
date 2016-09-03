<?php
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
                <div class=Section2>
                    <table width="704" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="291" align="center"><span class="style2">ใบเบิก-จ่ายอุปกรณ์ ของหน่วยงานจ่ายกลาง</span></td>
                        </tr>
                        <tr>
                            <td height="27" align="center"><span class="style2">วันที่ <?php echo $_POST['supply_date']; ?> เวลา <?php echo $_POST['this_terms']; ?></span></td>
                        </tr>
                    </table>
                    <table width="800" border="1" align="center" cellpadding="0" cellspacing="0" class="style1">
                        <tr bgcolor="#00CCFF">
                            <td width="420" align="center" rowspan="2"><strong>มาตราฐาน</strong></td>
                            <td height="24" align="center" colspan="5"><strong>คะแนนที่ประเมิณได้</strong></td>
                            <td width="80" align="center" rowspan="2"><strong>หมายเหตุ</strong></td>
                        </tr>
                        <tr bgcolor="#00CCFF">
                            <td width="60" align="center"><strong>ไม่ได้ทำ<br>(๐)</strong></td>
                            <td width="60" align="center"><strong>ปรับปรุง<br>(๑)</strong></td>
                            <td width="60" align="center"><strong>พอใช้<br>(๒)</strong></td>
                            <td width="60" align="center"><strong>ดี<br>(๓)</strong></td>
                            <td width="60" align="center"><strong>ดีมาก<br>(๔)</strong></td>
                        </tr>

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