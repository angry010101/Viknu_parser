<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" href="icon.png">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <script
            src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
</head>

<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
<!-- HTML -->
<!-- Example single danger button -->
<div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Choose Event
    </button>
    <div class="dropdown-menu">
        @foreach($events as $event)
            <a class="dropdown-item" href="/marketplace/{{$event->id}}">{{$event->name}} {{$event->year}}</a>
        @endforeach
    </div>
    <h4 class="margin-left-3">Account balance: <b>${{Auth::user()->balance}}</b></h4>
    <h4 class="margin-left-3">Account Id: <b>{{Auth::user()->id}}</b></h4>
</div>
<div id="chartdiv"></div>


<style>
    body { background-color: #30303d; color: #fff; }
    #chartdiv {
        width: 100%;
        height: 500px;
    }
</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/dark.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
    // Themes begin
    am4core.useTheme(am4themes_dark);
    am4core.useTheme(am4themes_animated);
    // Themes end

    var chart = am4core.create("chartdiv", am4charts.XYChart);
    chart.paddingRight = 20;

    chart.dateFormatter.inputDateFormat = "YYYY-MM-dd";

    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    dateAxis.renderer.grid.template.location = 0;

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.tooltip.disabled = true;

    var series = chart.series.push(new am4charts.CandlestickSeries());
    series.dataFields.dateX = "date";
    series.dataFields.valueY = "close";
    series.dataFields.openValueY = "open";
    series.dataFields.lowValueY = "low";
    series.dataFields.highValueY = "high";
    series.simplifiedProcessing = true;
    series.tooltipText = "Open:${openValueY.value}\nLow:${lowValueY.value}\nHigh:${highValueY.value}\nClose:${valueY.value}";

    chart.cursor = new am4charts.XYCursor();

    // a separate series for scrollbar
    var lineSeries = chart.series.push(new am4charts.LineSeries());
    lineSeries.dataFields.dateX = "date";
    lineSeries.dataFields.valueY = "close";
    // need to set on default state, as initially series is "show"
    lineSeries.defaultState.properties.visible = false;

    // hide from legend too (in case there is one)
    lineSeries.hiddenInLegend = true;
    lineSeries.fillOpacity = 0.5;
    lineSeries.strokeOpacity = 0.5;

    var scrollbarX = new am4charts.XYChartScrollbar();
    scrollbarX.series.push(lineSeries);
    chart.scrollbarX = scrollbarX;
    chart.data = <?php echo $charts ?>;
    console.log(<?php echo $charts ?>);

   /* $ajax = $.ajax({
        type: 'GET',
        url: "{{url('marketplace/chart')}}",
        data: '',
        dataType: 'json',
        success: function(data) {
            chart.data = $ajax.responseJSON;
            console.log('ajax: ', $ajax.responseJSON);
        },
        error:function (xhr, ajaxOptions, thrownError) {
            dir(thrownError);
            dir(xhr);
            dir(ajaxOptions);
        }
    })
    */

</script>

<script src="js/plugins.js"></script>
<script src="js/main.js"></script>

</body>

</html>
