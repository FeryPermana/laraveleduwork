@extends('layouts.admin')

@section('header', 'Home')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $total_buku }}</h3>
                    <p>Total Buku</p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
                </div>
                <a href="{{ url('buku') }}"
                    class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $total_anggota }}</h3>
                    <p>Total Anggota</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{ url('anggota') }}"
                    class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $total_penerbit }}</h3>
                    <p>Data Penerbit</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-check"></i>
                </div>
                <a href="{{ url('penerbit') }}"
                    class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $total_peminjaman }}</h3>
                    <p>Data Peminjaman</p>
                </div>
                <div class="icon">
                    <i class="fa fa-box"></i>
                </div>
                <a href="{{ url('penerbit') }}"
                    class="small-box-footer">More Info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Grafik Penerbit</h3>
                    <div class="card-tools">
                        <button type="button"
                            class="btn btn-tool"
                            data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button"
                            class="btn btn-tool"
                            data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="donutChart"
                        style="min-height: 250px; height: 250px; max-height: 250px;max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Grafik Pengarang</h3>
                    <div class="card-tools">
                        <button type="button"
                            class="btn btn-tool"
                            data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button"
                            class="btn btn-tool"
                            data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="donutChartAuthor"
                        style="min-height: 250px; height: 250px; max-height: 250px;max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Peminjaman</h3>
                    <div class="card-tools">
                        <button type="button"
                            class="btn btn-tool"
                            data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button"
                            class="btn btn-tool"
                            data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart"
                            style="min-height: 250px; height: 250px; max-height: 250px;max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        var label_donut = '{!! json_encode($label_donut) !!}';
        var data_donut = '{!! json_encode($data_donut) !!}';
        var label_donut2 = '{!! json_encode($label_donut2) !!}';
        var data_donut2 = '{!! json_encode($data_donut2) !!}';
        var data_bar = '{!! json_encode($data_bar) !!}';



        function generateRandomColor() {
            const letters = "0123456789ABCDEF";
            let color = "#";
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        $(document).ready(function() {
            const jumlahData = '{{ count($label_donut) }}';

            const backgroundColorPublishers = [];
            for (let i = 0; i < jumlahData; i++) {
                const letters = "0123456789ABCDEF";
                let color = "#";
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                backgroundColorPublishers.push(generateRandomColor());
            }


            var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
            var donutData = {
                labels: JSON.parse(label_donut),
                datasets: [{
                    data: JSON.parse(data_donut),
                    backgroundColor: backgroundColorPublishers,
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }

            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

            // asasas

            const jumlahDataAuthor = '{{ count($label_donut) }}';

            const backgroundColorAuthors = [];
            for (let i = 0; i < jumlahDataAuthor; i++) {
                const letters = "0123456789ABCDEF";
                let color = "#";
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                backgroundColorAuthors.push(generateRandomColor());
            }


            var donutChartCanvas = $('#donutChartAuthor').get(0).getContext('2d');
            var donutData = {
                labels: JSON.parse(label_donut),
                datasets: [{
                    data: JSON.parse(data_donut),
                    backgroundColor: backgroundColorAuthors,
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }

            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

            // bar chat
            var areaChartData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'Agustus', 'September',
                    'October', 'November', 'December'
                ],
                datasets: JSON.parse(data_bar)
            }

            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })
        });
    </script>
@endpush
