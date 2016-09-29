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
                                 <h5><br>
                                     <b> <font color="red"> *** โปรแกรมกำลังพัฒนา *** </font></b>
                                 </pre>  
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <pre>
                                    <b>2..</b>
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
            <?php if (like_match('%admin%', $User['Supply_system']) == TRUE) { ?>
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