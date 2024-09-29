@extends('Admin.layouts.parent')
@section('title', 'Reports')
@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col (LEFT) -->
                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Total Sales</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="lineChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Total Profits</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="lineChart2"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                {{-- @dd($data) --}}
                {{-- {{ $trending_products_data[0] }} --}}
                {{-- @foreach ($trending_products_data as $product)
                    {{ $product }}
                @endforeach --}}

                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Trending Products</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="TP"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col (RIGHT) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        {{-- @dd($products_data->year); --}}
        <!-- /.content -->
    </div>

@endsection

</div>
<!-- ./wrapper -->
@section('scripts')
    <!-- ChartJS -->
    <script src="{{ url('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function() {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            // Get context with jQuery - using jQuery's .get() method.

            //-------------
            //- Sales CHART -
            //--------------
            // Get context with jQuery - using jQuery's .get() method.
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')

            var lineChartData = {
                labels: [

                ],
                datasets: [{
                    label: 'Total Sales',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: '#4379F2',
                    pointRadius: true,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [
                        // Total sales values will be populated here
                    ]
                }]
            }

            var lineChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true,
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: true,
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

            // Populate the chart data

            @foreach ($sales_data as $data)
                lineChartData.labels.push('{{ $data->month }}');
                lineChartData.datasets[0].data.push('{{ $data->total_sales }}');
            @endforeach

            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            })


            //-------------
            //- Profits CHART -
            //--------------
            var profitChartCanvas = $('#lineChart2').get(0).getContext('2d')

            var ProfitChartData = {
                labels: [

                ],
                datasets: [{
                    label: 'Total Profits',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: '#4379F2',
                    pointRadius: true,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [
                        // Total sales values will be populated here
                    ]
                }]
            }

            var ProfitChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true,
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: true,
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

            // Populate the chart data

            @foreach ($sales_data as $data)
                ProfitChartData.labels.push('{{ $data->month }}');
                ProfitChartData.datasets[0].data.push('{{ $data->total_profit }}');
            @endforeach

            var ProfitChart = new Chart(profitChartCanvas, {
                type: 'line',
                data: ProfitChartData,
                options: lineChartOptions
            })


            //-------------
            //- Trending Products CHART -
            //--------------
            @php
                $colors = [
                    'rgba(140, 105, 180, 1)', // #FF69B4
                    'rgba(51, 204, 51, 1)', // #33CC33
                    'rgba(102, 102, 255, 1)', // #6666FF
                    'rgba(255, 204, 0, 1)', // #FFCC00
                    'rgba(0, 153, 204, 1)', // #0099CC
                ]; // Define an array of colors // Define an array of colors
                $colorIndex = 0; // Initialize a color index
            @endphp

            var trendingChartCanvas = $('#TP').get(0).getContext('2d')
            var trendingChartData = {
                labels: ['8', '9'],
                datasets: [
                    @foreach ($trending_products_data as $product)
                        {
                            label: '{{ $product->product }}',
                            backgroundColor: 'rgba(0, 0, 0, 0)',
                            borderColor: '{{ $colors[$colorIndex % count($colors)] }}',
                            pointRadius: true,
                            pointColor: '#3b8bba',
                            pointStrokeColor: '{{ $colors[$colorIndex % count($colors)] }}',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: '{{ $colors[$colorIndex % count($colors)] }}',
                            data: [2, {{ $product->total_sold }}]
                        },
                        @php
                            $colorIndex++; // Increment the color index
                        @endphp
                    @endforeach
                ]
            }


            var trendingChart = new Chart(trendingChartCanvas, {
                type: 'line',
                data: trendingChartData,
                options: lineChartOptions
            })
        })
        /*
        label: 'Total Sales',
        backgroundColor: 'rgba(210, 214, 222, 1)',
        borderColor: '#4379F2',
        pointRadius: true,
        pointColor: 'rgba(210, 214, 222, 1)',
        pointStrokeColor: '#c1c7d1',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        */
    </script>
@endsection

</html>
