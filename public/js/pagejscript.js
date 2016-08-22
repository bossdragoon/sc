/*
 * 
 * Initialize global functions, variables or widgets
 * to run at every page
 */


/*==================
 * 
 * Bootstrap DIALOG 
 * 
 ===================*/
var delConfirmDialog = new BootstrapDialog({
    title: 'Delete data',
    message: 'Do you want to delete this data?',
    type: BootstrapDialog.TYPE_DANGER, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
    closable: true, // <-- Default value is false
    draggable: false, // <-- Default value is false
    size: BootstrapDialog.SIZE_WIDE,
    buttons: [{
            id: 'del-btn-confirm',
            label: 'Delete it',
            cssClass: 'btn-lg btn-danger',
            icon: 'glyphicon glyphicon-trash'
        }, {
            id: 'del-btn-cancel',
            label: 'Cancel',
            cssClass: 'btn-lg',
            action: function (dialogItself) {
                dialogItself.close();
            }
        }]
});

var saveConfirmDialog = new BootstrapDialog({
    title: 'Save data',
    message: 'Do you want to Save this data?',
    type: BootstrapDialog.TYPE_DANGER, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
    closable: true, // <-- Default value is false
    draggable: false, // <-- Default value is false
    size: BootstrapDialog.SIZE_WIDE,
    buttons: [{
            id: 'save-btn-confirm',
            label: 'Save it',
            cssClass: 'btn-lg btn-danger',
            icon: 'glyphicon glyphicon-trash'
        }, {
            id: 'del-btn-cancel',
            label: 'Cancel',
            cssClass: 'btn-lg',
            action: function (dialogItself) {
                dialogItself.close();
            }
        }]
});


var alertDialog = new BootstrapDialog({
    title: 'Error',
    message: '',
    size: BootstrapDialog.SIZE_WIDE,
    type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
    buttons: [{
            id: 'alert-btn-cancel',
            label: 'Close',
            cssClass: 'btn-lg',
            action: function (dialogItself1) {
                dialogItself1.close();
            }
        }]
});

/*==================
 * 
 * Alert Panel 
 * 
 ===================*/
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
    } else if (alertType === 'warning') {
        $("#formAlert .alert").addClass("alert-warning");
    } else if (alertType === 'info') {
        $("#formAlert .alert").addClass("alert-info");
    } else if (alertType === 'danger') {
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

/*==================
 * 
 * GLOBALs FUNCTION
 * 
 ===================*/
function todayYMD() {
    //sub function to add a zero in front of numbers<10
    function pad(s) {
        return (s < 10) ? '0' + s : s;
    }

    var d = new Date();
    var curr_day = d.getDate();
    var curr_month = d.getMonth() + 1; //'getMonth' first count at 0=January
    var curr_year = d.getFullYear();
    curr_day = pad(curr_day);
    curr_month = pad(curr_month);
    var curr_date = curr_year + '-' + curr_month + '-' + curr_day;

    var h = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    m = pad(m);
    s = pad(s);
    var curr_time = h + ":" + m + ":" + s;

    var dateYMD = curr_date + " " + curr_time;
    return dateYMD.trim();
}

/* 
 * Custom function to adding commas in number 
 * credits : http://www.mredkj.com/javascript/nfbasic.html
 * */

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function getAllTableData() {

    //use when you want to retrive all text in table row as you click button on that row
    //now loading

    var tableDt = '';
    var $row = $(this).closest("tr"), // Finds the closest row <tr> 
            $tds = $row.find("td");   // Finds all children <td> elements

    $.each($tds, function () {        // Visits every single <td> element
        //                    console.log($(this).text());  // Prints out the text within the <td>
        tableDt += $(this).text() + "\n";
    });
}


/* Form method setting (Komsan Edition) */
function frmMethod1(method, form) {
    var methodname = typeof method === 'undefined' ? 'insert' : method.toLowerCase();
    var formname = typeof form === 'undefined' ? $("form").get(0) : form;

    var meth;
    switch (methodname) {
        case 'insert':
            meth = 'insertByID';
            break;
        case 'edit':
            meth = 'editByID';
            break;
    }

    $(formname).attr({
        "action": document.URL + "/" + meth
        , "data-form-method": methodname
    });
}


/* Form method setting (Mccrayture Edition) */
function frmMethod2(method, form) {
    var methodname = typeof method === 'undefined' ? 'insert' : method.toLowerCase();
    var formname = typeof form === 'undefined' ? $("form").get(0) : form;

    var meth;
    switch (methodname) {
        case 'insert':
            meth = 'xhrInsert';
            break;
        case 'edit':
            meth = 'xhrEditById';
            break;
    }

    $(formname).attr({
        "action": document.URL + "/" + meth
        , "data-form-method": methodname
    });
}


/*======================================
 * Testing Javascript Class
 * @param {type} name
 * @param {type} age
 * @param {type} txt
 * @returns {jsClass}
 ======================================*/
var jsClass = function (name, age, txt) {
    //Property declaration (this.) :: this.property_name
    this.Name = name;
    this.Age = age;
    this.Textbox = txt;
    //when you want to private variable, use "var" instead of "this"
    var intro = "Hello";

    //Method declaration :: this.method_name = function(){ /*..code..*/ }
    this.GetInfo = function () {
        return intro + "\nName : " + this.Name + "\nAge : " + this.Age + "\nText : " + this.Textbox;
    };

    /*
     * How to use
     * declare : test = new jsClass("Phuwin",27,"Hello world!!");
     * change value : test.Name = "Boss";
     * call method : test.GetInfo();
     * insert new property or method by declare "prototype" : test.prototype.birthday = "22/11/2531" 
     */
    
};



function findIndexOfStr(str, char) {
    var n = str.indexOf(char);
    return n;
}

function callUserType(user_type) {
    var str = '';
    var type = 'user';

    str = user_type;
    str.trim();

    if (findIndexOfStr(str, '[admin]') !== -1) {
        type = 'admin';
    } else if (findIndexOfStr(str, '[staff]') !== -1) {
        type = 'staff';
    } else {
        type = 'user';
    }

    return type;

}

/*=======================
 * callMenuTop
 * 
 * @param {type} dept
 * @returns {undefined}
 =======================*/

/*==================
 * 
 * Bootstrap SELECT 
 * 
 ===================*/

//----this script must run in document.ready  for initial selectpicker after rendering element with class
$(function () {
    $('.selectpicker')
            .addClass("show-tick")
            .filter('.selectpicker-live-search')
            .each(function () {
                $(this).attr("data-live-search", "true");
            })
            .selectpicker({size: 5, showIcon: true});


    function resetSelect() {
        $('form select').selectpicker('render');
    }

    console.log('user_type:=' + $('#user_type').val());



});


function public_check_user_session() {
    var user_session = $('#user_session').val();
    return user_session;

}

function public_callMonth() {
    console.log('Test fnc in pageJscript...');

}

function numberFormat(val, decimalPlaces) {
    var multiplier = Math.pow(10, decimalPlaces);
    var number = (Math.round(val * multiplier) / multiplier).toFixed(decimalPlaces);

    return number;


}

function arrCpy(arrSrc, arrDis) {
    arrDis.length = 0;
    for (var i = 0; i < arrSrc.length; i++) {
        arrDis.push(arrSrc[i]);
    }
}


function isNumber(o) {
    return !isNaN(o - 0) && o !== null;
}


function findValueOfArr(arrData, key) {
    var valData = 0;
    for (var i = 0; i < arrData.length; i++) {
        if (arrData[i].items_code === key) {
            valData = arrData[i].data_value;
        }
    }
    return valData;
}

function findKeyOfArr(arrData, key) {
    var valKey = false;

    //console.log('arrData.length:='+arrData.length);

    for (var i = 0; i < arrData.length; i++) {
        //console.log('  items_code:='+arrData[i].items_code +'  key:='+ key);
        if (arrData[i].items_code === key) {
            valKey = true;
            break;
        } else {
            valKey = false;
        }

    }
    return valKey;
}

function findIndexOfStr(str, char) {
    var n = str.indexOf(char);
    return n;
}


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
    } else if (alertType === 'warning') {
        $("#formAlert .alert").addClass("alert-warning");
    } else if (alertType === 'info') {
        $("#formAlert .alert").addClass("alert-info");
    } else if (alertType === 'danger') {
        $("#formAlert .alert").addClass("alert-danger");
    }

    $("#formAlert span.txtAlert").html(alertTxt);

}

