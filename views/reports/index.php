<style>
    #activity {
        text-align:center;border:1px solid #ccc;
    }
    #activity td{
        text-align:center;border:1px solid #ccc;
    }
    #footerExport td{
        cursor:pointer;
        text-align:center;border:1px solid #ccc;
        border:none;
    }
</style>
<div class="container">
    <!--<div class="container-fluid">-->
    <!--//    make by Shikaru-->
    <h2>
        <button id="model-back" type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true"><span class="glyphicon glyphicon-home"> เลือกรายงานใหม่</span></button>
        <span id="report-title">ระบบรายงาน</span>
    </h2>
    <?php $logged = Session::get(SESSION_USER); ?>
    <div class="form-horizontal">   

        <!--=================================================  reportList : Start  ======================================================-->
        <div class="panel-group" id="reportList">

            <div class="panel panel-default">
                <div class="panel-heading" onmouseover="this.style.cursor = 'pointer'" data-toggle="collapse" data-target="#collapseSummary">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-target="#collapseSummary"></a>
                        รายงานสรุปต่างๆ
                    </h4>
                </div>
                <div class="panel-body panel-collapse collapse in" id="collapseSummary">
                    <div class='div_click col-xs-12 col-lg-6' rel="SumItemsPerUnit"><span class="glyphicon glyphicon-list-alt"> </span> รายงานจำนวนการเบิก-จ่ายอุปกรณ์</div> 
                    <div class='div_click col-xs-12 col-lg-6' rel="PriceRepairPerMonth"><span class="glyphicon glyphicon-list-alt"> </span> รายงานจำนวนการเบิก-จ่ายอุปกรณ์แยกตามวอร์ด</div>
                    <div class='div_click col-xs-12 col-lg-6' rel="RepairPerUnit"><span class="glyphicon glyphicon-list-alt"> </span> รายงานตามการซ่อมต่อหน่วยงาน</div> 
                    <div class='div_click col-xs-12 col-lg-6' rel="RepairPerMonth"><span class="glyphicon glyphicon-list-alt"> </span> รายงานตามการซ่อมต่อเดือน</div>
                    <div class='div_click col-xs-12 col-lg-6' rel="PartsPerUnit"><span class="glyphicon glyphicon-list-alt"> </span> รายงานการใช้อะไหล่ต่อหน่วยงาน</div> 
                    <div class='div_click col-xs-12 col-lg-6' rel="PartsPerMonth"><span class="glyphicon glyphicon-list-alt"> </span> รายงานการใช้อะไหล่ต่อเดือน</div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" onmouseover="this.style.cursor = 'pointer'" data-toggle="collapse" data-target="#collapseRegister">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-target="#collapseRegister"></a>
                        ทะเบียน
                    </h4>
                </div>
                <div class="panel-body panel-collapse collapse in" id="collapseRegister">
                    <div class='div_click col-xs-12 col-lg-6' rel="RepairRegister"><span class="glyphicon glyphicon-list-alt"> </span> ทะเบียนใบส่งซ่อม</div> 
                    <div class='div_click col-xs-12 col-lg-6' rel="StoreRegister"><span class="glyphicon glyphicon-list-alt"> </span> ทะเบียนอะไหล่ใหม่</div>
                    <div class='div_click col-xs-12 col-lg-6' rel="PartsDrawn"><span class="glyphicon glyphicon-list-alt"> </span> ทะเบียนการเบิกอะไหล่</div>
                    <div class='div_click col-xs-12 col-lg-6' rel="PartsRemaining"><span class="glyphicon glyphicon-list-alt"> </span> ทะเบียนอะไหล่คงเหลือ</div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" onmouseover="this.style.cursor = 'pointer'" data-toggle="collapse" data-target="#collapseOther">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-target="#collapseOther"></a>
                        รายงานอื่นๆ
                    </h4>
                </div>
                <div class="panel-body panel-collapse collapse in" id="collapseOther">
                    <div class='div_click col-xs-12 col-lg-6' rel="RepairOfDepart"><span class="glyphicon glyphicon-list-alt"> </span> รายงานจำนวนการแจ้งซ่อมของแต่ละหน่วยงาน</div> 
                    <div class='div_click col-xs-12 col-lg-6' rel="TechnicianPerformance"><span class="glyphicon glyphicon-list-alt"> </span> รายงานการปฏิบัติงานช่าง</div>
                    <div class='div_click col-xs-12 col-lg-6' rel="RepairPerMonthTechnicianPerformance"><span class="glyphicon glyphicon-list-alt"> </span> รายงานการใช้อะไหล่ต่อเดือนแยกตามการปฏิบัติงานของช่าง</div>
                    <div class='div_click col-xs-12 col-lg-6' rel="ServiceStatusTechnician"><span class="glyphicon glyphicon-list-alt"> </span> รายงานการดำเนินการซ่อมต่อเดือนแยกตามการปฏิบัติงานของช่าง</div>
                </div>
            </div>

        </div>


        <!--=================================================  reportSearch : Start  ======================================================-->
        <div class="panel-group" id="reportSearch">
            <form id="frmSearch" class="form-horizontal" role="form" action="<?= URL; ?>" method="post">
                <input type="hidden" id="report_name" name="report_name" />
                <input type="hidden" name="report-title" id="report-title2" />
                <div class="form-group col-xs-12 col-lg-5" id="div_date1">
                    <label class="control-label col-xs-3 col-lg-3" for="search">วันที่ :</label>
                    <div class="input-group col-xs-9 col-lg-9">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        <input type="text" id="date1" name="date1" class="form-control" value="<?= date('Y-m-') . '01' ?>" />
                    </div>
                </div>
                <div class="form-group col-xs-12 col-lg-5" id="div_date2">
                    <label class="control-label col-xs-3 col-lg-3" for="search">ถึง :</label>
                    <div class="input-group col-xs-9 col-lg-9">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        <input type="text" id="date2" name="date2" class="form-control" value="<?= date('Y-m-d') ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10" id="div_select_dept" name="div_select_dept">
                        <div class="form-group row">
                            <div class="col-lg-10">
                                <select class="form-control " id="select_dept" name="select_dept">
                                    <option value="">- - หน่วยงาน - -</option>
                                    <?php
                                    foreach ($this->getDepart as $value) {
                                        echo "<option value='{$value[depart_id]}' >{$value[depart_name]}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2" id="div_btn_search">
                                 <button type="submit" id="btn_search" class="btn btn-primary col-lg-12">Submit</button> 
                            </div>
                        </div>                        
                    </div>
                </div>
            </form>
        </div>


        <!--=================================================  reportDetail : Start  ======================================================-->
        <form id="frmExport" class="form-horizontal" role="form" action="<?= URL; ?>" method="post" target="_blank">
            <input type="hidden" name="tempTable" id="tempTable" />
            <input type="hidden" name="report-title" id="report-title3" />
            <div id="reportDetail_bt" class="text-right"></div>
            <div class="panel-group">
                <table class="table table-striped table-bordered table-condensed" id="reportDetail"></table>
            </div>
        </form>

    </div>
</div>