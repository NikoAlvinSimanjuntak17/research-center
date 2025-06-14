@extends('admin.layouts.app')
@section('title', 'Struktur Organisasi')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Struktur Organisasi</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.organization.create') }}" class="btn btn-primary">Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($organizationStructures as $organization)
                                <tr>
                                    <td><img src="{{ asset('storage/' . $organization->photo) }}" alt="Image" width="100"></td>
                                    <td>{!! old('description', $organization->description) !!}</td>
                                    <td>
                                        <a href="{{ route('admin.organization.edit', $organization->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('admin.organization.destroy', $organization->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->

@endsection
