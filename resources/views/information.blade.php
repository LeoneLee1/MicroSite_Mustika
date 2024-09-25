@extends('layout.app')

@section('title', 'Analysis - PT Mustika Jaya Lestari')

@section('content')
    <div class="card" style="border-radius: 15px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <div class="card-body" style="padding: 30px;">
            <div class="mb-4">
                <h4 class="text-left" style="color: #2c3e50; font-weight: bold;">Answer Voters Distribution</h4>
                <div id="piechart1"></div>
            </div>
            <div class="mb-4">
                <h4 class="text-left" style="color: #2c3e50; font-weight: bold;">User Gender Distribution</h4>
                <div id="piechart2"></div>
            </div>
        </div>
    </div>
@endsection
@push('after-script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(function() {
            load_data();
        });

        function drawChart1(chart1Data) {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Jawaban');
            data.addColumn('number', 'Total Votes');

            $.each(chart1Data, function(i, row) {
                let jawaban = row.jawaban;
                let vote = parseFloat(row.vote);
                if (!isNaN(vote)) {
                    data.addRow([jawaban, vote]);
                }
            });

            var options = {
                title: 'Answer Voters',
                width: 900,
                height: 700,
                pieSliceText: 'label',
                legend: {
                    position: 'right',
                    alignment: 'center'
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
            chart.draw(data, options);
        }

        function drawChart2(chart2Data) {
            var data = google.visualization.arrayToDataTable(chart2Data);

            var options = {
                title: 'User Gender Distribution',
                width: 900,
                height: 700,
                pieSliceText: 'label',
                legend: {
                    position: 'right',
                    alignment: 'center'
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
            chart.draw(data, options);
        }

        function load_data() {
            $.ajax({
                url: '{{ route('fetchData.jawaban') }}',
                method: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "JSON",
                success: function(response) {
                    drawChart1(response.chart1);
                    drawChart2(response.chart2);
                }
            });
        }
    </script>
@endpush
