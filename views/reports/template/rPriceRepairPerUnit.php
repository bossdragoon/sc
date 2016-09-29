<!--<table class="table table-striped table-bordered table-condensed" border="1" id="table_report_data">-->
    <thead>
        <tr>
            <th class="text-center" colspan="3"><?= $_POST['report-title']; ?></th>
            <th class="text-center" colspan="2">ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
        </tr>
        <tr>
            <th class="text-center">ชื่อหน่วยงาน</th>
            <th class="text-center">จำนวนใบซ่อม</th>
            <th class="text-center">ราคาค่าซ่อม</th>
            <th class="text-center">ราคาอะไหล่</th>
            <th class="text-center">ราคารวม</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (sizeof($this->arrReport) > 0) {
            $JobsPrice = $PartsPrice = $sumPrice = 0;
            foreach ($this->arrReport as $val) {
                echo '<tr>';
                echo "<td>{$val['depart_name']}</td>";
                echo "<td class='text-center'>{$val['recieve']}</td>";
                echo '<td class="text-right">' . number_format($val['JobsPrice'], 2) . '</td>';
                echo '<td class="text-right">' . number_format($val['PartsPrice'], 2) . '</td>';
                echo '<td class="text-right">' . number_format($val['sumPrice'], 2) . '</td>';
                echo '</tr>';
                $recieve += $val['recieve'];
                $JobsPrice += $val['JobsPrice'];
                $PartsPrice += $val['PartsPrice'];
                $sumPrice += $val['sumPrice'];
            }
            echo '<tr class="text-right">';
            echo '<td>รวม</td>';
            echo '<td class="text-center">' . number_format($recieve) . '</td>';
            echo '<td>' . number_format($JobsPrice, 2) . '</td>';
            echo '<td>' . number_format($PartsPrice, 2) . '</td>';
            echo '<td>' . number_format($sumPrice, 2) . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
<!--</table>-->
