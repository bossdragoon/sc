<thead>
    <tr>
        <th class="text-center" colspan=1><?= $_POST['report-title']; ?></th>
        <th class="text-center" colspan=8>ช่วงวันที่ <?= date('d/m/Y', strtotime($_POST['date1'])) . ' ถึง ' . date('d/m/Y', strtotime($_POST['date2'])); ?></th>
    </tr>
    <tr>
        <th class="text-center">ชื่อ-สกุล</th>
        <?php
        foreach ($this->detailStatus as $staVal) {
            echo "<th class='text-center'>{$staVal['status_name']}</th>";
        }
        ?>
        <th class="text-center">นับใบซ่อม</th>
    </tr>
</thead>
<tbody>
    <?php
    if (sizeof($this->arrReport) > 0) {
        foreach ($this->arrReport as $val) {
            echo '<tr class="text-center">';
            echo "<td class='text-left'>{$val['person_name']}</td>";
            foreach ($this->detailStatus as $staVal) {
                echo "<td>{$val['sta' . $staVal['sort']]}</td>";
            }
            echo "<td>{$val['sum_jobService']}</td>";
            echo '</tr>';
        }
    }
    ?>
</tbody>