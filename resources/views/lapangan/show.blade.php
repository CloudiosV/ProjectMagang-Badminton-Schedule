@extends('layouts.app')

@section('title', 'Daftar Jadwal')
@section('header', $lapangan->nama)
@section('breadcrumb', 'Lapangan')

@section('content')
<div class="row mb-4">
    @can('create jadwal')
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <a href="{{ route('jadwal.create', $lapangan) }}" class="card-body text-decoration-none text-light d-block">
                    <div class="text-center">
                        <i class="fas fa-plus-circle fa-2x mb-2"></i>
                        <h5>Tambah Jadwal</h5>
                    </div>
                </a>
            </div>
        </div>
    @endcan
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-calendar-alt me-1"></i>
            Daftar Jadwal - {{ $lapangan->nama }}
        </div>
    </div>
    <div class="card-body">
        @if($jadwal->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th>Nama Pemesan</th>
                            <th width="15%">Jam Mulai</th>
                            <th width="15%">Jam Berhenti</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwal as $jad)
                        <tr class="text-center align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $jad->user->nama }}</td>
                            <td>{{ substr($jad->jam_mulai, 0, 5) }}</td>
                            <td>{{ substr($jad->jam_berhenti, 0, 5) }}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">
                                    @auth
                                        @if(auth()->user()->hasAnyRole(['admin', 'manager']) || auth()->user()->id == $jad->user_id)
                                            @can('edit jadwal')
                                                <a href="{{ route('jadwal.edit', [$lapangan, $jad]) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            
                                            @can('delete jadwal')
                                                <form action="{{ route('jadwal.destroy', [$lapangan, $jad]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Apakah Anda yakin menghapus jadwal ini?')" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan

                                            @if (!(auth()->user()->can('edit jadwal')) && !(auth()->user()->can('delete jadwal')))
                                                <span class="text-muted">Tidak bisa edit</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Tidak bisa edit</span>
                                        @endif
                                    @endauth
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center py-4">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <h5>Belum ada jadwal di lapangan ini</h5>
                @auth
                    <p class="mb-0">
                        <a href="{{ route('jadwal.create', $lapangan) }}" class="btn btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i> Buat Jadwal Pertama
                        </a>
                    </p>
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection