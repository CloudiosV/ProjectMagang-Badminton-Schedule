@extends('layouts.app')

@section('title', 'Daftar Jadwal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mt-3 mb-5">
        <h1>{{ $lapangan->nama }}</h1>
        <div>
            <a href="{{ route('lapangan.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    @auth
        <div class="mb-3">
            <a href="{{ route('jadwal.create', $lapangan) }}" class="btn btn-primary">
                Tambah Jadwal Baru
            </a>
        </div>
    @endauth

    @if($jadwal->count() > 0)
        <table class="table">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Jam Mulai</th>
                    <th>Jam Berhenti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwal as $jad)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jad->user->nama }}</td>
                    <td>{{ substr($jad->jam_mulai, 0, 5) }}</td>
                    <td>{{ substr($jad->jam_berhenti, 0, 5) }}</td>
                    <td nowrap>
                        @auth
                            @if(auth()->user()->role == 'admin' || auth()->user()->id == $jad->user_id)
                                <a href="{{ route('jadwal.edit', [$lapangan, $jad]) }}" class="btn btn-primary btn-sm">Ubah</a>
                                
                                <form action="{{ route('jadwal.destroy', [$lapangan, $jad]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Hapus jadwal ini?')">Hapus</button>
                                </form>
                            @else
                                <span class="text-muted">Tidak bisa edit</span>
                            @endif
                        @endauth
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $jadwal->links() }}
    @else
        <div style="padding: 20px; background: #f8f9fa; border-radius: 4px; text-align: center;">
            <p>Belum ada yang pesan jadwal di lapangan ini.</p>
            @auth
                <p><a href="{{ route('jadwal.create', $lapangan) }}">Buat Jadwal pertama!</a></p>
            @endauth
        </div>
    @endif
@endsection