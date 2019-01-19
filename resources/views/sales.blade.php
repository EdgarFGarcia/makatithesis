@extends('layouts.main')

@section('firstcardtitle')

@endsection

@section('firstcardcontent')
<div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
@endsection


@section('scripts')
<script type="text/javascript">
    var chart = new CanvasJS.Chart("chartContainer", {

        zoomEnabled: true,
        panEnabled: true,
        animateEnabled: true,
        data: [ {
            type: "splineArea",
            xValueType: "label",
            y: "y",
            dataPoints: [] 
        } ] 

    });

    function updateChart(){
        $.getJSON("{{ url('api/getSales') }}", function (data_points) {
        // $.getJSON("https://canvasjs.com/data/gallery/php/bitcoin-price.json", function(data_points){
            console.log(data_points);
            for(var i = 0; i < data_points.length; i++){
                chart.options.data[0].dataPoints.push(data_points[i]);
            }

            chart.render();
        });
    }               

    var updateInterval = 5000;

    setInterval(function(){
            updateChart()
    }, updateInterval);
</script>
@endsection