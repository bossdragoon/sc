<div class="container-fluid">
    <div class="jumbotron" style="background-color: hsla(206, 85%, 65%, 0.72);">
        <h1><?=SYSTEM_NAME?></h1>
        <p><?=DEPARTMENT_NAME?></p>
    </div>
    <div class="row">
        <!--<div class="col-lg-7 col-sm-7"><pre><?php $logged = Session::get('User'); ?></pre></div>-->
        <div class="col-lg-12 col-sm-12">
            
             <div id="div_announce" >
                <div class="hidden-xs">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4><span class="glyphicon glyphicon-blackboard"></span><font color="red"><b> ข่าวประกาศ </b></font></h4></div>
                        <div class="panel-body">
                            <div class="col-lg-12 col-sm-12">
                                <pre>
                                 <h4><b>2. ปุ่ม [One Day]   [3 TAB]   [6 TAB] </b></h4>  
                                    <br>2.1 ปุ่ม [One Day] แสดงข้อมูลเพียง 1 วัน 3 เวร
                                    <br>2.2 ปุ่ม [3 TAB] แสดงข้อมูล 3 แท็บ ๆ ละ 10 วัน
                                    <br>2.3 ปุ่ม [6 TAB] แสดงข้อมูล 6 แท็บ ๆ ละ 5 วัน
                                 </pre>  
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <pre>
                                 <h4><b>1. กรณี Multiple Depart </b></h4>  
                                    <br>ใช้สำหรับหน่วยงานที่ขึ้นเวรรวมกัน 2 ward/หน่วยงาน ขึ้นไป เช่น อายุรกรรมชายกับพิเศษ 4 , อายุรกรรมหญิงกับพิเศษ 5 , อายุรกรรมรวมกับพิเศษสงฆ์ 4 , หลังคลอดกับพิเศษสงฆ์ 3 เป็นต้น 
                                    <br>การใช้งานให้เลือก ward ในช่อง dropdown list แล้วกดปุ่ม <b>"Call Data"</b> รอให้ป้ายข้อความ <b>"บันทึกภาระงาน ผู้ป่วยใน"</b> เปลี่ยนไปตาม ward/หน่วยงาน ที่เลือก 
                                    <br>ตัวอย่างเช่น <b>"บันทึกภาระงาน ผู้ป่วยใน [ 59 :: พิเศษสงฆ์ชั้น 4 ]"</b> เปลี่ยนเป็น  <b>"บันทึกภาระงาน ผู้ป่วยใน [ 98 :: หอผู้ป่วยอายุรกรรมรวม ]"</b>
                                    <br><b> <font color="red">*** ระบบจะเก็บบันทึกข้อมูลตามชื่อ ward/หน่วยงาน ที่แสดง </font><font color="green">(ตัวอักษรสีเขียว)</font> <font color="red">*** </font></b>
                                 </pre>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="div_menu" >
                <div class="hidden-xs">
                    <div class="panel panel-info" id ="show_menu_form">
                        <div class="panel-heading"><span class="glyphicon glyphicon-th-large"></span> บันทึกภาระงานรายวัน </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-lg-6 col-sm-6 text-center">
                                    <a href="#" class="list-group-item list-group-item-primary">
                                        <h3 class="list-group-item-heading">บันทึกภาระงาน วิสัญญี <span class="glyphicon glyphicon-th-list"></span></h3>
                                        <p class="list-group-item-text"><?= number_format($report [0]['cntService']) ?> output / total factor input</p>
                                    </a>
                                </div>

                                <div class="col-lg-6 col-sm-6 text-center">
                                    <a href="#" class="list-group-item list-group-item-primary">
                                        <h3 class="list-group-item-heading">บันทึกภาระงาน อุบัติเหตุและฉุกเฉิน <span class="glyphicon glyphicon-th-list"></span></h3>
                                        <p class="list-group-item-text"><?= number_format($report [0]['jobsPrice']) ?> output / total factor input</p>
                                    </a>
                                </div>
                            </div>
                            <br> 
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 text-center">
                                    <a href="#" class="list-group-item list-group-item-primary">
                                        <h3 class="list-group-item-heading">บันทึกภาระงาน ผู้ป่วยใน <span class="glyphicon glyphicon-th-list"></span></h3>
                                        <p  class="list-group-item-text"><?= number_format($report [0]['partsPrice']) ?>  output / total factor input</p>
                                    </a>
                                </div>

                                <div class="col-lg-6 col-sm-6 text-center">
                                    <a href="#" class="list-group-item list-group-item-primary">
                                        <h3 class="list-group-item-heading">บันทึกภาระงาน ห้องคลอด <span class="glyphicon glyphicon-th-list"></span></h3>
                                        <p  class="list-group-item-text"><?= number_format($report [0]['jobsPrice']) ?>  output / total factor input</p>
                                    </a>
                                </div>

                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div id="div_config_user" >
                <div class="hidden-xs">
                    <div class="panel panel-default">
                        <div class="panel-heading"><span class="glyphicon glyphicon-th-large"></span> Config User </div>
                        <div class="panel-body">
                            <div class="col-lg-12 col-sm-12">
                                <pre>
                                    <?php
//                                    $logged = Session::get('User');
                                    var_dump($logged);
                                    ?>                
                                </pre>
                                <div id="reportResult"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (like_match('%admin%', $User['Productivity_system']) == TRUE) { ?>
                <div id="div_config_user" >
                    <div class="hidden-xs">
                        <div class="panel panel-default">
                            <?php
                            $filename = "config/BILLTRAN20121008.txt";
                            $md5file = md5_file($filename);
                            echo strtoupper($md5file);
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?> 
        </div>
    </div>
</div>