$(function() {
    clearReport();
    
    $('.div_click').on('click', function() {
        $('#reportList').hide();//,#reportDetail
        $('#reportSearch').show();
        $('#report_name').val($(this).attr('rel'));
        if ($('#report_name').val() === 'PartsRemaining') {
            $('#div_date1 , #div_date2').hide();
        } else {
            $('#div_date1 , #div_date2').show();
        }
        $('#frmSearch').attr('action', 'reports/template/' + $(this).attr('rel'));
        $('#report-title').html($(this).html());
        $('#report-title2').val($(this).html().substring(52)); //subString //<span class="glyphicon glyphicon-list-alt"></span>
        $('#report-title3').val($(this).html().substring(52));
    });
    $('#model-back').on('click', function() {
        clearReport();
    });

    function clearReport() {
        $('#report-title').html('ระบบรายงาน');
        $('#reportList').show();
        $('#reportSearch,#reportDetail,#reportDetail_bt').hide();
        $('#date1').datepicker({
            format: "yyyy-mm-dd",
            language: "th",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            orientation: "top"
        });//.datepicker("setDate", new Date())
        $('#date2').datepicker({
            format: "yyyy-mm-dd",
            language: "th",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            orientation: "top"
        });//.datepicker("setDate", new Date())
    }

    $('#frmSearch').on("submit", function() {
        var form = $(this).get(0);
        var url = $(form).attr('action');
        var data = $(form).serialize();
        $('#reportDetail,#reportDetail_bt').show();

        $.post(url, data, function(o) {
            $('#tempTable').val(o);
            var exbt = '<div class="btn-group"><a class="excelExport btn btn-sm btn-success" href="#">' +
                    '<img src="./public/images/xls.png" height="16" /></a>' +
                    '<a class="excelExport btn btn-sm btn-success" href="#">ส่งออก Excel</a>' +
                    '</div> ' +
                    '<div class="btn-group"><a class="pdfExport btn btn-sm btn-warning" href="#">' +
                    '<img src="./public/images/pdf.png" height="16" /></a>' +
                    '<a class="pdfExport btn btn-sm btn-warning" href="#">ส่งออก PDF</a>' +
                    '</div>';
//            var exbt = '<div class="btn-group"><a class="excelExport btn btn-sm btn-success" href="#">' +
//                    '<img src="./public/images/xls.png" height="16" /></a>' +
//                    '<a class="excelExport btn btn-sm btn-success" href="reports/ExcelExport/' + $.base64.encode(encodeURI(o)) + '" target="_blank">ส่งออก Excel</a>' +
//                    '</div> ' +
//                    '<div class="btn-group"><a class="pdfExport btn btn-sm btn-warning" href="#">' +
//                    '<img src="./public/images/pdf.png" height="16" /></a>' +
//                    '<a class="pdfExport btn btn-sm btn-warning" href="reports/PDFExport/' + $.base64.encode(encodeURI(o)) + '" target="_blank">ส่งออก PDF (ยังใช้งานไม่ได้)</a>' +
//                    '</div>';

            $('#reportDetail_bt').html(exbt);
            $('#reportDetail').html(o);

            $('.excelExport').on("click", function() {
                $('#frmExport').attr('action', 'reports/Export/ExcelExport');
                $('#frmExport').submit();
            });

            $('.pdfExport').on("click", function() {
                $('#frmExport').attr('action', 'reports/Export/PDFExport');
                $('#frmExport').submit();
            });
            
        });

        return false;
    });

});