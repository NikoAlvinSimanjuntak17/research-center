@extends('admin.layouts.app')

@section('title', 'Daftar Peneliti')
@section('content')

<h1 class="text-2xl font-semibold mb-4">Manajemen Peneliti</h1>

@if(session('success'))
<div class="bg-green-100 text-green-800 p-4 rounded mb-4">
    {{ session('success') }}
</div>

@endif
<div class="mb-2">
    <a href="{{ route('admin.researchers.create')}}">
    <button type="button" class="btn btn-flat-primary rounded-pill">
        <i class="ph-user-plus me-2"></i>
        Tambah Peneliti
    </button>
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable-basic">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>E-mail</th>
                        <th>Institution</th>
                        <th>Department</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($researchers as $researcher)
                    <tr>
                        <td>{{ $researcher->full_name ?? $researcher->user->name }}</td>
                        <td><a href="mailto:{{ $researcher->user->email }}">{{ $researcher->user->email }}</a></td>
                        <td>{{ $researcher->department->institution->name ?? '-' }}</td>
                        <td>{{ $researcher->department->name ?? '-' }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <form action="{{ route('admin.researchers.destroy', $researcher->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus peneliti ini?')" class="btn p-0 border-0 bg-transparent text-danger mx-2">
                                        <i class="ph-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.researchers.show', $researcher->id) }}" class="text-teal">
                                    <i class="ph-gear"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data peneliti.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    @endsection
    