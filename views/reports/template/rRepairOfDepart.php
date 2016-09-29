<!--<table class="table table-striped table-bordered table-condensed" border="1" id="table_report_data">-->
    <thead>
        <tr>
            <th class="text-center" colspan=2><?= $_POST['report-title']; ?></th>
            <th class="text-center">ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
        </tr>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">หน่วยงาน</th>
            <th class="text-center">จำนวน</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (sizeof($this->arrReport) > 0) {
            $i = 1;
            foreach ($this->arrReport as $val) {
                echo '<tr class="text-center">';
                echo '<td>' . ($i++) . '</td>';
                echo "<td class='text-left'>{$val['depart_name']}</td>";
                echo "<td>{$val['sumService']}</td>";
                echo '</tr>';
            }
        }
        ?>
    </tbody>
<!--</table>-->
