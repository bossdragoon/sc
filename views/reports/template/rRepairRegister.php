<!--<table class="table table-striped table-bordered table-condensed" border="1" id="table_report_data">-->
    <thead>
        <tr>
            <th class="text-center" colspan=3><?= $_POST['report-title']; ?></th>
            <th class="text-center" colspan=4>ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
        </tr>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">วันที่ส่งซ่อม</th>
            <th class="text-center">ชื่อผู้ส่งซ่อม</th>
            <th class="text-center">หน่วยงาน</th>
            <th class="text-center">ประเภท</th>
            <th class="text-center">อาการเสีย</th>
            <th class="text-center">อาการอื่นๆ</th>
        </tr>
    </thead>
    <tbody>
        <?php
//        var_dump($this->arrReport);
        if(sizeof($this->arrReport) > 0){
            foreach($this->arrReport as $val){
                echo '<tr>';
                echo "<td>{$val['service_id']}</td>";
                echo "<td>{$val['service_regdate']}</td>";
                echo "<td>{$val['person_name']}</td>";
                echo "<td>{$val['depart_name']}</td>";
                echo "<td>{$val['service_type']}</td>";
                echo "<td>{$val['sym_name']}</td>";
                echo "<td>{$val['service_symptom_text']}</td>";
                echo '</tr>';
            }
        }
        ?>
    </tbody>
<!--</table>-->
