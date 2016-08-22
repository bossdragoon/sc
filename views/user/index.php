<?php
//$this->view->js = array('public/js/pagejscript.js');

$User = Session::get('User');
$active = ' class="active"';


$arrConfig = $this->getConfig;
$dtConfig = $arrConfig[0]["conf"];

$configList = array();

while (strpos($dtConfig, "[") !== false) {
    $iStart = strpos($dtConfig, "[");
    $iEnd = strpos($dtConfig, "]");
    $iVal = trim($dtConfig);

    array_push($configList, (substr($iVal, $iStart, $iEnd - $iStart + 1)));
    //remove first bracket
    $dtConfig = substr($dtConfig, $iEnd + 1);
    /*
      if(!isset($pos)){ $pos=1;}else{ $pos++;}
      echo "<b>Loop : " . $pos . "</b><br />";
      echo $iStart . "," . $iEnd . " : " . $iVal . "<br />";
      echo $dtConfig . "<br/><br/>";
     */
}
//echo var_dump($configList);
?>

<div class="container">
    <h1>กำหนดสิทธิ์ผู้ใช้</h1>
    <p>รายชื่อผู้ใช้</p>

    <div class="modal fade bs-example-modal-lg input-dialog" tabindex="-1" data-focus-on="input:first">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" name="editForm" id="editForm" role="form" action="<?php echo URL; ?>user/" method="post">
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true"><span>&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Form Input Data</h4>
                    </div>
                    <div class="modal-body">
                        <div id="formAlert"></div>
                        <div class="form-group" >
                            <label class="control-label col-sm-2" for="div_person_id">CID :</label>
                            <div class="col-sm-7" id="div_person_id" name="div_person_id">
                                <input type="text" id="person_id" name="person_id" class="form-control" autocomplete="off" disabled="disabled"/>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-sm-2" for="div_person_name">ชื่อ-นามสกุล :</label>
                            <div class="col-sm-7" id="div_person_name" name="div_person_name">
                                <input type="text" id="person_name" name="person_name" class="form-control" autocomplete="off" disabled="disabled"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="div_office_id">QIT NAME :</label>
                            <div class="col-sm-8" id="div_office_id" name="div_office_id">
                                <select class="form-control selectpicker selectpicker-live-search" id="office_id" name="office_id" >
                                    <?php
                                    foreach ($this->getQIT as $value) {
                                        echo "<option value='{$value[ward_id]}' >{$value[ward_name]}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="div_productivity_depart_id">หน่วยงาน :</label>
                            <div class="col-sm-8" id="div_productivity_depart_id" name="div_productivity_depart_id">
                                <select class="form-control selectpicker selectpicker-live-search" id="productivity_depart_id" name="productivity_depart_id" >
                                    <?php
                                    echo "<option value='0' >ไม่ได้ระบุ</option>";
                                    foreach ($this->getDepart as $value) {
                                        echo "<option value='{$value[depart_id]}' >{$value[depart_name]}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- selectpicker  <div class="form-group" id="div_person_status" name="div_person_status">
                            <label class="col-sm-2 control-label" for="show_depart_id">สิทธิ :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="show_person_id" name="show_person_id">
                                    <option value="0">--ทุกสิทธิ--</option>
                        <?php
//foreach ($this->getVar as $value) {
//$selected = like_match('%user%', $value['value']);
//echo "<option value=$selected>ผู้ใช้</option>";
//echo "<option value='{$value['var']}'>{$value['value']}</option>";
//echo "<option value='[staff]'>ผู้ตรวจสอบข้อมูล</option>";
//echo "<option value='[admin]'>ผู้ดูแลระบบ</option>";
//}
                        ?>
                                    
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="div_show_person_id">สิทธิ :</label>
                            <div class="col-sm-8" >
                                <select class="form-control selectpicker" id="show_person_id" name="show_person_id"  multiple>
                                    <?php
                                    foreach ($configList as $value) {
                                        echo "<option value='$value'>$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!--                        <div class="form-group">
                                                    <label class="control-label col-sm-2" for="div_show_person_id">สิทธิ :</label>
                                                    <div class="col-sm-10" >
                                                        <div class="panel panel-info">
                                                            <div class="panel-body">
                                                                <div class="row">
                        <?php
                        foreach ($configList as $value) {
                            echo "<div class='col-sm-2 col-lg-4'>";
                            echo "<input type='checkbox' class='bswitch' data-label-width='100' data-label-text='$value' name='test' value='$value' />";
                            echo "</div>";
                        }
                        ?>    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->

                    </div> <br /><br /><br />


                    <div class="modal-footer">
                        <button type="submit" id="btn_submit" class="btn btn-lg btn-primary">Save
                            <span class="glyphicon glyphicon-off"></span>
                        </button>
                        <button type="button" id="btn_reset" class="btn btn-lg btn-danger">Reset
                            <span class="glyphicon glyphicon-repeat"></span>
                        </button>
                    </div>

                </form>
            </div>    
        </div>
    </div> 


    <div class="modal fade bs-example-modal-lg frm-choose-person" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="130px">CID</th>
                            <th width="280px">NAME</th>
                            <th>DEPARTMENT</th>
                            <th style="text-align: center;" width="100px">CHOOSE</th>
                        </tr>
                    </thead>
                    <tbody id="select_person_data">            
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="form-horizontal">  
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group has-feedback" id="div_search">
                                <label class="col-sm-2 control-label" for="search">ค้นหา :</label>
                                <div class="col-md-10">
                                    <input type="text" id="search" name="search" class="form-control" />
                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <!--            <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="tech_filter_status">สถานะการใช้งาน :</label>
                                            <div class="radio radio-info radio-inline" >
                                                <input type="radio" id="tech_filter_status_0" name="tech_filter_status" value="all" checked />
                                                <label for="tech_filter_status_0"> แสดงทั้งหมด </label>
                                            </div>
                                            <div class="radio radio-info radio-inline" >
                                                <input type="radio" id="tech_filter_status_1" name="tech_filter_status" value="use" />
                                                <label for="tech_filter_status_1"> ใช้งาน </label>
                                            </div>
                                            <div class="radio radio-info radio-inline" >
                                                <input type="radio" id="tech_filter_status_2" name="tech_filter_status" value="no_use" />
                                                <label for="tech_filter_status_2"> ไม่ใช้งาน </label>
                                            </div>
                                        </div>
                                    </div>                
                                </div>          -->
                </div>
            </div>
            <div class="pagin" align="right" style="margin: -20px 10px;"></div>
        </div>
    </div>

    <div id="listings" class="container">
    </div>
    <div >
        <p>host:=[<?= DB_USER_HOST ?>] db_name:=[<?= DB_USER_NAME ?>] tb_name:=[personal] office:=[personal.officd_id] </p>
    </div>

</div>


