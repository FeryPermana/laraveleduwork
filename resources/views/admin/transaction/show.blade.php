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
                        <h3 class="card-title">Detail Transaction</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Member</label>
                    <p>{{ @$transaction->member->name }}</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Tanggal Pinjam</label>
                            <p>{{ @$transaction->date_start }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Tanggal Kembali</label>
                            <p>{{ @$transaction->date_end }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Book</label>
                    @foreach ($transaction->transaction_details as $transaction_details)
                        <p>{{ $transaction_details->book->title }}</p>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                    @if (@$transaction->status == 1)
                        <p>Sudah Dikembalikan</p>
                    @else
                        <p>Belum Dikembalikan</p>
                    @endif
                </div>
                <div class="form-group">
                    <a href="{{ route('transactions.index') }}"
                        class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
