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

                <div class="form-group" id="div_group_select_shift">
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

                </div>

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

        <div class="form-group">
            <label class="col-sm-2 control-label" for="show_dialog"></label> 
            <div id="supply_mode" class="col-sm-10" >
                <button type="button" id="dgSend" data-mode="send" class="btn btn-default col-sm-2" >ส่งอุปกรณ์</button> 
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

    <div class="modal fade bs-example-modal-lg input-dialog" tabindex="-1" data-focus-on="input:first">

        <div class="modal-dialog modal-lg " >
            <div class="modal-content">
                <form class="form-horizontal" name="editForm" id="editForm" role="form" action="<?php echo URL; ?>productForm/" method="post">
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true"><span>&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Form Input Data</h4>
                    </div>
                    <div class="modal-body">
                        <div id="formAlert"></div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="div_items_form">FORM NAME :</label>
                            <div class="col-sm-7" id="div_items_form" name="div_items_form">
                                <select class="form-control " id="items_form" name="items_form">
                                    <?php
                                    foreach ($this->getFormStatusY as $value) {
                                        echo "<option value='{$value[form_code]}' >{$value[form_name]}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-sm-3" for="div_items_code">CODE :</label>
                            <div class="col-sm-7" id="div_items_code" name="div_items_code">
                                <input type="text" id="items_code" name="items_code" class="form-control" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-sm-3" for="div_items_name">NAME :</label>
                            <div class="col-sm-7" id="div_items_name" name="div_items_name">
                                <input type="text" id="items_name" name="items_name" class="form-control" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="div_items_type">TYPE :</label>
                            <div class="col-sm-7" id="div_items_type" name="div_items_type">
                                <select class="form-control " id="items_type" name="items_type">
                                    <?php
                                    foreach ($this->getType as $value) {
                                        echo "<option value='{$value}' >{$value}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="div_items_formula">FORMULA :</label>
                            <div class="col-sm-7" id="div_items_formula" name="div_items_formula" >
<!--                                <input type="text" id="items_formula" name="items_formula" class="form-control" autocomplete="off" /><br>-->
                                <textarea id="items_formula" name="items_formula" class="form-control" rows="3" cols="70" style="width: 495px; height: 60px;">
                                </textarea>
<!--                                <div id="img_checkOk"><img src="./public/images/check.png" height="16" /></div><div id="img_checkNo"><img src="./public/images/error.png" height="16" /></div>-->

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="div_items_formula_manage"></label>
                            <div class="col-sm-7" id="div_items_formula_manage" name="div_items_formula_manage">
                                <button type="button" id="choose-items" class="btn btn-sm btn-info" data-toggle="modal" data-target=".frm-choose-items">Choose Items
                                    <span ></span>
                                </button>
                                <!--                                <button type="button" id="choose-jobs" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".frm-choose-jobs">เลือกงานซ่อม</button>-->
                                <!--                                glyphicon glyphicon-plus-->
                                <button type="button" id="btn_chk_formula" class="btn btn-sm btn-success">Check Formula
                                    <span ></span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="div_items_form_input_readonly">INPUT READONLY  :</label>
                            <div class="col-sm-7" id="div_items_form_input_readonly" name="div_items_form_input_readonly">
                                <select class="form-control " id="items_form_input_readonly" name="items_form_input_readonly">
                                    <?php
                                    foreach ($this->getInputReadonly as $value) {
                                        echo "<option value='{$value}' >{$value}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="div_items_form_input">FORM INPUT  :</label>
                            <div class="col-sm-7" id="div_items_form_input" name="div_items_form_input">
                                <select class="form-control " id="items_form_input" name="items_form_input">
                                    <?php
                                    foreach ($this->getFormInput as $value) {
                                        echo "<option value='{$value}' >{$value}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="div_items_font_bold">FONT BOLD  :</label>
                            <div class="col-sm-7" id="div_items_font_bold" name="div_items_font_bold">
                                <select class="form-control " id="items_font_bold" name="items_font_bold">
                                    <?php
                                    foreach ($this->getFontBold as $value) {
                                        echo "<option value='{$value}' >{$value}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="div_items_not_null">NOT NULL  :</label>
                            <div class="col-sm-7" id="div_items_not_null" name="div_items_not_null">
                                <select class="form-control " id="items_not_null" name="items_not_null">
                                    <?php
                                    foreach ($this->getFontBold as $value) {
                                        echo "<option value='{$value}' >{$value}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-sm-3" for="div_items_index">INDEX :</label>
                            <div class="col-sm-7" id="div_items_index" name="div_items_index">
                                <input type="text" id="items_index" name="items_index" class="form-control" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="div_items_status">STATUS :</label>
                            <div class="col-sm-7" id="div_items_status" name="div_items_status">
                                <select class="form-control " id="items_status" name="items_status">
                                    <?php
                                    foreach ($this->getStatus as $value) {
                                        echo "<option value='{$value}' >{$value}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_submit" class="btn btn-lg btn-primary">Save
                            <span class="glyphicon glyphicon-off"></span>
                        </button>
                        <button type="button" id="btn_clear" class="btn btn-lg">Clear
                            <span ></span>
                        </button>
                        <button type="button" id="btn_reset" class="btn btn-lg btn-danger">Reset
                            <span class="glyphicon glyphicon-repeat"></span>
                        </button>
                    </div>

                </form>
            </div>    
        </div>
    </div> 

    <div class="modal fade bs-example-modal-lg frm-choose-items" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="form-horizontal">   
                    <div class="modal-header">
                        <button id="model-items-close" type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true"><span>&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">เลือกภาระงาน</h4><!--Choose Jobs Data-->
                    </div>
                    <div class="modal-body">

                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="choose_search_jobs">คำค้น :</label>
                            <div class="col-sm-10">
                                <input type="text" id="choose_search_jobs" name="choose_search_jobs" class="form-control" />
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="pagin-items" align="right" style="margin: -20px 10px;"></div>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">CODE</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">NAME</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">TYPE</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">FORMULA</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">เลือก</th>
                        </tr>
                    </thead>
                    <tbody id="select_items_data">            
                    </tbody>
                </table>

            </div>
        </div>
    </div>



    <br>
    <div class="form-horizontal" > 
        <div id="listings"></div> 
    </div>

    <div >
        <p>host:=[<?= DB_HOST ?>] db_name:=[<?= DB_NAME ?>]</p>
    </div>
</div>


