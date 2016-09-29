<!--<table class="table table-striped table-bordered table-condensed" border="1" id="table_report_data">-->
    <thead>
        <tr>
            <th class="text-center" colspan=3><?= $_POST['report-title']; ?></th>
            <th class="text-center" colspan=2>ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
        </tr>
        <tr>
            <th class="text-center">เลขที่ใบซ่อม</th>
            <th class="text-center">จำนวนใบซ่อม</th>
            <th class="text-center">ราคาค่าซ่อม</th>
            <th class="text-center">ราคาอะไหล่</th>
            <th class="text-center">ราคารวม</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (sizeof($this->arrReport) > 0) {
            $recieve = $JobsPrice = $PartsPrice = $sumPrice = 0;
            foreach ($this->arrReport as $val) {
                echo '<tr>';
                echo "<td>{$val['service_no']}</td>";
                echo "<td>{$val['depart_name']}</td>";
                echo '<td class="text-right">' . number_format($val['JobsPrice'], 2) . '</td>';
                echo '<td class="text-right">' . number_format($val['PartsPrice'], 2) . '</td>';
                echo '<td class="text-right">' . number_format(($val['JobsPrice'] + $val['PartsPrice']), 2) . '</td>';
                echo '</tr>';
                $recieve ++;
                $JobsPrice += $val['JobsPrice'];
                $PartsPrice += $val['PartsPrice'];
                $SumPrice += ($val['JobsPrice'] + $val['PartsPrice']);
            }
            echo '<tr class="text-right">';
            echo '<td class="text-left">ใบซ่อม ' . number_format($recieve) . ' ใบ</td>';
            echo '<td>รวมราคา</td>';
            echo '<td>' . number_format($JobsPrice, 2) . '</td>';
            echo '<td>' . number_format($PartsPrice, 2) . '</td>';
            echo '<td>' . number_format($SumPrice, 2) . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
<!--</table>-->
