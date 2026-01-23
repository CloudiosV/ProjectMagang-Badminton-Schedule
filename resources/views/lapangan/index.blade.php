@extends('layouts.app')

@section('title', 'Daftar Lapangan')
@section('header', 'Daftar Lapangan')
@section('breadcrumb', 'Lapangan')  

@section('content')
<div class="row">
    @can('create lapangan')
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <a href="{{ route('lapangan.create') }}" class="card-body text-decoration-none text-light d-block">
                    <div class="text-center">
                        <i class="fas fa-plus-circle fa-2x mb-2"></i>
                        <h5>Tambah Lapangan</h5>
                    </div>
                </a>
            </div>
        </div>
    @endcan
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Daftar Lapangan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatablesSimple" class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Nama Lapangan</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lapangan as $lap)
                        <tr class="text-center align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lap->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($lap->tanggal)->format('d-m-Y') }}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    @can('view jadwal')
                                        <a href="{{ route('lapangan.show', $lap) }}" class="btn btn-sm btn-primary" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endcan
                                    
                                    @can('edit lapangan')
                                        <a href="{{ route('lapangan.edit', $lap) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('delete lapangan')
                                        <form action="{{ route('lapangan.destroy', $lap) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?')" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan

                                    @if (!(auth()->user()->can('view jadwal')) && !(auth()->user()->can('edit lapangan')) && !(auth()->user()->can('delete lapangan')))
                                        <span class="text-muted">Tidak bisa edit</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection