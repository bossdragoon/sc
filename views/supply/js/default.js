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
    var tmp_items_code;
    var tmp_items_name;
    var tmp_items_type;
    var tmp_items_formula;
    var tmp_form_code;
    var tmp_items_form;
    var tmp_items_form_input;
    var tmp_items_form_input_readonly;
    var tmp_items_font_bold;
    var tmp_items_index;
    var tmp_items_status;
    var arrSupplyItems = [];
    var maxIndex = 0;
    var alertChk;
    var visiblePages_Items = 10;
    var perPage_Items = 10;


    $('#new_supply_items_order_type').val('Normal Change');

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

    $('#date1').datepicker({
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

    $('#supply_consignee_time, #supply_consignor_tiem, #supply_divider_time, #supply_consignor2_time').timepicker({
        minuteStep: 1,
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

        var mode = ($("#select_supply_mode").val() !== "" ? $("#select_supply_mode").val() : "send");

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

        var mode = ($("#select_supply_mode").val() !== "" ? $("#select_supply_mode").val() : "send");

        var keyword = $('#search').val(),
                //select_dept = $('#select_dept').val(),
                select_shift = $('#select_shift').val();

        var data = {
            'perPage': perPage,
            'keyword': keyword,
            //'select_dept': select_dept,
            'select_shift': select_shift,
            'supply_mode': mode
        };

        $.get('supply/pagination', data, function (o) {
            $('.pagin').empty();
            if (o.allPage > 1) {
                $('.pagin').append('<ul id="pagination" class="pagination-sm"></ul>');
                $('#pagination').twbsPagination({
                    startPage: cPage,
                    totalPages: o.allPage,
                    visiblePages: visiblePages,
                    onPageClick: function (event, page) {
                        //$('.cls').empty();
                        cPage = page;
                        callGetData(page);
                        return false;
                    }
                });
            }
            callDataItem(cPage, mode);
            $('#pagination').hide();
        }, 'json');

    }

    function callDataItem(page, mode) {

        var mode = (mode !== "undefined" ? mode : "send");

        var keyword = $('#search').val(),
                //select_dept = $('#select_dept').val(),
                select_shift = $('#select_shift').val();

        var data = {
            'perPage': perPage,
            'keyword': keyword,
            //'select_dept': select_dept,
            'select_shift': select_shift,
            'supply_mode': mode
        };

        $.get('supply/getListings', data, function (o) {
            var strTable = "";
            var j = 0;
            var cnt_items = "";
            var supply_consignee_time = "";
            var supply_consignor_time = "";
            var supply_divider_time = "";
            var supply_consignor2_time = "";
            $('#listingsDataSupply').empty();

            //console.log(o);
            for (var i = 0; i < o.length; i++) {
                j = i + 1;
                color = 'style="background-color:#FFFFCC;"';
                color = 'style="background-color:' + o[i].status_color + ';"';
                strTable += '<tr class="dataTr' + o[i].data_id + ' cls">';
                //style="background-color:#FFFFCC;" 
                cnt_items = (o[i]['cnt_items'] >= 1 ? o[i]['cnt_items'] : "");
                supply_consignee_time = (o[i]['supply_consignee_time'] !== '0000-00-00 00:00:00' ? o[i]['supply_consignee_time'] : "");
                supply_consignor_time = (o[i]['supply_consignor_time'] !== '0000-00-00 00:00:00' ? o[i]['supply_consignor_time'] : "");
                supply_divider_time = (o[i]['supply_divider_time'] !== '0000-00-00 00:00:00' ? o[i]['supply_divider_time'] : "");
                supply_consignor2_time = (o[i]['supply_consignor2_time'] !== '0000-00-00 00:00:00' ? o[i]['supply_consignor2_time'] : "");
                strTable += ''
                        + '<td align="right"  title="" >' + '<label id="' + i + '" >' + j + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + o[i]['depart_name'] + '</label></td>'
                        + '<td align="right" title="" id="' + i + '">' + '<label id="' + i + '" >' + cnt_items + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + o[i]['supply_consignee_name'] + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + supply_consignee_time + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + o[i]['supply_consignor_name'] + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + supply_consignor_time + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + o[i]['supply_divider_name'] + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + supply_divider_time + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + o[i]['supply_consignor2_name'] + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + supply_consignor2_time + '</label></td>'
                        + '<td>'
                        + '<a class="edit btn btn-info" supply_id="' + o[i].supply_id + '" supply_date="' + o[i].supply_date + '" supply_shift="' + o[i].supply_shift + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true" title="แก้ไขรายการ"></span></a>'
                        + '<a class="del btn btn-danger" rel="' + o[i].supply_id + '" data-items-name="' + o[i].items_name + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true" title="ลบรายการ"></span></a>'
                        + '<a class="print_preview btn btn-success rel="' + o[i].supply_id + '" href="supply/print_preview/' + o[i].supply_id + '" target="_blank" title="พิมพ์"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>'
                        + '</td>'
                        + ' ';

                strTable += '</tr>';
            }

            $('#listingsDataSupply').append(strTable);

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
            console.log(o);
        }, 'json');
        return false;
    }

    function duplicateCheckSupplyItemsInArray(arrSupplyItems, currCode, currType) {
        console.log('currCode:=' + currCode);
        for (var i = 0; i < arrSupplyItems.length; i++) {
            if (arrSupplyItems[i].items_id === currCode && arrSupplyItems[i].supply_items_order_type === currType && arrSupplyItems[i].manage !== 'delete') {
                return true;
            }
        }
        return false;
    }

    /* when click button "ADD" */
    $('#btn_add_new').on('click', function () {
        console.log('new_items_id :='+ $('#new_items_id').val());
        
        if (duplicateCheckSupplyItemsInArray(arrSupplyItems, $('#new_items_id').val()) === true) {
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
                //$('#new_items_id').focus();
                //console.log(err.message);

                // $("#formAlert").show();

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
                        + '<td align="right" ><input type="number" maxlength="4" class="text-right" id="supply_items_send-' + i + '" value="' + arrSupplyItems[i].supply_items_send + '"  required></input> </td>'
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

    /*** Edit and Delete Button ***/
    $('#listingsDataSupply')
            .on('click', ".edit", function () {
                //callItemsStatusY();
                $('.frm-Management-Data').modal("toggle");
                $("#headData").collapse('show');

                editItem = $(this);

                $("#btn_clear").hide();
                $("#btn_reset").show();

                clearPanelNewSupplyItems();
                var supply_id = $(this).attr('supply_id');
                var supply_date = $(this).attr('supply_date');
                var supply_shift = $(this).attr('supply_shift');
                //console.log("supply_id:=" + supply_id+" supply_date:=" + supply_date+" supply_shift:=" + supply_shift);
                $.get('supply/getSupplyByID', {'supply_id': supply_id, 'supply_date': supply_date, 'supply_shift': supply_shift}, function (o) {
                    //console.log(o);
                    $('#label_supply_id').text(o[0].supply_id);
                    $('#label_supply_depart').text(o[0].depart_name);

                    $('#supply_id').val(supply_id);

                    $('#supply_date').prop("readonly", true);
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

                    $('.selectpicker').selectpicker('render');
                    //$('.selectpicker').selectpicker('refresh');
                    //$('#supply_shift').focus();

                }, 'json');

                $.get('supply/getSupplyItemsByID', {'supply_id': supply_id}, function (m) {

                    arrCpy(m, arrSupplyItems);
                    console.log(arrSupplyItems);
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


    $('#search').on('keyup', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {

            $('.cls').empty();
            $('#select_service_data').empty();
            callData();
//            if ($('#search').val() === '') {
//                callData('%');
//            } else {
//                callData($('#search').val());
//
//                Session_searchText = $('#search').val();
//                '<%Session["temp"] = "' + Session_searchText + '"; %>';
//            }
        }, delay);
    });


    $('#btn_submit').on('click', function () {
        if (checkFormula($('#items_formula').val()) === true) {
            var items_code = $("#items_code").val();
            var items_name = $("#items_name").val();
            var items_formula = '';

            if (($('#items_type').val() === 'value') || ($('#items_type').val() === null)) {
                items_formula = "";
                console.log('in items_formula = ""');
            } else {
                items_formula = $('#items_formula').val();
                items_formula.trim();
            }

            if (items_code !== "" && items_name !== "" && newData === false) {

                $.post('productItems/updateByID', {
                    'items_code': $('#items_code').val(),
                    'items_name': $('#items_name').val(),
                    'items_type': $('#items_type').val(),
                    'items_formula': $('#items_formula').val(),
                    'items_form': $('#items_form').val(),
                    'items_form_input': $('#items_form_input').val(),
                    'items_font_bold': $('#items_font_bold').val(),
                    'items_form_input_readonly': $('#items_form_input_readonly').val(),
                    'items_index': $('#items_index').val(),
                    'items_status': $('#items_status').val()

                }, function (o) {

                    if (o.sta === 'update') {
                        if (o.result === true) {
                            alert('อัพเดรตข้อมูลสำเร็จ.');
                        } else {
                            alert('อัพเดรตข้อมูลไม่สำเร็จ.');
                        }
                        $(".close").click();
                        callData($('#search').val(), cPage, $('#select_form').val());
                    }

                }, 'json');


            } else if (items_code !== "" && items_name !== "" && newData === true) {

                $.post('productItems/insertByID', {
                    'items_code': $('#items_code').val(),
                    'items_name': $('#items_name').val(),
                    'items_type': $('#items_type').val(),
                    'items_form': $('#items_form').val(),
                    'items_formula': items_formula,
                    'items_form_input_readonly': $('#items_form_input_readonly').val(),
                    'items_form_input': $('#items_form_input').val(),
                    'items_font_bold': $('#items_font_bold').val(),
                    'items_index': $('#items_index').val(),
                    'items_status': $('#items_status').val()
                }, function (o) {

                    if (o.sta === 'add') {
                        if (o.result === true) {
                            alert('เพิ่มข้อมูลสำเร็จ.');
                        } else {
                            alert('เพิ่มข้อมูลไม่สำเร็จ.');
                        }
                        $(".close").click();
                        callData($('#search').val(), cPage, $('#select_form').val());
                    }

                }, 'json');

            } else {
                alertInit('danger', 'ผิดพลาด! ไม่สามารถเพิ่มหรือแก้ไขข้อมูลได้...');
                alertShow();

            }
            return false;
        }
        return false;

    });



    function clearPanelNewSupplyItems() {
        alertHide();
        $('#new_items_id').val('0');
        $('#new_supply_items_send').val("0");
        $('#new_supply_items_receive').val("0");
        $('#new_supply_items_divide').val("0");
        $('#new_supply_items_remain').val("0");
        $('#new_supply_items_order_type').val("Normal Change");
        $('.selectpicker').selectpicker('render');
    }


//    $('#btn_reset').on('click', function () {
//
//        $('#items_code').val(tmp_items_code);
//        $('#items_name').val(tmp_items_name);
//        $('#items_type').val(tmp_items_type);
//        $('#items_formula').val(tmp_items_formula);
//        $('#items_form').val(tmp_items_form);
//        $('#items_form_input').val(tmp_items_form_input);
//        $('#items_form_input_readonly').val(tmp_items_form_input_readonly);
//        $('#items_font_bold').val(tmp_items_font_bold);
//        $('#items_index').val(tmp_items_index);
//        $('#items_status').val(tmp_items_status);
//
//    });


    $('#choose-items').on('click', function () {
        callDataItems();

    });

    $('#select_form').on('change', function () {
        callData('', 1, $('#select_form').val());
        callItemsStatusY();

    });


    $('#items_type').on('change', function () {
        checkItemsType();

    });


    $('#btn_chk_formula').on('click', function () {
        checkFormula($('#items_formula').val());
        return true;

    });

    function findIndexOfStr(str, char) {
        var n = str.indexOf(char);
        return n;
    }

    function substrCodeOfString(str, indexStart, indexEnd) {
        str = str.trim();
        str = str.substr(indexStart + 1, (indexEnd - indexStart - 1));
        return str;

    }

});
