<?php $columnChart = [['Subject','Student Score','Class Min','Class AVG','Class Max']] ?>
@foreach($subResult as $row)
    @php array_push($columnChart,[$row->subject,$row->total,$row->min,$row->avg,$row->max]) @endphp
@endforeach

@if ($subResult->isNotEmpty())
     <div class="col-md-12 mt-4">
        <div id="column_Chart" class="chartZoomable" style="width:98%;height:auto;"></div>
    </div>
@endif

     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
     <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });

        @if($setting->chart == 'column')
            google.charts.load('current', {
            'packages': ['bar']
        });
        @else
             google.charts.load('current', {
            'packages': ['line']
        });
        @endif
       

        google.charts.setOnLoadCallback(drawColumnChart);
        let dataset = <?php echo json_encode($columnChart, JSON_NUMERIC_CHECK) ?>
        // console.log(dataset);
        function drawColumnChart() {

            var data = google.visualization.arrayToDataTable(dataset);

            var view = new google.visualization.DataView(data);

            var options = {
                title: "Student Score Against TOTAL, MIN, MAX & AVG",
                // subtitle: "based on meter type and installation status",
                bar: {
                    groupWidth: "20%"
                },
                legend: {
                    position: "top"
                },
            };
            @if($setting->chart == 'column')
                var chart = new google.visualization.ColumnChart(document.getElementById("column_Chart"));
            @else
                var chart = new google.visualization.LineChart(document.getElementById("column_Chart"));
            @endif
            chart.draw(view, options);
        }
    </script>
