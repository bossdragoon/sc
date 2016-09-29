<!--<table class="table table-striped table-bordered table-condensed" border="1" id="table_report_data">-->
    <thead>
        <tr>
            <th class="text-center" colspan=2><?= $_POST['report-title']; ?></th>
            <th class="text-center">ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
        </tr>
        <tr>
            <th class="text-center">ชื่อหน่วยงาน</th>
            <th class="text-center">รายการซ่อม</th>
            <th class="text-center">จำนวนครั้ง</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (sizeof($this->arrReport) > 0) {
            $header = $sum = '';

            foreach ($this->arrReport as $key => $val) {
                $sum[$val['depart_id']] += $val['countRecieve'];
            }

            foreach ($this->arrReport as $key => $val) {
                if ($header <> $val['depart_id']) {
                    echo '<tr style="background-color: #7bbdd9">';
                    echo "<td colspan='2'>{$val['depart_name']}</td>";
                    echo "<td class='text-right'>{$sum[$val['depart_id']]}</td>";
                    echo '</tr>';
                    $header = $val['depart_id'];
                }

                echo '<tr>';
                echo '<td></td>';
                echo "<td>{$val['jobs_name']}</td>";
                echo '<td class="text-right">' . number_format($val['countRecieve']) . '</td>';
                echo '</tr>';
                $JobsPrice += $val['JobsPrice'];
            }

            echo '<tr class="text-right">';
            echo '<td colspan="2">รวม</td>';
            echo '<td>' . number_format(array_sum($sum)) . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
<!--</table>-->
