$(function () {

    checkDivTechStatus();
    var perPage = 10;
    var cPage = 0;
    var visiblePages = 5;
    var delay = 1000; //1 seconds
    var timer;
    //var curDataPerson = $('#data_person').val();

    $(".bswitch").bootstrapSwitch({
        onText: 'เลือก',
        offText: 'ไม่เลือก',
        offColor: 'danger'
    });

    callData($('#search').val());

    function callData(search, curPage) {
        cPage = curPage;
        $.post('user/Pagination', {'search': search, 'perPage': perPage}, function (o) {
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
        //var data_person = person;
        cPage = curPage;
        $.get('user/getListings', {'search': search, 'perPage': perPage, 'curPage': curPage}, function (o) {
            var strTable = "";
            //console.log(o);
            $('#listings').html('');

            strTable += '<table class = "table table-striped table-bordered table-condensed"> \n\
                        <thead> \n\
                        <tr> \n\
                        <th> CID </th>  \n\
                        <th> NAME </th>     \n\
                        <th> STATUS </th>    \n\
                        <th> OFFICE </th>     \n\
                        <th> MANAGE </th>   \n\
                        </tr>   \n\
                        </thead>    \n\
                        <tbody> ';

            for (var i = 0; i < o.length; i++) {
//                alert(i);

                strTable += '<tr>';
                strTable += '<td>' + o[i].person_id + '</td>';
                strTable += '<td>' + (o[i].prefix + o[i].firstname + ' ' + o[i].lastname) + '</td>';
                //strTable += '<td>' + (o[i].Supply_system === "[user]" ? "ผู้ใช้งาน" : o[i].Supply_system === "[staff]" ? "ผู้ตรวจสอบข้อมูล" : "ผู้ดูแลระบบ") + '</td>';
                strTable += '<td>' + o[i].Supply_system + '</td>';
                strTable += '<td>' + o[i].office + '</td>';
                strTable += '<td align="center">'
                        //+'<div class="btn-group">'
                        + '<a class="edit btn btn-info" rel="' + o[i].person_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        + ' '
                        //+ '<a class="del btn btn-danger" rel="' + o[i].person_id + '" data-technician-name="' + (o[i].prefix + o[i].firstname + ' ' + o[i].lastname) + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                        //+'</div>';
                        + '</td>';
                strTable += '</tr>';
            }

            strTable += '</tbody>\n\
                    </table>';
            $('#listings').append(strTable);

        }, 'json');

    }
    /* Edit and Delete Button */
    $('#listings')
            .on('click', ".edit", function () {
                $('.input-dialog').modal("toggle");
                editItem = $(this);
                //var data_person = $(this).attr('data_person');
                var id = $(this).attr('rel');
                $.post('user/getByID', {'id': id}, function (o) {
                    $('#person_id').val(o[0].person_id);
                    $('#person_name').val(o[0].prefix + o[0].firstname + ' ' + o[0].lastname);
                    $('#office_id').val(o[0].office_id);
                    $('#productivity_depart_id').val(o[0].productivity_depart_id);
                    console.log('productivity_depart_id:='+o[0].productivity_depart_id);
//                    $('#show_person_id').val(o[0].Supply_system);
                    setCheckBoxValue(o[0].Supply_system);
                    $('#office_id, #productivity_depart_id').selectpicker('refresh');

                    $('#div_person_name').show();
                    $('#person_id').focus();
                }, 'json');
                return false;
            })
            .on('click', ".del", function () {
                delItem = $(this);
                var id = $(this).attr('rel');

                delConfirmDialog.realize();
                delConfirmDialog.setMessage("ต้องการลบเจ้าหน้าที่เทคนิค \"" + $(this).attr("data-technician-name") + "\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function () {
                    $.post('user/deleteByID', {'id': id}, function (o) {
                        if (o.chk) {
                            delItem.empty();
                        } else {
                            alertDialog.setMessage('Primary Key is already use. Cannot Delete !!!.');
                            alertDialog.open();
                        }
                        callData($('#item_type_id_Filter').val());
                        delConfirmDialog.close();
                    }, 'json'); // not use return json data
                });
                delConfirmDialog.open();
                return false;
            });

    $('#search').on('keyup', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {

            $('.cls').empty();
            $('#select_service_data').empty();
            if ($('#search').val() === '') {
                callData('%');
            } else {
                callData($('#search').val());

                Session_searchText = $('#search').val();
                '<%Session["temp"] = "' + Session_searchText + '"; %>';
            }
        }, delay);
    });


    $('#item_type_id_Filter').on('change', function () {
        callData($('#item_type_id_Filter').val());
    });


    $('#div_tech_cid').bind('keypress', function (e) {
        if (e.which === 32) {//space bar
            $('.modal').modal('show');
        }
        ResetEditForm();
    });

//    function centerModal() {
//    $(this).css('display', 'block');
//    var $dialog = $(this).find(".modal-dialog");
//    var offset = ($(window).height() - $dialog.height()) / 2;
//    // Center modal vertically in window
//    $dialog.css("margin-top", offset);
//}
//
//    $('.modal').on('show.bs.modal', centerModal);
//    $(window).on("resize", function () {
//        $('.modal:visible').each(centerModal);
//    });

/*    $('#btn_submit').on('click', function () {
        var person_id = $("#person_id").val();
        var person_name = $("#person_name").val();

        if (person_id !== "" && person_name !== "") {
            $('#editForm').attr("action", "user/updatePerson");
            $('#editForm').submit();

        } else {
            alertInit('danger', 'ผิดพลาด! ไม่สามารถเพิ่มหรือแก้ไขข้อมูลได้');
            alertShow();
        }
        return false;
    });

    $('#editForm').submit(function () {
        var url = $(this).attr('action');
        var data = $(this).serialize();
        
        return false;
        alertInit('success', 'แก้ไขข้อมูลสิทธิเจ้าหน้าที่เรียบร้อย');

        $.post(function () {
            callData($('#show_person_id').val());
        });

        clearEditForm();
        return false;
    });

    $("#show_person_id").on('change', function () {


    }); */
    
        $('#btn_submit').on('click', function () {
        var person_id = $("#person_id").val();
        var person_name = $("#person_name").val();
        var show_person_id = $("#show_person_id").val();

        if (person_id !== "" && person_name !== "" && show_person_id !== "") {

            console.log("updatePerson");
            $.post('user/updatePerson', {
                'person_id': $('#person_id').val(),
                'person_name': $('#person_name').val(),
                'office_id': $('#office_id').val(),
                'productivity_depart_id': $('#productivity_depart_id').val(),
                'Supply_system': $('#show_person_id').val()
                
            }, function (o) {

                if (o.sta === 'update') {
                    if (o.result === true) {
                        alert('อัพเดตข้อมูลสำเร็จ.');
                    } else {
                        alert('อัพเดตข้อมูลไม่สำเร็จ.');
                    }
                    $(".close").click();
                    callData($('#search').val(),cPage);
                }

            }, 'json');


        }  else {
            console.log("else");
            alertInit('danger', 'ผิดพลาด! ไม่สามารถเพิ่มหรือแก้ไขข้อมูลได้...');
            alertShow();

        }
        return false;

    });

    /*$('#select_person').on('change', function () {
     console.log('select_person:=' + $('#select_person').val());
     select_person = $('#select_person').val();
     if (select_person !== 0) {
     curDataDept = select_person;
     } else {
     curDataDept = $('#data_person').val();
     }
     
     
     });*/

    function callDataPerson(search) {
        $.post('user/Pagination', {'search': search, 'perPage': perPage_Person}, function (o) {
            $('.pagin-person').empty();
            if (o.allPage > 1) {
                $('.pagin-person').append('<ul id="pagination-person" class="pagination-sm"></ul>');
                $('#pagination-person').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages_Person,
                    onPageClick: function (event, page) {
                        $('.cls-person').empty();
                        callGetPersonData(search, page);
                        return false;
                    }
                });
            }
            callGetPersonData(search, 1);
        }, 'json');
    }

    function callGetPersonData(search, curPage) {
        $.get('user/getPerson', {'search': search, 'perPage': perPage_Person, 'curPage': curPage}, function (o) {
            for (var i = 0; i < o.length; i++) {
                if (o[i].expire === '1') {
                    danger = 'warning';
                } else {
                    danger = '';
                }
                $('#select_person_data').append('<tr class="cls-person ' + danger + '"><td>' + o[i].person_id + '</td>'
                        + '<td>' + o[i].pname + o[i].fname + ' ' + o[i].lname + '</td>'
                        + '<td>' + o[i].office + '</td>'
                        + '<td align="center"><a class="choose-person" rel="' + o[i].person_id + '" data-person_name="' + o[i].pname + o[i].fname + ' ' + o[i].lname + '" href="#">Choose</a></td>'
                        + '</tr>'
                        );
            }

            $('.choose-person').on('click', function () {
                $('#technician_cid').val($(this).attr('rel'));
                $('#tech_name').val($(this).attr('data-person_name'));
//                $('.modal').modal('hide');
                $('.frm-choose-person').modal('hide');
            });
        }, 'json');
    }

    $('#choose').on('click', function () {
        $('.cls').empty();
        callData('');
    });

    $('#choose_search').on('keyup', function () {
        $('.cls').empty();
        callData(this.value);
    });

    $('#btn_reset,#show_dialog').on('click', function () {
        alertHide();
        clearEditForm();
        //$('#tech_status').val('1');//.checkboxX("refresh") if jMobile
        //return false;
    });

    $("#tech_status").on("change", function () {
        if ($(this).prop("checked") === true) {
            $(this).val(1);
        }
        else {
            $(this).val(0);
        }
    });


    /*==============================
     * Reset Form
     ===============================*/
    function ResetEditForm() {
        $('#technician_cid').val("");
        $('#tech_name').val("");
        $('#technician_username').val("");
        $('#technician_password').val("");
        $('#tech_status').val(1);
//        $('#div_tech_status').hide();

        $("#show_person_id option").prop("selected", false);
    }

    function checkDivTechStatus() {
        if ($('#tech_status').val() === '') {
            $('#div_tech_status').hide();
            $('#tech_status').val(1);
        } else {
            $('#div_tech_status-group').show();
        }
    }


    /*==============================
     * Alert box
     ===============================*/
    /* Create alert for show above Form */
    function alertInit(alertType, alertTxt) {
        alertTxt = (typeof alertTxt === 'undefined') ? '...' : alertTxt;
        $("#formAlert").html(''); //clear

        var txtAlert = '<div class="alert alert-dismissible" role="alert" >' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<span class="txtAlert"></span>' +
                '</div>';
        $("#formAlert").html(txtAlert);

        if (alertType === 'success') {
            $("#formAlert .alert").addClass("alert-success");
        }
        else if (alertType === 'warning') {
            $("#formAlert .alert").addClass("alert-warning");
        }
        else if (alertType === 'info') {
            $("#formAlert .alert").addClass("alert-info");
        }
        else if (alertType === 'danger') {
            $("#formAlert .alert").addClass("alert-danger");
        }

        $("#formAlert span.txtAlert").html(alertTxt);

    }
    function alertShow() {
        $("#formAlert").show();
    }
    function alertHide() {
        $("#formAlert").hide();
    }

    function calcFormulaByArr(arrData) {
        //alert('in calcFormulaByArr');
        var str = '';
        var newStr = '';
        var strCode = '';
        var strCodeFormula = '';
        var valueOfCode = 0;
        var indexStart = -1;
        var indexEnd = -1;
        //console.log(arrData);
        //alert('function calcFormulaByArr!');
        for (var i = 0; i < arrData.length; i++) {

            if (arrData[i].items_formula !== '') {
                str = arrData[i].items_formula;
                strCodeFormula = arrData[i].items_code;
                while (str.indexOf('[') >= 0) {
                    str.trim();
                    indexStart = findIndexOfStr(str, '[');
                    indexEnd = findIndexOfStr(str, ']');
                    strCode = substrCodeOfString(str, indexStart, indexEnd);
                    //valueOfCode = findValueOfArr(arrData, strCode);
                    //newStr = str.replace('[' + strCode + ']', valueOfCode);
                    //alert('str:=' + str + ',   newStr:=' + newStr);
                    //str = newStr;
                    alert(strCode);
                }

                //var b = eval("2 + 2");  return 4
                arrData[i].data_value = eval(str);

                $('#' + strCodeFormula + '').val(numberFormat(eval(str), 2));
                //alert(strCodeFormula + ':= eval str:=' + eval(str));
            }

        }
        //console.log(arrData);

    }


    function findIndexOfStr(str, char) {
        var n = str.indexOf(char);
        return n;
    }


    function substrCodeOfString(str, indexStart, indexEnd) {
        str = str.trim();
        str = str.substr(indexStart + 1, (indexEnd - indexStart - 1));
        return str;

    }


    function findValueOfArr(arrData, key) {
        var valData = 0;
        for (var i = 0; i < arrData.length; i++) {
            if (arrData[i].items_code === key) {
                valData = arrData[i].data_value;
                //alert(key+':='+arrData[i].data_value);
            }
        }
        //alert(key + ', valData:=' + valData);
        return valData;
    }

    function extractBracketList(strWithBracket) {

        var str = strWithBracket;
        var arrResult = [];

        while (str.indexOf('[') >= 0) {
            str.trim();
            var indexStart = findIndexOfStr(str, '[');
            var indexEnd = findIndexOfStr(str, ']');

            var strCode = substrCodeOfString(str, indexStart, indexEnd);

            arrResult.push("[" + strCode + "]");
            str = str.substr(indexEnd + 1);
        }
        return arrResult;

    }
    function setCheckBoxValue(chval) {

        var arrConfig = [];

        if (typeof chval === 'string') {
            arrConfig = extractBracketList(chval);
        } else {
            arrConfig = chval.slice();
        }

//        var arrConfig = [];
//        $('#show_person_id').each(function (i, selected) {
//            arrConfig[i] = $(selected).text();
//        });

        $("#show_person_id option").prop("selected", false);
        var configList = arrConfig.join(',');
        $.each(configList.split(","), function (i, e) {
            $("#show_person_id option[value='" + e + "']").prop("selected", true);
        });

        $("#show_person_id").selectpicker('refresh');


    }

});

