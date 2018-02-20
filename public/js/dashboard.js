$(function() {
    "use strict";
    //This is for the Notification top right
    $.toast({
        heading: "Welcome to admin panel",
        position: "top-right",
        loaderBg: "#ff6849",
        icon: "info",
        hideAfter: 3500,
        stack: 6
    });

    let chartData = [];
    $.ajax({
        url: "/getChartData",
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json",
        async: false,
        success: function(response) {
            chartData = response.data
        }
    });

    // Dashboard 1 Morris-chart
    Morris.Line({
        element: "morris-area-chart",
        data: chartData,
        xkey: "date",
        ykeys: ["c_week", "p_week"],
        labels: ["This week", "Last week"],
        pointSize: 3,
        fillOpacity: 0,
        pointStrokeColors: ["#00bfc7", "#fb9678"],
        behaveLikeLine: true,
        gridLineColor: "rgba(255, 255, 255, 0.1)",
        lineWidth: 3,
        parseTime:false,
        hideHover: "auto",
        lineColors: ["#00bfc7", "#fb9678"],
        resize: true
    });

    $("#table_dashboard").DataTable({lengthMenu: [[10, 50 ,100, 250, 500, 1000, -1], [10, 50 ,100, 250, 500, 1000, "All"]]});
});