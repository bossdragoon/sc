$(function () {

    console.log('Refresh...');
    //checkDivTechStatus();
    var perPage = 20;
    var cPage = 0;
    var visiblePages = 5;
    var delay = 1000; //1 seconds
    var timer;
    var newData = false;
    var editItem;
    var tmp_items_type_id;
    var tmp_items_type_name;
    var tmp_status;


    callData($('#search').val());

    function callData(search, curPage) {
        cPage = curPage;
        $.post('itemsType/Pagination', {'search': search, 'perPage': perPage}, function (o) {
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
        cPage = curPage;
        $.get('itemsType/getListings', {'search': search, 'perPage': perPage, 'curPage': curPage}, function (o) {
            var strTable = "";
            //console.log(o);
            $('#listings').html('');

            strTable += '<table class = "table table-striped table-bordered table-condensed"> \n\
                        <thead> \n\
                        <tr> \n\
                        <th class="text-center col-md-1"> ID </th>  \n\
                        <th class="text-center col-md-9"> ชื่อชนิดอุปกรณ์ </th>     \n\
                        <th class="text-center col-md-1"> สถานะ </th>     \n\
                        <th class="text-center col-md-1"> MANAGE </th>   \n\
                        </tr>   \n\
                        </thead>    \n\
                        <tbody> ';

            for (var i = 0; i < o.length; i++) {

                strTable += '<tr>';
                strTable += '<td class="text-center">' + o[i].items_type_id + '</td>';
                strTable += '<td>' + o[i].items_type_name + '</td>';
                strTable += '<td class="text-center">' + (o[i].status === 'Y' ? '<span class="label label-success">ใช้งาน</span>' : '<span class="label label-danger">ไม่ใช้</span>') + '</td>';
                strTable += '<td>'
                        + '<div class="btn-group" id="div_manage" >'
                        + '<a class="edit btn btn-info" rel="' + o[i].items_type_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        + ' '
                        + '<a class="del btn btn-danger" rel="' + o[i].items_type_id + '" data-form-name="' + (o[i].items_type_id + ' :: ' + o[i].items_type_name) + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                        + '</div>'
                        + '</td>';
                strTable += '</tr>';
            }

            strTable += '</tbody></table>';
            $('#listings').append(strTable);

        }, 'json');

    }


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

                $.get('itemsType/getByID', {'id': id}, function (o) {

                    //$('#items_type_id').prop("readonly", true);
                    $('#items_type_id').val(o[0].items_type_id);
                    $('#items_type_name').val(o[0].items_type_name);
//                    $('#status').val(o[0].status);

                    toggleStatusCB(o[0].status);

                    tmp_items_type_id = $('#items_type_id').val();
                    tmp_items_type_name = $('#items_type_name').val();
//                    tmp_status = $('#status').val();
                    tmp_status = o[0].status;

                    $('#items_type_name').focus();
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
                    $.post('itemsType/deleteByID', {
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
        var items_type_id = $("#items_type_id").val();
        var items_type_name = $("#items_type_name").val();

        if (items_type_id !== "" && items_type_name !== "" && newData === false) {

            console.log("updateByID");
            $.post('itemsType/updateByID', {
                'items_type_id': $('#items_type_id').val(),
                'items_type_name': $('#items_type_name').val(),
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


        } else if (items_type_id !== "" && items_type_name !== "" && newData === true) {

            console.log("insertByID");
            $.post('itemsType/insertByID', {
                'items_type_id': $('#items_type_id').val(),
                'items_type_name': $('#items_type_name').val(),
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
        $('#items_type_id').val("");
        //$('#items_type_id').prop("readonly", false);
        $('#items_type_id').prop("readonly", true);
        $('#items_type_name').val("");
//        $('#status').val("");
        toggleStatusCB();
        newData = false;

    }


    $('#btn_reset').on('click', function () {
        // $('#items_type_id').val(tmp_items_type_id);
        $('#items_type_name').val(tmp_items_type_name);
//        $('#status').val(tmp_status);
        toggleStatusCB(tmp_status);

    });


    $('#btn_add_new').on('click', function () {
        clearEditForm();
        newData = true;
        $('#items_type_id').val('NewCode!');
        //$('#items_type_id').prop("readonly", false);
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
