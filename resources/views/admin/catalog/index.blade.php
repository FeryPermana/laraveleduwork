@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="my-5">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Catalog</h3>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Total Buku</th>
                        <th>Created At</th>
                    </thead>
                    <tbody>
                        @foreach ($catalogs as $key => $catalog)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $catalog->name }}</td>
                                <td>{{ count($catalog->books) }}</td>
                                <td class="text-center">{{ date('H:i:s - d M Y', strtotime($catalog->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