function isNumberDisplay(n) {
    if (isNumber(n) === false) {
        return 0;
    } else {
        return n;
    }
}

function formatCurrency(val) {
    if (val === "" || val === null || val === "NULL")
        return val;

    //Split Decimals
    var arrs = val.toString().split(".");
    //Split data and reverse
    var revs = arrs[0].split("").reverse().join("");
    var len = revs.length;
    var tmp = "";
    for (i = 0; i < len; i++) {
        if (i > 0 && (i % 3) === 0) {
            tmp += "," + revs.charAt(i);
        } else {
            tmp += revs.charAt(i);
        }
    }

    //Split data and reverse back
    tmp = tmp.split("").reverse().join("");
    //Check Decimals
    if (arrs.length > 1 && arrs[1] !== undefined) {
        tmp += "." + arrs[1];
    }
    return tmp;
}

function bankFunction(num) {
    return num;

}

function convertDateToShortTextMonth(date) {
    //2016-07-01
    var month1 = '';
    var month = 0;
    var str = date;

    str = str.trim();
    month1 = str.substr(str.length - 5, 2);
    month1 = month1.trim();

    if (month1 === '01') {
        month = 'ม.ค.';
    } else if (month1 === '02') {
        month = 'ก.พ.';
    } else if (month1 === '03') {
        month = 'มี.ค.';
    } else if (month1 === '04') {
        month = 'เม.ย.';
    } else if (month1 === '05') {
        month = 'พ.ค.';
    } else if (month1 === '06') {
        month = 'มิ.ย.';
    } else if (month1 === '07') {
        month = 'ก.ค.';
    } else if (month1 === '08') {
        month = 'ส.ค.';
    } else if (month1 === '09') {
        month = 'ก.ย.';
    } else if (month1 === '10') {
        month = 'ต.ค.';
    } else if (month1 === '11') {
        month = 'พ.ย.';
    } else if (month1 === '12') {
        month = 'ธ.ค.';
    } else {
        month = '';
    }

    return month; //ก.ค.
}


/* sessionTimeout ปิดเพราะมันนับเวลาตลอด
 $.sessionTimeout({
 message: 'Your session will be locked in one minute.',
 keepAliveUrl: 'index',
 logoutUrl: 'login/logout',
 redirUrl: 'login/logout',
 warnAfter: 120000,
 redirAfter: 240000
 });
 
 */