$(function () {

    console.log('Refresh...');
    //checkDivTechStatus();
    var perPage = 10;
    var cPage = 0;
    var visiblePages = 5;
    var delay = 1000; //1 seconds
    var timer;
    var newData = false;
    var editItem;
    var tmp_items_id;
    var tmp_items_name;
    var tmp_items_type;
    var tmp_status;


    callData($('#search').val());

    function callData(search, curPage) {
        var items_type = $('#select_items_type').val();
        cPage = curPage;
        $.post('items/Pagination', {'search': search, 'perPage': perPage, 'items_type': items_type}, function (o) {
            if (curPage <= 0) {
                cPage = curPage;
            }
            $('.pagin').empty();
            $("tr[class^='delTr']").empty();
            //alert('Break...');
            if (o.allPage > 1) {
                $('.pagin').append('<ul id="pagination" class="pagination-sm"></ul>');
                $('#pagination').twbsPagination({
                    totalPages: o.allPage,
                    startPage: cPage,
                    visiblePages: visiblePages,
                    onPageClick: function (event, page) {
                        $('.cls').empty();
                        callGetData(search, page);
                        return false;
                    }
                });
            }
            callGetData(search, cPage);
        }, 'json');
    }

    function callGetData(search, curPage) {
        var items_type = $('#select_items_type').val();
        cPage = curPage;
        $.get('items/getListings', {'search': search, 'perPage': perPage, 'curPage': curPage, 'items_type': items_type}, function (o) {
            var strTable = "";
            //console.log(o);
            $('#listings').html('');

            strTable += '<table class = "table table-striped table-bordered table-condensed"> \n\
                        <thead> \n\
                        <tr> \n\
                        <th class="text-center col-md-1"> ID </th>  \n\
                        <th class="text-center col-md-9"> ชื่ออุปกรณ์ </th>     \n\
                        <th class="text-center col-md-1"> สถานะ </th>     \n\
                        <th class="text-center col-md-1"> MANAGE </th>   \n\
                        </tr>   \n\
                        </thead>    \n\
                        <tbody> ';

            for (var i = 0; i < o.length; i++) {

                strTable += '<tr>';
                strTable += '<td class="text-center">' + o[i].items_id + '</td>';
                strTable += '<td>' + o[i].items_name + '</td>';
                strTable += '<td class="text-center">' + (o[i].status === 'Y' ? '<span class="label label-success">ใช้งาน</span>' : '<span class="label label-danger">ไม่ใช้</span>') + '</td>';
                strTable += '<td>'
                        + '<div class="btn-group" id="div_manage" >'
                        + '<a class="edit btn btn-info" rel="' + o[i].items_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        + ' '
                        + '<a class="del btn btn-danger" rel="' + o[i].items_id + '" data-form-name="' + (o[i].items_id + ' :: ' + o[i].items_name) + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                        + '</div>'
                        + '</td>';
                strTable += '</tr>';
            }

            strTable += '</tbody></table>';
            $('#listings').append(strTable);

        }, 'json');

    }

    $('#select_items_type').on('change', function () {
        callData('', 1, $('#select_form').val());

    });


    function alertHide() {
        $("#formAlert").hide();
    }


    /*** Edit and Delete Button ***/
    $('#listings')
            .on('click', ".edit", function () {
                $('.input-dialog').modal("toggle");

                editItem = $(this);

                $("#btn_clear").hide();
                $("#btn_reset").show();

                clearEditForm();
                var id = $(this).attr('rel');
                console.log("id:=[" + id + ']');

                $.get('items/getByID', {'id': id}, function (o) {

                    //$('#items_type').prop("readonly", true);
                    $('#items_type').prop("disabled", true);
                    $('#items_id').prop("readonly", true);
                    $('#items_id').val(o[0].items_id);
                    $('#items_name').val(o[0].items_name);
                    $('#items_type').val(o[0].items_type);
//                    $('#status').val(o[0].status);

                    toggleStatusCB(o[0].status);

                    tmp_items_id = $('#items_id').val();
                    tmp_items_name = $('#items_name').val();
                    tmp_items_type = $('#items_type').val();
//                    tmp_status = $('#status').val();
                    tmp_status = o[0].status;

                    $('#items_name').focus();
                }, 'json');

                return false;

            })
            .on('click', ".del", function () {
                delItem = $(this);
                var id = $(this).attr('rel');

                delConfirmDialog.realize();
                delConfirmDialog.setMessage("ต้องการลบ Form \"" + $(this).attr("data-form-name") + "\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function () {

                    console.log("deleteByID");
                    $.post('items/deleteByID', {
                        'id': id
                    }, function (o) {

                        if (o.sta === 'delete') {
                            if (o.result === true) {
                                alert('ลบข้อมูลสำเร็จ.');
                            } else {
                                alert('ลบข้อมูลไม่สำเร็จ.');
                            }
                            $(".close").click();
                            callData($('#search').val(), cPage);
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
            // $('#select_service_data').empty();
            if ($('#search').val() === '') {
                callData('%');
            } else {
                callData($('#search').val());

                Session_searchText = $('#search').val();
                '<%Session["temp"] = "' + Session_searchText + '"; %>';
            }
        }, delay);
    });


    $('#btn_submit').on('click', function () {
        var items_id = $("#items_id").val();
        var items_name = $("#items_name").val();

        if (items_id !== "" && items_name !== "" && newData === false) {

            console.log("updateByID");
            $.post('items/updateByID', {
                'items_id': $('#items_id').val(),
                'items_name': $('#items_name').val(),
                'items_type': $('#items_type').val(),
//                'status': $('#status').val()
                'status': ($('#status').bootstrapSwitch('state') ? 'Y' : 'N')
            }, function (o) {

                if (o.sta === 'update') {
                    if (o.result === true) {
                        alert('อัพเดรตข้อมูลสำเร็จ.');
                    } else {
                        alert('อัพเดรตข้อมูลไม่สำเร็จ.');
                    }
                    $(".close").click();
                    callData($('#search').val(), cPage);
                }

            }, 'json');


        } else if (items_id !== "" && items_name !== "" && newData === true) {

            console.log("insertByID");
            $.post('items/insertByID', {
                'items_id': $('#items_id').val(),
                'items_name': $('#items_name').val(),
                'items_type': $('#items_type').val(),
//                'status': $('#status').val()
                'status': ($('#status').bootstrapSwitch('state') ? 'Y' : 'N')
            }, function (o) {

                if (o.sta === 'add') {
                    if (o.result === true) {
                        alert('เพิ่มข้อมูลสำเร็จ.');
                    } else {
                        alert('เพิ่มข้อมูลไม่สำเร็จ.');
                    }
                    $(".close").click();
                    callData($('#search').val(), cPage);
                }

            }, 'json');

        } else {
            console.log("else");
            alertInit('danger', 'ผิดพลาด! ไม่สามารถเพิ่มหรือแก้ไขข้อมูลได้...');
            alertShow();

        }
        return false;

    });


    function clearEditForm() {
        alertHide();
        $('#items_id').val("");
        $('#items_type').prop("readonly", true);
        $('#items_id').prop("readonly", true);
        $('#items_name').val("");
//        $('#status').val("");
        toggleStatusCB();
        newData = false;

    }


    $('#btn_reset').on('click', function () {
        // $('#items_id').val(tmp_items_id);
        $('#items_name').val(tmp_items_name);
//        $('#status').val(tmp_status);
        toggleStatusCB(tmp_status);

    });


    $('#btn_add_new').on('click', function () {
        clearEditForm();
        newData = true;
        $('#items_id').val('NewCode!');
        //$('#items_id').prop("readonly", false);

        $('#items_type').val($('#select_items_type').val());
        $('#items_type').prop("disabled", true);
        $("#btn_clear").show();
        $("#btn_reset").hide();
    });


    $('#btn_clear').on('click', function () {
        clearEditForm();

    });

    $("#status").bootstrapSwitch({
        onColor: 'success',
        offColor: 'danger',
        onText: 'ใช้งาน',
        offText: 'ไม่ใช้'
    });

    function toggleStatusCB(status) {
        var state = (status !== undefined ? status : 'Y');

        if (state === 'Y') {
            $("#status").bootstrapSwitch('state', true);
        } else {
            $("#status").bootstrapSwitch('state', false);
        }

    }

});
