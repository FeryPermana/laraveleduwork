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
                        @if ($method == 'update')
                            <h3 class="card-title">Update Transaction</h3>
                        @else
                            <h3 class="card-title">Tambah Transaction</h3>
                        @endif

                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ $url }}"
                    method="POST">
                    @csrf
                    @if ($method == 'update')
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="">Member</label>
                        <select name="member_id"
                            id=""
                            class="form-control">
                            <option value="">Pilih Member</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('member_id', @$transaction->member_id) == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tanggal Pinjam</label>
                                <input type="date"
                                    class="form-control"
                                    name="date_start"
                                    value="{{ old('date_start', @$transaction->date_start) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tanggal Kembali</label>
                                <input type="date"
                                    class="form-control"
                                    name="date_end"
                                    value="{{ old('date_end', @$transaction->date_end) }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Book</label>
                        <select name="book_id"
                            id=""
                            class="form-control">
                            <option value="">Pilih Book</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}"
                                    {{ old('book_id', @$transaction->transaction_details[0]->book_id) == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <div class="form-check">
                            <input class="form-check-input"
                                type="radio"
                                name="status"
                                id="sudah-dikembalikan"
                                value="1"
                                {{ old('status', @$transaction->status) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="sudah-dikembalikan">
                                Sudah Dikembalikan
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input"
                                type="radio"
                                name="status"
                                id="belum-dikembalikan"
                                value="2"
                                {{ old('status', @$transaction->status) == 2 ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="belum-dikembalikan">
                                Belum Dikembalikan
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit"
                            class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
