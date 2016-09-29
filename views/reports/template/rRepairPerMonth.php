<!--<table class="table table-striped table-bordered table-condensed" border="1" id="table_report_data">-->
    <thead>
        <tr>
            <th class="text-center"><?= $_POST['report-title']; ?></th>
            <th class="text-center">ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
        </tr>
        <tr>
            <th class="text-center">รายการซ่อม</th>
            <th class="text-center">จำนวนครั้ง</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (sizeof($this->arrReport) > 0) {
            foreach ($this->arrReport as $val) {
                echo '<tr>';
                echo "<td>{$val['jobs_name']}</td>";
                echo '<td class="text-right">' . number_format($val['countRecieve']) . '</td>';
                echo '</tr>';
                $countRecieve += $val['countRecieve'];
            }

            echo '<tr class="text-right">';
            echo '<td>รวม</td>';
            echo '<td>' . number_format($countRecieve) . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
<!--</table>-->
