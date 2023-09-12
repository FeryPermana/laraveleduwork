@extends('layouts.admin')
@section('header', 'Transaction')
@push('styles')
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assest/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@section('content')
    <div id="controller">
        <div class="card">
            <div class="card-header bg-secondary">
                <div class="row">
                    <div class="col-md-3">
                        <h3 class="card-title">Transaction</h3>
                    </div>
                    <div class="col-md-2">
                        <select name="status"
                            class="form-control">
                            <option value=""
                                selected>Status</option>
                            <option value="1">Kembali</option>
                            <option value="2">Belum Kembali</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="tanggal"
                            class="form-control">
                            <option value=""
                                selected>Tanggal</option>
                            @foreach ($transactions as $transaction)
                                <option value="{{ $transaction->date_start }}">
                                    {{ format_tanggal($transaction->date_start) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="filter"
                            class="btn btn-success">Filter</button>
                    </div>
                    <div class="col-md-3">
                        <d class="d-flex justify-content-end">
                            <a href="{{ route('transactions.create') }}"
                                class="btn btn-sm btn-primary">Tambah Transaction</a>
                        </d>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-transaction"
                        class="table table-bordered table-striped w-full">
                        <thead>
                            <th>No</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Nama Peminjam</th>
                            <th>Lama Pinjam (hari)</th>
                            <th>Total Buku</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th style="width: 130px;">Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script>
            var actionUrl = '{{ url('/transactions') }}';
            var apiUrl = '{{ url('/api/transactions') }}';

            var columns = [{
                    data: 'DT_RowIndex',
                    class: 'text-center',
                    orderable: true
                }, {
                    data: 'date_start',
                    class: 'text-center',
                    orderable: true
                }, {
                    data: 'date_end',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'member_name',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'range_date',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'transaction_details_sum_qty',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'price',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'status',
                    class: 'text-center',
                    orderable: true
                },
                {
                    render: function(index, row, data, meta) {
                        return `
                    <a href="/transactions/${data.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                    <a href="/transactions/${data.id}" class="btn btn-secondary btn-sm">Detail</a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">Delete</a>
                    `;
                    },
                    orderable: false,
                    width: '200px',
                    class: 'text-center'
                },
            ];

            var controller = new Vue({
                el: '#controller',
                data: {
                    datas: [],
                    data: {},
                    actionUrl,
                    apiUrl,
                    editStatus: false,
                },
                mounted: function() {
                    this.datatable();
                },
                methods: {
                    datatable() {
                        const _this = this;
                        _this.table = $('#table-transaction').DataTable({
                            ajax: {
                                url: _this.apiUrl,
                                type: 'GET',
                            },
                            columns: columns
                        }).on('xhr', function() {
                            _this.datas = _this.table.ajax.json().data;
                        });
                    },
                    deleteData(event, id) {
                        if (confirm('Are you sure')) {
                            $(event.target).parents('tr').remove();
                            axios.post(this.actionUrl + '/' + id, {
                                _method: 'DELETE'
                            }).then(response => {
                                _this.table.ajax.reload();
                            });
                        }
                    },
                }
            });
        </script>
        <script>
            $('#filter').on('click', function() {
                status = $('select[name=status]').val();
                tanggal = $('select[name=tanggal]').val();

                if (tanggal != 0 && status != 0) {
                    controller.table.ajax.url(apiUrl + '?tanggal=' + tanggal + '&status=' + status).load();
                } else if (tanggal != 0) {
                    controller.table.ajax.url(apiUrl + '?tanggal=' + tanggal).load();
                } else if (status != 0) {
                    controller.table.ajax.url(apiUrl + '?status=' + status).load();
                } else {
                    controller.table.ajax.url(apiUrl).load();
                }
            })
        </script>
    @endpush
@endsection
