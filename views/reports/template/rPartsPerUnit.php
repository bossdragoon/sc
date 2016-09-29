<!--<table class="table table-striped table-bordered table-condensed" border="1" id="table_report_data">-->
    <thead>
        <tr>
            <th class="text-center" colspan=3><?= $_POST['report-title']; ?></th>
            <th class="text-center" colspan=2>ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
        </tr>
        <tr>
            <th class="text-center">ชื่อหน่วยงาน</th>
            <th class="text-center">รายการอะไหล่</th>
            <th class="text-center">จำนวนใบซ่อม</th>
            <th class="text-center">จำนวนที่ใช้</th>
            <th class="text-center">หน่วยนับ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (sizeof($this->arrReport) > 0) {
            $header = $sum = '';

            foreach ($this->arrReport as $key => $val) {
                $sum[$val['depart_id']] += $val['countRecept'];
            }

            foreach ($this->arrReport as $key => $val) {
                if ($header <> $val['depart_id']) {
                    echo '<tr style="background-color: #7bbdd9">';
                    echo "<td colspan='4'>{$val['depart_name']}</td>";
                    echo "<td class='text-right'>{$sum[$val['depart_id']]}</td>";
                    echo '</tr>';
                    $header = $val['depart_id'];
                }

                echo '<tr>';
                echo '<td></td>';
                echo "<td>{$val['store_type_name']}</td>";
                echo '<td class="text-right">' . number_format($val['countRecept']) . '</td>';
                echo '<td class="text-right">' . number_format($val['sumCount']) . '</td>';
                echo "<td class='text-right'>{$val['store_type_count']}</td>";
                echo '</tr>';
            }

            echo '<tr class="text-right">';
            echo '<td colspan="2">รวม</td>';
            echo '<td>' . number_format(array_sum($sum)) . '</td>';
            echo '<td colspan="2"></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
<!--</table>-->
