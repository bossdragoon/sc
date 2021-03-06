$(function () {

    console.log('Refresh...');
    //checkDivTechStatus();
    var perPage = 10;
    var cPage = 1;
    var visiblePages = 5;
    var delay = 1000; //1 seconds
    var timer;
    var newData = false;
    var arrItemsStatusY = [];
    var editItem;
    var arrSupplyHead = new Array(2);
    var arrSupplyItems = new Array(2);
    var maxIndex = 0;
    var user_type;
    var visiblePages_Items = 10;
    var perPage_Items = 10;
    var mode;

    $('#new_supply_items_order_type').val('Normal Change');
    user_type = callUserType($('#user_type').val());
    
    if (user_type === 'user') {
        $('#select_shift').prop("disabled", true);
    }

    $('#group_select_dept').hide();
    $('#div_search').hide();

    if ($('#username').val() === 'komsan') {
        $('#inlineRadio2').prop('checked', true);
        $('#mainForm').removeClass('container');
        $('#mainForm').addClass('form-horizontal');
    }

    $('#inlineRadio1').on('change', function () {
        $('#mainForm').removeClass('form-horizontal');
        $('#mainForm').addClass('container');
    });

    $('#inlineRadio2').on('change', function () {
        $('#mainForm').removeClass('container');
        $('#mainForm').addClass('form-horizontal');
    });

    $('#select_date').datepicker({
        format: "yyyy-mm-dd",
        language: "th",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        orientation: "top"

    });

    $('#supply_date, #supply_consignee_date, #supply_consignor_date, #supply_divider_date, #supply_consignor2_date').datepicker({
        format: "yyyy-mm-dd",
        language: "th",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        orientation: "top"
    });
    //supply_consignor
    $('#supply_consignee_time, #supply_consignor_time, #supply_divider_time, #supply_consignor2_time').timepicker({
        timeFormat: "H:i",
        minuteStep: 1,
        setTime: new Date(),
        template: 'modal',
        appendWidgetTo: 'body',
        showSeconds: false,
        showMeridian: false,
        defaultTime: false
    });

    highlightSelButton();
    callData();


    /*======================================================================
     * SUPPLY
     ======================================================================*/
    $('#supply_mode').find(":button").on("click", function () {

        var $btn = $(this);

        //set value
        $("#select_supply_mode").val($btn.data("mode"));

        //make highlight
        highlightSelButton();

        callData();
    });

    function highlightSelButton() {

        mode = ($("#select_supply_mode").val() !== "" ? $("#select_supply_mode").val() : "send");

        //remove highlight all button
        $('#supply_mode').find(":button").filter(function (index) {
            return $(this).hasClass("btn-primary");
        }).removeClass("btn-primary").addClass("btn-default");

        //highlight
        $('#supply_mode').find(":button").filter(function (index) {
            return ($(this).data("mode") === mode ? true : false);
        }).removeClass("btn-default").addClass("btn-primary");
    }

    function callData() {

        mode = ($("#select_supply_mode").val() !== "" ? $("#select_supply_mode").val() : "send");

        var keyword = $('#search').val(),
                //select_dept = $('#select_dept').val(),
                select_shift = $('#select_shift').val();

//        var data = {
//            'perPage': perPage,
//            'keyword': keyword,
//            //'select_dept': select_dept,
//            'select_shift': select_shift,
//            'supply_mode': mode
//        };

        callDataItem(cPage, mode);

//        $.get('supply/pagination', data, function (o) {
//            $('.pagin').empty();
//            if (o.allPage > 1) {
//                $('.pagin').append('<ul id="pagination" class="pagination-sm"></ul>');
//                $('#pagination').twbsPagination({
//                    startPage: cPage,
//                    totalPages: o.allPage,
//                    visiblePages: visiblePages,
//                    onPageClick: function (event, page) {
//                        //$('.cls').empty();
//                        cPage = page;
//                        callGetData(page);
//                        return false;
//                    }
//                });
//            }
//            
//            $('#pagination').hide();
//        }, 'json');

    }

    function callDataItem(page, mode, depart) {

        mode = (mode !== "undefined" ? mode : "send");
        var color = '';
        var supply_date = $('#select_date').val();
        var supply_shift = $('#select_shift').val();
        depart = $('#user_dept').val();

        console.log('user_type:=' + user_type);
        var data = {
            'supply_depart': depart,
            'user_type': user_type,
            'supply_date': supply_date,
            'supply_shift': supply_shift,
            'supply_mode': mode
        };

        $.get('supply/getListings', data, function (o) {
            var strTable = "";
            var j = 0;
            var cnt_items = "";
            var depart_or_shift_name = "";
            var management = "";
            var supply_consignee_name = "";
            var supply_consignee_time = "";
            var supply_consignor_name = "";
            var supply_consignor_time = "";
            var supply_divider_name = "";
            var supply_divider_time = "";
            var supply_consignor2_name = "";
            var supply_consignor2_time = "";
            $('#listingsDataSupply').empty();

            if (user_type === 'user') {
                depart_or_shift_name = '';
            } else {
                depart_or_shift_name = '';
            }

            //console.log(o);
            for (var i = 0; i < o.length; i++) {
                j = i + 1;
                x = j % 2;
                if (o[i]['step_status'] === '0') {
                    color = 'style="color:#AB031F;"';

                } else if (o[i]['step_status'] === '1') { //
                    color = 'style="color:#034113;"';

                } else if (o[i]['step_status'] === '2') { //B21954
                    color = 'style="color:#193AB2;"';

                } else if (o[i]['step_status'] === '3') { //B21954
                    color = 'style="color:#84510B;"';

                } else if (o[i]['step_status'] === '4') { //B21954
                    color = 'style="color:#0E0C0C;"';

                } else {
                    color = 'style="color:#8B8385;"';

                }

                if (user_type === 'user') {
                    depart_or_shift_name = o[i]['supply_shift'];
                } else {
                    depart_or_shift_name = o[i]['depart_name'];
                }

                if (o[i].supply_id !== '0') {
                    management = '<td>'
                            + '<a class="edit btn btn-info" supply_id="' + o[i].supply_id + '" supply_date="' + o[i].supply_date + '" supply_shift="' + o[i].supply_shift + '" supply_depart="' + o[i].supply_depart + '" depart_name="' + o[i].depart_name + '"href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true" title="แก้ไขรายการ"></span></a>'
                            //+ '<a class="del btn btn-danger" rel="' + o[i].supply_id + '" data-items-name="' + o[i].items_name + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true" title="ลบรายการ"></span></a>'
                            + '<a class="print_preview btn btn-success" href="supply/print_preview/' + o[i].supply_id + '" target="_blank" title="พิมพ์"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>'
                            + '</td>';
                } else {
                    management = '<td>'
                            + '<a class="edit btn btn-info" supply_id="' + o[i].supply_id + '" supply_date="' + o[i].supply_date + '" supply_shift="' + o[i].supply_shift + '" supply_depart="' + o[i].supply_depart + '" depart_name="' + o[i].depart_name + '"href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true" title="แก้ไขรายการ"></span></a>'
                            + '</td>';
                }

                //color = 'style="background-color:' + o[i].status_color + ';"';
                strTable += '<tr class="dataTr' + o[i].data_id + ' cls" ' + color + ' >';
                //style="background-color:#FFFFCC;" 
                cnt_items = (o[i]['cnt_items'] >= 1 ? o[i]['cnt_items'] : "");
                supply_consignee_name = (o[i]['supply_consignee_name'] !== null ? o[i]['supply_consignee_name'] : "");
                supply_consignee_time = (o[i]['supply_consignee_time'] !== null ? o[i]['supply_consignee_time'] : "");
                supply_consignor_name = (o[i]['supply_consignor_name'] !== null ? o[i]['supply_consignor_name'] : "");
                supply_consignor_time = (o[i]['supply_consignor_time'] !== null ? o[i]['supply_consignor_time'] : "");
                supply_divider_name = (o[i]['supply_divider_name'] !== null ? o[i]['supply_divider_name'] : "");
                supply_divider_time = (o[i]['supply_divider_time'] !== null ? o[i]['supply_divider_time'] : "");
                supply_consignor2_name = (o[i]['supply_consignor2_name'] !== null ? o[i]['supply_consignor2_name'] : "");
                supply_consignor2_time = (o[i]['supply_consignor2_time'] !== null ? o[i]['supply_consignor2_time'] : "");

                strTable += ''
                        + '<td align="right" title="" > ' + j + ' </td>'
                        + '<td align="left" title="" id="' + i + '" > ' + depart_or_shift_name + ' </td>'
                        + '<td align="left" title="" style="display: none;" id="supply_shift-' + i + '" ><label id="' + i + '" >' + o[i]['supply_shift'] + '</label></td>'
                        + '<td align="right" title="" id="' + i + '">' + cnt_items + '</td>'
                        + '<td align="left" title="" id="' + i + '" >' + supply_consignee_name + '</td>'
                        + '<td align="left" title="" id="' + i + '" >' + supply_consignee_time + '</td>'
                        + '<td align="left" title="" id="' + i + '" >' + supply_consignor_name + '</td>'
                        + '<td align="left" title="" id="' + i + '" >' + supply_consignor_time + '</td>'
                        + '<td align="left" title="" id="' + i + '" >' + supply_divider_name + '</td>'
                        + '<td align="left" title="" id="' + i + '" >' + supply_divider_time + '</td>'
                        + '<td align="left" title="" id="' + i + '" >' + supply_consignor2_name + '</td>'
                        + '<td align="left" title="" id="' + i + '" >' + supply_consignor2_time + '</td>'
                        + management
                        + ' ';

                strTable += '</tr>';
            }

            $('#listingsDataSupply').append(strTable);
            //$("#th-tbSupply-supply_shift").css("display", "");   /****แสดงคอลัมน์*******/
        }, 'json');

    }

    //delete supply_items
    $('#tables_data_supply_items').on('click', '.del', function () {
        if (confirm("ต้องการลบรายการรายการอุปกรณ์!\n กดปุ่ม OK หรือ Cancel.")) {
            var curIndex = $(this).attr('rel');
            arrSupplyItems[curIndex].manage = 'delete';
            showTableSupplyItemsData(arrSupplyItems);
            return true;
        } else {
            return false;
            exit();
        }
        return false;
    });

    function alertHide() {
        $("#formAlert").hide();
    }

    function getOrderTypeJSon() {
        $.get('supply/getOrderTypeJSon', {}, function (o) {
            //console.log(o);
        }, 'json');
        return false;
    }

    function duplicateCheckSupplyItemsInArray(arrSupplyItems, currCode, currType) {
        console.log('currType:=' + currType);
        for (var i = 0; i < arrSupplyItems.length; i++) {
            console.log('arrSupplyItems[' + i + '].supply_items_order_type:=' + arrSupplyItems[i].supply_items_order_type);
            if (arrSupplyItems[i].items_id === currCode && arrSupplyItems[i].supply_items_order_type === currType && arrSupplyItems[i].manage !== 'delete') {
                return true;
            }
        }
        return false;
    }

    /* when click button "ADD" */
    $('#btn_add_new').on('click', function () {
        console.log('new_items_id :=' + $('#new_items_id').val());

        if (duplicateCheckSupplyItemsInArray(arrSupplyItems, $('#new_items_id').val(), $('#new_supply_items_order_type').val()) === true) {
            alertInit('danger', 'ผิดพลาด! รายการอุปกรณ์ถูกเลือกไปแล้ว');
            alertShow();
            return false;

        } else if ($('#new_items_id').val() === null) {
            alertInit('danger', 'ผิดพลาด! คุณต้องเลือกอุปกรณ์...ก่อน');
            alertShow();

        } else {

            var e = document.getElementById("new_items_id");
            var new_items_name = e.options[e.selectedIndex].text;
            var i = arrSupplyItems.length;

            try {
            } catch (err) {
            }

            arrSupplyItems[i] = {
                "supply_items_id": $('#new_items_id').val(),
                "supply_id": $('#supply_id').val(),
                "items_id": $('#new_items_id').val(),
                "items_name": new_items_name,
                "supply_items_send": $('#new_supply_items_send').val(),
                "supply_items_receive": $('#new_supply_items_receive').val(),
                "supply_items_divide": $('#new_supply_items_divide').val(),
                "supply_items_remain": $('#new_supply_items_remain').val(),
                "supply_items_order_type": $('#new_supply_items_order_type').val(),
                "hos_guid": '',
                "manage": 'new'
            };
            clearPanelNewSupplyItems();
        }

        showTableSupplyItemsData(arrSupplyItems);
        $('.frm-choose-parts').modal("toggle");

    });

    function showTableSupplyItemsData(arrSupplyItems) {
        $('#tables_data_supply_items').empty();
        var dropdownType = '';
        var selectedNormalChange = '';
        var selectedAddNewItems = '';
        getOrderTypeJSon();
        for (var i = 0; i < arrSupplyItems.length; i++) {
            if (arrSupplyItems[i].supply_items_order_type === 'Normal Change') {
                selectedNormalChange = 'selected';
                selectedAddNewItems = '';
            } else {
                selectedNormalChange = '';
                selectedAddNewItems = 'selected';
            }


            if (arrSupplyItems[i].manage !== 'delete') {
                dropdownType = '<select class="form-control " id="supply_items_order_type-' + i + '" name="supply_items_order_type-' + i + '">'
                        + ' <option value="Normal Change" ' + selectedNormalChange + '>Normal Change</option>'
                        + ' <option value="Add New Items" ' + selectedAddNewItems + '>Add New Items</option>'
                        + ' </select>';

                $('#tables_data_supply_items').append('<tr class="cls-supplyItemsManage itemsRow-' + i + '" align="center"><td data-title="#">' + (i + 1) + '</td>'
                        + '<td data-title="รายการ" align="left" ><input type="hidden" id="items_id-' + i + '"  value="' + arrSupplyItems[i].items_id + '">' + arrSupplyItems[i].items_name + '</td>'
                        + '<td align="right" ><input type="number" maxlength="10" class="text-right" id="supply_items_send-' + i + '"  value="' + arrSupplyItems[i].supply_items_send + '"  required></input> </td>'
                        + '<td align="right" ><input type="number" maxlength="4" class="text-right" id="supply_items_receive-' + i + '" value="' + arrSupplyItems[i].supply_items_receive + '"  required></input> </td>'
                        + '<td align="right" ><input type="number" maxlength="4" class="text-right" id="supply_items_divide-' + i + '" value="' + arrSupplyItems[i].supply_items_divide + '"  required></input> </td>'
                        + '<td align="right" ><input type="number" maxlength="4" class="text-right" id="supply_items_remain-' + i + '" value="' + arrSupplyItems[i].supply_items_remain + '"  required></input> </td>'
                        + '<td >' + dropdownType + '</td>'
                        + '<td data-title="ลบ"><a class="del btn btn-sm btn-danger" rel="' + i + '" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> </td>'
                        + '<td data-title="supply_items_id" style="display: none;">' + arrSupplyItems[i].supply_items_id + '</td>'
                        + '<td data-title="hos_guid" style="display: none;">' + arrSupplyItems[i].hos_guid + '</td>'
                        + '<td data-title="manage" style="display: none;">' + arrSupplyItems[i].manage + '</td>'
                        //  + '<td ><input type="text" class="text-right" id="supply_items_order_type-' + i + '" value="' + arrSupplyItems[i].supply_items_order_type + '" disabled ></input> </td>'
                        + '</tr>'
                        );
            }
        }
    }

    /*** update array supply_items_send ***/
    $('#tables_data_supply_items').on('change', 'input[id^="supply_items_send-"]', function () {
        var nId = $(this).attr('id').substring(18);
        //console.log('nId:=' + nId);
        arrSupplyItems[nId].supply_items_send = $(this).val();
        if (arrSupplyItems[nId].manage !== 'new') {
            arrSupplyItems[nId].manage = 'edit';
        }
        $("#arrSupplyItems").val(JSON.stringify(arrSupplyItems));
        //console.log(arrSupplyItems);
        return false;
    });


    /*** update array supply_items_receive ***/
    $('#tables_data_supply_items').on('change', 'input[id^="supply_items_receive-"]', function () {
        var nId = $(this).attr('id').substring(21);
        //console.log('nId:=' + nId);
        arrSupplyItems[nId].supply_items_receive = $(this).val();
        if (arrSupplyItems[nId].manage !== 'new') {
            arrSupplyItems[nId].manage = 'edit';
        }
        $("#arrSupplyItems").val(JSON.stringify(arrSupplyItems));
        //console.log(arrSupplyItems);
        return false;
    });


    /*** update array supply_items_divide ***/
    $('#tables_data_supply_items').on('change', 'input[id^="supply_items_divide-"]', function () {
        var nId = $(this).attr('id').substring(20);
        //console.log('nId:=' + nId);
        arrSupplyItems[nId].supply_items_divide = $(this).val();
        if (arrSupplyItems[nId].manage !== 'new') {
            arrSupplyItems[nId].manage = 'edit';
        }
        $("#arrSupplyItems").val(JSON.stringify(arrSupplyItems));
        //console.log(arrSupplyItems);
        return false;
    });

    /*** update array supply_items_divide ***/
    $('#tables_data_supply_items').on('change', 'input[id^="supply_items_remain-"]', function () {
        var nId = $(this).attr('id').substring(20);
        //console.log('nId:=' + nId);
        arrSupplyItems[nId].supply_items_remain = $(this).val();
        if (arrSupplyItems[nId].manage !== 'new') {
            arrSupplyItems[nId].manage = 'edit';
        }
        $("#arrSupplyItems").val(JSON.stringify(arrSupplyItems));
        //console.log(arrSupplyItems);
        return false;
    });

    /*** update array supply_items_order_type ***/
    $('#tables_data_supply_items').on('change', 'select[id^="supply_items_order_type-"]', function () {
        var nId = $(this).attr('id').substring(24);
        //console.log('nId:=' + nId);
        arrSupplyItems[nId].supply_items_order_type = $(this).val();
        if (arrSupplyItems[nId].manage !== 'new') {
            arrSupplyItems[nId].manage = 'edit';
        }
        $("#arrSupplyItems").val(JSON.stringify(arrSupplyItems));
        //console.log(arrSupplyItems);
        return false;
    });

    $('#btn_submit_supply').on('click', function () {
        if (confirm("คุณต้องการบันทึกข้อมูล!\n กดปุ่ม OK หรือ Cancel.")) {

            var data = [];
            data[0] = {
                "supply_id": $("#supply_id").val(),
                "supply_date": $("#supply_date").val(),
                "supply_shift": $("#supply_shift").val(),
                "supply_depart": $("#supply_depart").val(),
                "supply_consignee": $("#supply_consignee").val(),
                "supply_consignee_time": $("#supply_consignee_date").val() + " " + $("#supply_consignee_time").val(),
                "supply_consignor": $("#supply_consignor").val(),
                "supply_consignor_time": $("#supply_consignor_date").val() + " " + $("#supply_consignor_time").val(),
                "supply_divider": $("#supply_divider").val(),
                "supply_divider_time": $("#supply_divider_date").val() + " " + $("#supply_divider_time").val(),
                "supply_consignor2": $("#supply_consignor2").val(),
                "supply_consignor2_time": $("#supply_consignor2_date").val() + " " + $("#supply_consignor2_time").val(),
                "bank": "bank"
            };

            arrSupplyHead = data;

            console.log(arrSupplyHead);
            //console.log(arrSupplyItems);
            console.log(arrSupplyItems.length);

            if (arrSupplyItems.length > 0) {

                $.post('supply/insertSupply', {'arrSupplyHead': arrSupplyHead, 'arrSupplyItems': arrSupplyItems}, function (o) {
                    if (o.resultUpdateSupply === true) {
                        $('.close').click();
                        callData();
                    } else {
                        alert("บันทึกข้อมูลไม่สำเร็จ");
                    }

                }, 'json');
            } else {
                alertInit('danger', 'ผิดพลาด! ไม่มีรายการเบิก-จ่าย');
                alertShow();
            }


        } else {
            return false;
            exit();
        }
        return false;
    });


    /*** Edit and Delete Button ***/
    $('#listingsDataSupply')
            .on('click', ".edit", function () {
               
                $('#lb_supply_consignee').hide();
                $('#lb_supply_consignor').hide();
                $('#lb_supply_divider').hide();
                $('#lb_supply_consignor2').hide();

                $('.frm-Management-Data').modal("toggle");
                $("#headData").collapse('show');

                editItem = $(this);

                $("#btn_clear").hide();
                $("#btn_reset").show();

                clearPanelNewSupplyHead();
                clearPanelNewSupplyItems();
                var supply_id = $(this).attr('supply_id');

                var supply_date;
                var supply_shift;
                var supply_depart = $(this).attr('supply_depart');
                var depart_name = $(this).attr('depart_name');

                //console.log('1.supply_depart in edit items :=' + supply_depart);

                if (supply_id !== "0") {
                    supply_date = $(this).attr('supply_date');
                    supply_shift = $(this).attr('supply_shift');

                    $.get('supply/getSupplyByID', {'supply_id': supply_id, 'supply_date': supply_date, 'supply_shift': supply_shift}, function (o) {
                        //console.log(o);
                        if (o.length > 0) {

                            $('#label_supply_id').text(o[0].supply_id);
                            $('#label_supply_depart').text(o[0].depart_name);

                            $('#supply_id').val(o[0].supply_id);
                            $('#supply_date').val(o[0].supply_date);
                            $('#supply_date').datepicker('update', o[0].supply_date);

                            $('#supply_shift').val(o[0].supply_shift);
                            $('#supply_depart').val(o[0].supply_depart);

                            $('#supply_consignee').val(o[0].supply_consignee);
                            $('#supply_consignee_date').val(o[0].supply_consignee_date);
                            $('#supply_consignee_date').datepicker('update', o[0].supply_consignee_date);
                            $('#supply_consignee_time').val(o[0].supply_consignee_time);

                            $('#supply_consignor').val(o[0].supply_consignor);
                            $('#supply_consignor_date').val(o[0].supply_consignor_date);
                            $('#supply_consignor_date').datepicker('update', o[0].supply_consignor_date);
                            $('#supply_consignor_time').val(o[0].supply_consignor_time);

                            $('#supply_divider').val(o[0].supply_divider);
                            $('#supply_divider_date').val(o[0].supply_divider_date);
                            $('#supply_divider_date').datepicker('update', o[0].supply_divider_date);
                            $('#supply_divider_time').val(o[0].supply_divider_time);

                            $('#supply_consignor2').val(o[0].supply_consignor2);
                            $('#supply_consignor2_date').val(o[0].supply_consignor2_date);
                            $('#supply_consignor2_date').datepicker('update', o[0].supply_consignor2_date);
                            $('#supply_consignor2_time').val(o[0].supply_consignor2_time);
                            $('#supply_date').prop("readonly", true);
                            $('#supply_shift').prop("disabled", true);
                            $('#supply_depart').prop("disabled", true);


                            console.log('mode:=' + mode);
                             
                            if (((mode === 'send') || (mode === '')) && ($('#supply_consignee').val() === '')) {
                                $('#supply_consignee').val($('#userPerson_id').val());
                                $('#supply_consignee_date').datepicker('setDate', new Date());
                                $('#supply_consignee_time').timepicker('setTime', new Date());
                                $('#lb_supply_consignee').show();

                            }

                            if ((mode === 'receive') && ($('#supply_consignor').val() === '')) {
                                $('#supply_consignor').val($('#userPerson_id').val());
                                $('#supply_consignor_date').datepicker('setDate', new Date());
                                $('#supply_consignor_time').timepicker('setTime', new Date());
                                 $('#lb_supply_consignor').show();
               
                            }

                            if ((mode === 'divide') && ($('#supply_divider').val() === '')) {
                                $('#supply_divider').val($('#userPerson_id').val());
                                $('#supply_divider_date').datepicker('setDate', new Date());
                                $('#supply_divider_time').timepicker('setTime', new Date());
                                $('#lb_supply_divider').show();
                
                            }

                            if ((mode === 'receive2') && ($('#supply_consignor2').val() === '')) {
                                $('#supply_consignor2').val($('#userPerson_id').val());
                                $('#supply_consignor2_date').datepicker('setDate', new Date());
                                $('#supply_consignor2_time').timepicker('setTime', new Date());
                                $('#lb_supply_consignor2').show();
                                
                            }

                            $('.selectpicker').selectpicker('render'); //**** วางไว้ล่างสุด *****//
                        }

                    }, 'json');
                } else {
                    //console.log('2.supply_depart in edit items :=' + supply_depart);
                    if (user_type !== 'user') {
                        supply_date = $('#select_date').val();
                        supply_shift = $('#select_shift').val();
                    } else {
                        supply_date = $(this).attr('supply_date');
                        supply_shift = $(this).attr('supply_shift');
                    }

                    $('#supply_id').val(supply_id);
                    $('#supply_date').val(supply_date);
                    $('#supply_shift').val(supply_shift);
                    $('#supply_depart').val(supply_depart);
                    $('#label_supply_id').text('new ID');
                    $('#label_supply_depart').text(depart_name);

                    $('#supply_date').prop("readonly", true);
                    $('#supply_shift').prop("disabled", true);
                    $('#supply_depart').prop("disabled", true);
                    
                    if ((mode === 'send') && ($('#supply_consignee').val() === null)) {
                        $('#supply_consignee').val($('#userPerson_id').val());
                        $('#supply_consignee_date').datepicker('setDate', new Date());
                        $('#supply_consignee_time').timepicker('setTime', new Date());
                        $('#lb_supply_consignee').show();

                    }

                    $('.selectpicker').selectpicker('render');

                }

                $.get('supply/getSupplyItemsByID', {'supply_id': supply_id}, function (m) {

                    arrCpy(m, arrSupplyItems);
                    // console.log(arrSupplyItems);
                    showTableSupplyItemsData(arrSupplyItems);

                }, 'json');

                return false;

            })
            .on('click', ".del", function () {
                delItem = $(this);
                var id = $(this).attr('rel');
                var index = $(this).attr('index');

                delConfirmDialog.realize();
                delConfirmDialog.setMessage("ต้องการลบ Form \"" + $(this).attr("data-form-name") + "\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function () {

                    console.log("id:=" + id + ' index:=' + index);
                    getDataSlingItemsIndex(index, 'del');
                    //return false;
                    $.post('productItems/deleteByID', {
                        'id': id
                    }, function (o) {

                        if (o.sta === 'delete') {
                            if (o.result === true) {
                                alert('ลบข้อมูลสำเร็จ.');
                                getDataSlingItemsIndex(index, 'del');

                            } else {
                                alert('ลบข้อมูลไม่สำเร็จ.');
                            }
                            $(".close").click();
                            //callData($('#search').val(), cPage, $('#select_form').val());

                        }

                    }, 'json');

                });
                delConfirmDialog.open();
                return false;

            });

    function clearPanelNewSupplyHead() {
        //console.log('in function clearPanelNewSupplyItems');
        //alertHide();

        $('#supply_consignee').val('0');
        $('#supply_consignee_date').val('');
        $('#supply_consignee_time').val('0:00');
        $('#supply_consignor').val('0');
        $('#supply_consignor_date').val('');
        $('#supply_consignor_time').val('0:00');
        $('#supply_divider').val('0');
        $('#supply_divider_date').val('');
        $('#supply_divider_time').val('0:00');
        $('#supply_consignor2').val('0');
        $('#supply_consignor2_date').val('');
        $('#supply_consignor2_time').val('0:00');

    }

    function clearPanelNewSupplyItems() {
        //console.log('in function clearPanelNewSupplyItems');
        alertHide();

        $('#new_items_id').val('0');
        $('#new_supply_items_send').val("0");
        $('#new_supply_items_receive').val("0");
        $('#new_supply_items_divide').val("0");
        $('#new_supply_items_remain').val("0");
        $('#new_supply_items_order_type').val("Normal Change");
        $('.selectpicker').selectpicker('render');
    }

    $('#btn_calData').on('click', function () {

        callData();
    });

    function activeOneDay() {
        callData();
        //return true;
    }


});
