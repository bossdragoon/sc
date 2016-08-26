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
    var arrItems = [];
    var maxIndex = 0;
    var alertChk;
    var visiblePages_Items = 10;
    var perPage_Items = 10;

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
                select_dept = $('#select_dept').val();

        var data = {
            'perPage': perPage,
            'keyword': keyword,
            'select_dept': select_dept,
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
                select_dept = $('#select_dept').val();

        var data = {
            'perPage': perPage,
            'keyword': keyword,
            'select_dept': select_dept,
            'supply_mode': mode
        };

        $.get('supply/getListings', data, function (o) {
            var strTable = "";
            var color = "";
            var id = 0;
            var j = 0;
            var cnt_items = "";
            var supply_consignee_time = "";
            var supply_consignor_time = "";
            var supply_divider_time = "";
            var supply_consignor2_time = "";
            $('#listings').empty();

            console.log(o);
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
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + o[i]['supply_consignee'] + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + supply_consignee_time + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + o[i]['supply_consignor'] + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + supply_consignor_time + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + o[i]['supply_divider'] + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + supply_divider_time + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + o[i]['supply_consignor2'] + '</label></td>'
                        + '<td align="left" title="" id="' + i + '<label id="' + i + '" >' + supply_consignor2_time + '</label></td>'
                        + ' ';

                strTable += '</tr>';
            }

            $('#listings').append(strTable);

        }, 'json');

    }

    function alertHide() {
        $("#formAlert").hide();
    }

    /*** Edit and Delete Button ***/
    $('#listings')
            .on('click', ".edit", function () {
                callItemsStatusY();
                $('.input-dialog').modal("toggle");

                editItem = $(this);

                $("#btn_clear").hide();
                $("#btn_reset").show();

                clearEditForm();
                var id = $(this).attr('rel');
                console.log("id:=" + id);
                $.get('productItems/getByID', {'id': id}, function (o) {

                    $('#items_code').prop("readonly", true);
                    $('#items_code').val(o[0].items_code);
                    $('#items_name').val(o[0].items_name);
                    $('#items_type').val(o[0].items_type);
                    $('#items_formula').val(o[0].items_formula);
                    $('#items_form').prop("disabled", true);
                    $('#items_form').val(o[0].items_form);
                    $('#items_form_input').val(o[0].items_form_input);
                    $('#items_form_input_readonly').val(o[0].items_form_input_readonly);
                    $('#items_font_bold').val(o[0].items_font_bold);
                    $('#items_index').val(o[0].items_index);
                    $('#items_status').val(o[0].items_status);

                    tmp_items_code = $('#items_code').val();
                    tmp_items_name = $('#items_name').val();
                    tmp_items_type = $('#items_type').val();
                    tmp_items_formula = $('#items_formula').val();
                    tmp_form_code = $('#form_code').val();
                    tmp_items_form = $('#items_form').val();
                    tmp_items_form_input = $('#items_form_input').val();
                    tmp_items_form_input_readonly = $('#items_form_input_readonly ').val();
                    tmp_items_font_bold = $('#items_font_bold').val();
                    tmp_items_index = $('#items_index').val();
                    tmp_items_status = $('#items_status').val();

                    $('#form_name').focus();
                    checkItemsType();
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

            })
            .on('click', ".up", function () {
                var id = $(this).attr('rel');
                var index = $(this).attr('index');

                console.log('click up...');
                if ((index * 1) > 1) {

                    $.get('productItems/getItemsIndex', {
                        'index': index, 'items_form': $('#select_form').val(), 'event': 'up'
                    }, function (o) {
                        arrCpy(o, arrItems);
                        //console.log(arrItems);
                    }, 'json');

                    upItemsIndex(id, 'up');

                } else {
                    alert('เลื่อน index ไม่ได้อยู่บนสุดแล้ว');
                }

                return false;
            })
            .on('click', ".down", function () {
                console.log('click down...');
                var id = $(this).attr('rel');
                var index = $(this).attr('index');

                console.log('click down...index:=' + index + ' maxIndex:=' + maxIndex);
                if ((index * 1) < (maxIndex * 1)) {

                    $.get('productItems/getItemsIndex', {
                        'index': index, 'items_form': $('#select_form').val(), 'event': 'down'
                    }, function (o) {
                        arrCpy(o, arrItems);
                        //console.log(arrItems);
                    }, 'json');

                    upItemsIndex(id, 'down');

                } else {
                    alert('เลื่อน index ไม่ได้อยู่ล่างสุดแล้ว');
                }

                return false;

            })
            ;


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



    function clearEditForm() {
        alertHide();
        //$('#items_code').prop("readonly", false);
        $('#items_code').val("");
        $('#items_name').val("");
        $('#items_type').val("");
        $('#items_formula').val("");
        $('#items_form').val("");
        $('#items_form_input').val("");
        $('#items_form_input_readonly').val("");
        $('#items_font_bold').val("");
        $('#items_index').val("");
        $('#items_status').val("");
        newData = false;

    }


    $('#btn_reset').on('click', function () {

        $('#items_code').val(tmp_items_code);
        $('#items_name').val(tmp_items_name);
        $('#items_type').val(tmp_items_type);
        $('#items_formula').val(tmp_items_formula);
        $('#items_form').val(tmp_items_form);
        $('#items_form_input').val(tmp_items_form_input);
        $('#items_form_input_readonly').val(tmp_items_form_input_readonly);
        $('#items_font_bold').val(tmp_items_font_bold);
        $('#items_index').val(tmp_items_index);
        $('#items_status').val(tmp_items_status);

    });


    $('#btn_add_new').on('click', function () {
        clearEditForm();
        newData = true;
        $("#btn_clear").show();
        $("#btn_reset").hide();
        $('#items_code').val("NewCode!");
        $('#items_code').prop("readonly", true);
        $('#items_form').val($('#select_form').val());
        $('#items_form').prop("disabled", true);
        checkItemsType();
        callItemsStatusY();

    });


    $('#btn_clear').on('click', function () {
        clearEditForm();

    });

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
