<!--<table class="table table-striped table-bordered table-condensed" border="1">-->
    <thead>
        <tr>
            <th colspan=3 class="text-center"><?= $_POST['report-title']; ?></th>
            <th colspan=5 class="text-center">ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
        </tr>
        <tr>
            <th class="text-center">อุปกรณ์</th>
            <th class="text-center">จำนวน</th>
            <th class="text-center">หน่วยนับ</th>
            <th class="text-center">ราคา/หน่วย</th>
            <th class="text-center">Serial</th>
            <th class="text-center">ราคารวม</th>
            <th class="text-center">ผู้เบิก</th>
            <th class="text-center">วันที่เบิก</th>
        </tr>
    </thead>
    <tbody>
        <?php
//        st.store_type_name,pi.parts_qty,st.store_type_count,s.store_unit_price,s.serial_number,(pi.parts_qty * s.store_unit_price) as sum_price,
//      pi.parts_staff,pi.parts_date
        if(sizeof($this->arrReport) > 0){
            foreach($this->arrReport as $val){
                echo '<tr>';
                echo "<td>{$val['store_type_name']}</td>";
                echo "<td>{$val['parts_qty']}</td>";
                echo "<td>{$val['store_type_count']}</td>";
                echo "<td>{$val['store_unit_price']}</td>";
                echo "<td>{$val['serial_number']}</td>";
                echo "<td>{$val['sum_price']}</td>";
                echo "<td>{$val['person_name']}</td>";
                echo "<td>{$val['parts_date']}</td>";
                echo '</tr>';
            }
        }
        ?>
    </tbody>
<!--</table>-->
