<?php
$User = Session::get('User');
$active = ' class="active"';
?>

<div class="form-horizontal" id="mainForm" name ="mainForm">
    <h1>จัดการเบิก-จ่ายอุปกรณ์</h1>
    <p>รายการเบิก-จ่ายอุปกรณ์</p>
    <?php
    $logged = Session::get(SESSION_USER);
    ?>
    <div class="form-horizontal" > 
        <input type="hidden" id="username" name="username"  value="<?= $logged['person_username'] ?>" />

        <div class="row">
            <div class="col-md-11">

                <div class="form-group" id="div_select_date" name="div_select_date" >
                    <div class="form-group col-xs-12 col-lg-9" id="div_date1">
                        <label class="control-label col-lg-5" for="search">เลือกวันที่ :</label>
                        <div class="input-group col-xs-7 col-lg-7">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="text" id="date1" name="date1" class="form-control" value="<?= date('Y-m-d') ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label" for="select_shift">เลือกเวร :</label>
                    <div class="col-lg-10" id="div_select_shift" name="div_select_shift">
                        <div class="form-group row">
                            <div class="col-lg-10">
                                <select class="form-control" id="select_shift" name="select_shift">
                                    <?php
                                    foreach ($this->getShift as $value) {
                                        echo "<option value='{$value}' >{$value}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="button" id="btn_submit" class="btn btn-primary col-lg-12">Call Data</button> 
                            </div>
                        </div>                        
                    </div>
                </div>                
                <!--                <div class="form-group" id="div_group_select_shift">
                                    <label class="form-group col-xs-12 col-lg-9" for="div_select_shift">เลือกเวร :</label>
                                    <div class="form-group col-lg-9" id="div_select_shift" name="div_select_shift">
                                        <select class="form-control" id="select_shift" name="select_shift">
                <?php
                foreach ($this->getShift as $value) {
                    echo "<option value='{$value}' >{$value}</option>";
                }
                ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-5 col-lg-5 text-center">
                                        <button type="button" id="btn_submit" class="btn btn-primary col-lg-12">Call Data</button>             
                                    </div>
                                    <br>
                                </div>-->

                <div class="form-group" id="group_select_dept" name="group_select_dept">
                    <label class="control-label col-sm-2" for="select_dept">Ward/หน่วยงาน :</label>
                    <div class="col-sm-8"id="div_select_dept" name="div_select_dept" >
                        <select class="form-control " id="select_dept" name="select_dept">
                            <option value="">- - ทั้งหมด - -</option>
                            <?php
                            foreach ($this->getDepart as $value) {
                                echo "<option value='{$value[depart_id]}' >{$value[depart_name]}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2" >
                        <button type="button" id="btn_Call"  class="btn btn-success" data-target="" data-toggle="modal" > Call Data
                            <span></span>
                        </button>
                    </div>
                </div>

                <div class="form-group has-feedback" id="div_search">
                    <label class="control-label col-sm-2" for="search">ค้นใบเบิก :</label>
                    <div class="col-sm-10" >
                        <input type="text" id="search" name="search" class="form-control" />
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div>

                <div class="form-group has-feedback" id="div_size">
                    <label class="control-label col-sm-2" for="search">ขนาด Page :</label>
                    <div class="col-sm-10" >
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" > ย่อ
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" checked> ขยาย
                        </label> 
                    </div>

                </div>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="show_dialog"></label> 
            <div id="supply_mode" class="col-sm-10" >
                <button type="button" id="dgSend" data-mode="send" class="btn btn-default col-sm-2" >ส่งอุปกรณ์<!--<span class="glyphicon glyphicon-stop" style="color:blue;"></span>--></button> 
                <button type="button" id="dgReceive" data-mode="receive" class="btn btn-default col-sm-2" >รับอุปกรณ์</button> 
                <button type="button" id="dgDivide" data-mode="divide" class="btn btn-default col-sm-2" >จ่ายอุปกรณ์</button> 
                <button type="button" id="dgReceive2" data-mode="receive2" class="btn btn-default col-sm-2" >รับอุปกรณ์ปราศจากเชื้อ</button> 

            </div>
            <div class="col-sm-10" >
                <div class="pagin" align="right" style="margin: -20px 10px;"></div>
            </div>
            <input type="hidden" id="select_supply_mode" value="" />
        </div>

    </div>

    <div class="modal fade bs-example-modal-lg frm-Management-Data" tabindex="-1" data-focus-on="input:first">

        <div class="modal-dialog modal-lg2">
            <div class="modal-content">
                <form id="partManagement" name="partManagement" class="form-horizontal" role="form" action="<?= URL; ?>parts_items/xhrInsertPart" method="post">
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span readonly>&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel" >บันทึกข้อมูลเบิก-จ่ายอุปกรณ์ :: เลขที่ <label id="supply_id">1234</label> หน่วยงาน/Ward <label id="supply_depart">ICU 1</label></h4>
                        <input type="hidden" id="userPerson_id" name="userPerson_id" value="<?= $logged['person_id']; ?>" />
                    </div>
                    <div class="modal-body">
                        <div class='panel-group' id='supplyHeadDate-panel'>
                            <div class='panel panel-default'>
                                <div class='panel-heading' data-toggle='collapse' data-target='#headData' style='cursor: pointer;'> 
                                    <!-- aria-expanded="fase"    true-->
                                    <h4 class='panel-title'>
                                        <a data-toggle='collapse' data-target='#headData'></a> รายละเอียด
                                    </h4>
                                </div>
                                <div id='headData' class='panel-collapse collapse'>
                                    <div class='panel-body'>
                                        <div class='row'>
                                            <div class='col-xs-6 col-lg-2 text-left'><strong>วันที่เบิก :</strong></div>
                                            <div class='col-xs-6 col-lg-4 text-left'>
                                                <input type="text" id="supply_date" name="supply_date" class="form-control" value="<?= date('Y-m-d') ?>" /> 
                                            </div>
                                            <div class='col-xs-6 col-lg-2 text-left'><strong>เวร :</strong></div>
                                            <div class='col-xs-6 col-lg-4 text-left'> 
                                                <select class="form-control" id="select_shift" name="select_shift">
                                                    <?php
                                                    foreach ($this->getShift as $value) {
                                                        echo "<option value='{$value}' >{$value}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>     
                                        </div>
                                        <br>
                                        <div class='row'>
                                            <div class='col-xs-6 col-lg-2 text-left'><strong>หน่วยงาน :</strong></div>
                                            <div class='col-xs-6 col-lg-4 text-left'> 
                                                <select class="form-control selectpicker" id="supply_depart" name="supply_depart" data-live-search="true" >
                                                    <option value="">- - เลือก - -</option>
                                                    <?php
                                                    foreach ($this->getDepart as $value) {
                                                        echo "<option value='{$value[depart_id]}' >{$value[depart_name]}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class='row'>
                                            <div class='col-xs-6 col-lg-2 text-left'><strong>ส่งอุปกรณ์ :</strong></div>
                                            <div class='col-xs-6 col-lg-4 text-left'> 
                                                <select class="form-control  selectpicker" id="supply_consignee" name="supply_consignee" data-live-search="true" >
                                                    <option value="">- - เลือก - -</option>
                                                    <?php
                                                    foreach ($this->getPersonalSupplyConsignee as $value) {
                                                        echo "<option value='{$value[person_id]}' >{$value[person_name]}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class='col-xs-6 col-lg-4 text-left'>
                                                <input type="text" id="supply_consignee_date" name="supply_consignee_date" class="form-control" value="<?= date('Y-m-d') ?>" /> 
                                            </div>
                                            <div class="input-group bootstrap-timepicker timepicker">
                                                <input id="supply_consignee_time" type="text" class="form-control input-small">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-time"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <br>
                                        <div class='row'>  
                                            <div class='col-xs-6 col-lg-2 text-left'><strong>รับอุปกรณ์ :</strong></div>
                                            <div class='col-xs-6 col-lg-4 text-left'>
                                                <select class="form-control  selectpicker" id="supply_consignor" name="supply_consignor" data-live-search="true">
                                                    <option value="">- - เลือก - -</option>
                                                    <?php
                                                    foreach ($this->getPersonalSupplyConsignor as $value) {
                                                        echo "<option value='{$value[person_id]}' >{$value[person_name]}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class='col-xs-6 col-lg-4 text-left'>
                                                <input type="text" id="supply_consignor_date" name="supply_consignor_date" class="form-control" value="<?= date('Y-m-d') ?>" /> 
                                            </div>
                                            <div class="input-group bootstrap-timepicker timepicker">
                                                <input id="supply_consignor_time" type="text" class="form-control input-small">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-time"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <br>
                                        <div class='row'>
                                            <div class='col-xs-6 col-lg-2 text-left'><strong>จ่ายอุปกรณ์ :</strong></div>
                                            <div class='col-xs-6 col-lg-4 text-left'>
                                                <select class="form-control  selectpicker" id="supply_divider" name="supply_divider" data-live-search="true">
                                                    <option value="">- - เลือก - -</option>
                                                    <?php
                                                    foreach ($this->getPersonalSupplyDivider as $value) {
                                                        echo "<option value='{$value[person_id]}' >{$value[person_name]}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class='col-xs-6 col-lg-4 text-left'>
                                                <input type="text" id="supply_divider_date" name="supply_divider_date" class="form-control" value="<?= date('Y-m-d') ?>" /> 
                                            </div>
                                            <div class="input-group bootstrap-timepicker timepicker">
                                                <input id="supply_divider_time" type="text" class="form-control input-small">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-time"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <br>
                                        <div class='row'>
                                            <div class='col-xs-6 col-lg-2 text-left'><strong>รับอุปกรณ์ปราศเชื้อ :</strong></div>
                                            <div class='col-xs-6 col-lg-4 text-left'>
                                                <select class="form-control  selectpicker" id="supply_consignor2" name="supply_consignor2" data-live-search="true">
                                                    <option value="">- - เลือก - -</option>
                                                    <?php
                                                    foreach ($this->getPersonalSupplyConsignor2 as $value) {
                                                        echo "<option value='{$value[person_id]}' >{$value[person_name]}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class='col-xs-6 col-lg-4 text-left'>
                                                <input type="text" id="supply_consignor2_date" name="supply_consignor2_date" class="form-control" value="<?= date('Y-m-d') ?>" /> 
                                            </div>
                                            <div class="input-group bootstrap-timepicker timepicker">
                                                <input id="supply_consignor2_time" type="text" class="form-control input-small">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-time"></i>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-horizontal">  
                                                <div class='row'>
                                                    <div class='col-xs-4 col-lg-4 text-left'>
                                                        เลือกอุปกรณ์ :<select class="form-control  selectpicker" id="choose_items" name="choose_items" data-live-search="true">
                                                            <option value="">- - เลือก - -</option>
                                                            <?php
                                                            foreach ($this->getItemsStatusY as $value) {
                                                                echo "<option value='{$value[items_id]}' >{$value[items_name]}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class='col-xs-1 col-lg-1 text-left'>
                                                        ส่ง : <input class="form-control" type="number" id="IP01C001" name="IP01C001" max="999999" min="0" value="0" >
                                                    </div>
                                                    <div class='col-xs-1 col-lg-1 text-left'>
                                                        รับ : <input class="form-control" type="number" id="IP01C001" name="IP01C001" max="999999" min="0" value="0" >
                                                    </div>
                                                    <div class='col-xs-1 col-lg-1 text-left'>
                                                        จ่าย : <input class="form-control" type="number" id="IP01C001" name="IP01C001" max="999999" min="0" value="0" >
                                                    </div>
                                                    <div class='col-xs-1 col-lg-1 text-left'>
                                                        ค้าง : <input class="form-control" type="number" id="IP01C001" name="IP01C001" max="999999" min="0" value="0" >
                                                    </div>
                                                    <div class='col-xs-2 col-lg-2 text-left'>
                                                        ประเภทเบิก :<select class="form-control  selectpicker" id="choose_order_type" name="choose_order_type" data-live-search="true">
                                                            <option value="">- - เลือก - -</option>
                                                            <?php
                                                            foreach ($this->getOrderType as $value) {
                                                                echo "<option value='{$value}' >{$value}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class='col-xs-2 col-lg-2 text-left'>
                                                        <button id="choose_add" class="btn btn-lg btn-primary" type="button">  ADD  </button>
                                                    </div>
                                                </div>
                                                <br>

                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                        </div>

                        <!--tabs-->
                        <ul class="nav nav-tabs">
                            <li id="li-tab-parts" class="active"><a data-toggle="tab" href="#tab-jobs"><b>รายการเบิก-จ่าย</b></a></li>
                            <li id="li-tab-parts"><a data-toggle="tab" href="#tab-parts">อะไหล่</a></li>
                        </ul>
                        <!------>
                        <div class="tab-content">
                            <!--tab content for "#home"-->
                            <div id="tab-items" class="tab-pane fade in active">
                                <div class="col-md-12" id="no-more-tables" >
                                    <br>
                                    <table class="col-md-12 table-striped table-bordered table-condensed cf">
                                        <thead class="cf">
                                            <tr>
                                                <th style="text-align: center;" > # 
                                                <th style="text-align: center;" > รายการอุปกรณ์ 
                                                <th style="text-align: center;" > ส่ง </th>
                                                <th style="text-align: center;" > รับ </th>
                                                <th style="text-align: center;" > จ่าย </th>
                                                <th style="text-align: center;" > ค้าง 
                                                <th style="text-align: center;" > ประเภทเบิก
                                                <th style="text-align: center;" > จัดการ </th>
                                                <th style="text-align: center; display: none;" > supply_items_id </th>
                                                <th style="text-align: center; display: none;" > hos_guid </th>
                                                <th style="text-align: center; display: none;" > manage </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tables_data_supply_items"></tbody>
    <!--                                    <tfoot>
                                            <tr>
                                                <td class="text-center col-sm-6" colspan="4"></td>
                                                <td class="text-right col-sm-2"></td>
                                                <td class="text-right col-sm-4" colspan="3"></td>
                                            </tr>
                                        </tfoot>  -->
                                    </table>
                                </div>
                                <div class="col-md-12 text-success">&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;ทั้งหมด--&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" class="text-right" id="sum_price_all_jobs" name="sum_price_all_jobs" size="8" value="SUM&nbsp;ALL" disabled />
                                    <input type="hidden" id="arrJobs" name="arrJobs" value="">
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped">
                            <tr>
                                <td class="col-xs-3 col-md-2 col-lg-2 text-center">ราคารวม <label id="sumAllService" name="sumAllService">1.00</label> บาท</td>
                                <td class="col-xs-4 col-md-3 col-lg-2 text-center"> [<label id="sumAllServiceThaiBaht" name="sumAllServiceThaiBaht">หนึ่งบาทถ้วน</label>] </td>
                                <td class="col-xs-5 col-md-7 col-lg-8 text-right"><button type="submit" id="btn_submit_jobpart" class="btn btn-primary">Save
                                        <span class="glyphicon glyphicon-off"></span>
                                    </button>
                                    <button type="button" id="btn_reset_jobpart" class="btn btn-danger">Reset
                                        <span class="glyphicon glyphicon-repeat"></span>
                                    </button>
                                </td>
                            </tr>
                        </table>

                    </div>
                </form>
            </div>

        </div>
    </div> 

    <br>

    <!--- ตารางเบิก-จ่ายอุปกรณ์ หลักหน้าแรก --->
    <div class="form-horizontal" > 
        <table id='tbSupply' class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center;" width="50px" > # </th>
                    <th style="text-align: center;" width="180px"> หน่วยงาน </th>
                    <th style="text-align: center;" width="80"> จำนวนเบิก<br>(รายการ) </th>
                    <th style="text-align: center;" width="150px"> ส่งอุปกรณ์ </th>
                    <th style="text-align: center;" width="150px"> เวลา<br>ส่งอุปกรณ์ </th>
                    <th style="text-align: center;" width="150px"> รับอุปกรณ์ </th>
                    <th style="text-align: center;" width="150px"> เวลา<br>รับอุปกรณ์ </th>
                    <th style="text-align: center;" width="150px"> จ่ายอุปกรณ์ </th>
                    <th style="text-align: center;" width="150px"> เวลา<br>จ่ายอุปกรณ์ </th>
                    <th style="text-align: center;" width="150px"> รับอุปกรณ์<br>ปราศจากเชื้อ </th>
                    <th style="text-align: center;" width="150px"> เวลา<br>รับอุปกรณ์.. </th>
                    <th style="text-align: center;" width="100pxpx"> จัดการ </th>
                </tr>
            </thead>
            <tbody id="listingsDataSupply">            
            </tbody>
        </table>

    </div>    
    <div>
        <p>host:=[<?= DB_HOST ?>] db_name:=[<?= DB_NAME ?>]</p>
    </div>

</div>


