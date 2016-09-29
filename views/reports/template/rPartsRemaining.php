<!--<table class="table table-striped table-bordered table-condensed" border="1" id="table_report_data">-->
    <thead>
        <tr>
            <th class="text-center" colspan=3><?= $_POST['report-title']; ?></th>
            <th class="text-center" colspan=6>ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
        </tr>
        <tr>
            <th class="text-center">เลขใบสั่งซื้อ</th>
            <th class="text-center">ประเภท</th>
            <th class="text-center">Serial</th>
            <th class="text-center">ราคา/หน่วย</th>
            <th class="text-center">จำนวนเต็ม</th>
            <th class="text-center">คงเหลือ</th>
            <th class="text-center">วันที่บันทึก</th>
            <th class="text-center">การเก็บ</th>
            <th class="text-center">หน่วยนับ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(sizeof($this->arrReport) > 0){
            foreach($this->arrReport as $val){
                echo '<tr>';
                echo "<td>{$val['store_lotno']}</td>";
                echo "<td>{$val['store_type_name']}</td>";
                echo "<td>{$val['serial_number']}</td>";
                echo "<td>{$val['store_unit_price']}</td>";
                echo "<td>{$val['store_max_count']}</td>";
                echo "<td>{$val['store_stock']}</td>";
                echo "<td>{$val['store_adddate']}</td>";
                echo "<td>{$val['store_type_keeping']}</td>";
                echo "<td>{$val['store_type_count']}</td>";
                echo '</tr>';
            }
        }
        ?>
    </tbody>
<!--</table>-->
