<!--<table class="table table-striped table-bordered table-condensed" border="1" id="table_report_data">-->
    <thead>
        <tr>
            <th class="text-center" colspan="3"><?= $_POST['report-title']; ?></th>
            <th class="text-center" colspan="4">ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
        </tr>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">ชื่อหน่วยงาน</th>
            <th class="text-center">ส่งอุปกรณ์</th>
            <th class="text-center">รับอุปกรณ์</th>
            <th class="text-center">จ่ายอุปกรณ์</th>
            <th class="text-center">รับอุปกรณ์<br>ปราศจากเชื้อ</th>
            <th class="text-center">ชนิดอุปกรณ์</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (sizeof($this->arrReport) > 0) {
            $JobsPrice = $PartsPrice = $sumPrice = 0;
            foreach ($this->arrReport as $val) {
                $i+=1;
                echo '<tr>';
                echo "<td>{$i}</td>";
                echo "<td>{$val['items_name']}</td>";
                echo '<td class="text-right">' . number_format($val['supply_items_send'], 0) . '</td>';
                echo '<td class="text-right">' . number_format($val['supply_items_receive'], 0) . '</td>';
                echo '<td class="text-right">' . number_format($val['supply_items_divide'], 0) . '</td>';
                echo '<td class="text-right">' . number_format($val['supply_items_remain'], 0) . '</td>';
                echo "<td>{$val['items_type_name']}</td>";
                echo '</tr>';
                $supply_items_send += $val['supply_items_send'];
                $supply_items_receive += $val['supply_items_receive'];
                $supply_items_divide += $val['supply_items_divide'];
                $supply_items_remain += $val['supply_items_remain'];
            }
            echo '<tr class="text-right">';
            echo '<td class="text-center" colspan="2"><b>รวม</td>';
            echo '<td class="text-right"><b>' . number_format($supply_items_send, 0) . '</td>';
            echo '<td class="text-right"><b>' . number_format($supply_items_receive, 0) . '</td>';
            echo '<td class="text-right"><b>' . number_format($$supply_items_divide, 0) . '</td>';
            echo '<td class="text-right"><b>' . number_format($supply_items_remain, 0) . '</td>';
            echo '<td class="text-right"> </td>';
            echo '</tr>';
        }
        ?>
    </tbody>
<!--</table>-->
