<thead>
    <tr>
        <th class="text-center" colspan=2><?= $_POST['report-title']; ?></th>
        <th class="text-center" colspan=2>ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
    </tr>
    <tr>
        <th class="text-center">รายการอะไหล่</th>
        <th class="text-center">จำนวนใบซ่อม</th>
        <th class="text-center">จำนวนหน่วยที่ใช้</th>
        <th class="text-center">หน่วยนับ</th>
    </tr>
</thead>
<tbody>
    <?php
    if (sizeof($this->arrReport) > 0) {
        foreach ($this->arrReport as $val) {
            echo '<tr>';
            echo "<td>{$val['store_type_name']}</td>";
            echo '<td class="text-right">' . number_format($val['countRecept']) . '</td>';
            echo '<td class="text-right">' . number_format($val['sumCount']) . '</td>';
            echo "<td>{$val['store_type_count']}</td>";
            echo '</tr>';
            $countRecept += $val['countRecept'];
        }

        echo '<tr class="text-right">';
        echo '<td>รวมใบซ่อม</td>';
        echo '<td>' . number_format($countRecept) . '</td>';
        echo '<td colspan=2> </td>';
        echo '</tr>';
    }
    ?>
</tbody>
