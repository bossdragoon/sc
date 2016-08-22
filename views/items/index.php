<?php
//$this->view->js = array('public/js/pagejscript.js');

$User = Session::get('User');
$active = ' class="active"';
?>

<div class="container">
    <h1>จัดการรายการอุปกรณ์</h1>
    <p>รายการอุปกรณ์</p>

    <div class="modal fade bs-example-modal-lg input-dialog" tabindex="-1" data-focus-on="input:first">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" name="editForm" id="editForm" role="form" action="<?php echo URL; ?>productForm/" method="post">
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true"><span>&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Form Input Data</h4>
                    </div>
                    <div class="modal-body">
                        <div id="formAlert"></div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="div_items_type">TYPE NAME :</label>
                            <div class="col-sm-7" id="div_items_type" name="div_items_type">
                                <select class="form-control " id="items_type" name="items_type">
                                    <?php
                                    foreach ($this->getItemsTypeY as $value) {
                                        echo "<option value='{$value[items_type_id]}' >{$value[items_type_name]}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group" >
                            <label class="control-label col-sm-2" for="div_items_id">ID :</label>
                            <div class="col-sm-7" id="div_items_id" name="div_items_id">
                                <input type="text" id="items_id" name="items_id" class="form-control" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-sm-2" for="div_items_name">NAME :</label>
                            <div class="col-sm-7" id="div_items_name" name="div_items_name">
                                <input type="text" id="items_name" name="items_name" class="form-control" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="div_status">STATUS :</label>
                            <div class="col-sm-7" id="div_status" name="div_status">
                                <select class="form-control" id="status" name="status">
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

    <div class="form-horizontal">  
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                             <div class="form-group has-feedback" id="div_group_select_items_type">
                                <label class="control-label col-sm-2" for="div_select_items_type">TYPE NAME :</label>
                                <div class="col-sm-10" id="div_select_items_type" name="div_select_items_type">
                                    <select class="form-control" id="select_items_type" name="select_items_type">
                                        <?php
                                        foreach ($this->getItemsTypeY as $value) {
                                            echo "<option value='{$value[items_type_id]}' >{$value[items_type_name]}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group has-feedback" id="div_search">
                                <label class="col-sm-2 control-label" for="search">ค้นหา :</label>
                                <div class="col-md-10">
                                    <input type="text" id="search" name="search" class="form-control" />
                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                </div>
                            </div>  
                        </div>

                        <div class="col-md-2">
                            <button type="button" id="btn_add_new" class="btn btn-warning btn-block" data-toggle="modal" data-target=".bs-example-modal-lg">
                                <span class="glyphicon glyphicon-plus"></span><br />Add New
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="pagin" align="right" style="margin: -20px 10px;"></div>

        </div>
    </div>

    <div id="listings" class="container"></div>

</div>


