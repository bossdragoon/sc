$(function () {
    getReport();

    function getReport() {
        var form = $(this).get(0);
        var url = 'reports/showSummary';
        var data = {date1: '2015-10-01', date2: '2015-10-21'};

        $.post(url, data, function (o) {
//            $("#reportResult").html(o);
        }, 'json');

        return false;
    }

    $('#show_menu_form').hide();


});