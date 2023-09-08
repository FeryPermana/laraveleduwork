@extends('layouts.admin')
@section('header', 'Catalog')

@section('content')
    <div class="card">
        <div class="card-header bg-secondary">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Catalog</h3>
                <a href="{{ route('catalogs.create') }}"
                    class="btn btn-primary">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Total Buku</th>
                        <th>Created At</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($catalogs as $key => $catalog)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $catalog->name }}</td>
                                <td>{{ count($catalog->books) }}</td>
                                <td class="text-center">{{ format_tanggal($catalog->created_at) }}</td>
                                <td>
                                    <a href="{{ route('catalogs.edit', $catalog->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('catalogs.destroy', $catalog->id) }}"
                                        method="POST"
                                        class="d-inline">
                                        <input type="submit"
                                            class="btn btn-danger btn-sm"
                                            value="Delete"
                                            onclick="return confirm('Apakah kamu yakin ??')">
                                        @method('delete')
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
