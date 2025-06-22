@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Agenda {{ $isArchived ? '(Arsip)' : '' }}</h2>

    <div>
        @if ($isArchived)
            <a href="{{ route('admin.agenda.index') }}" class="btn btn-primary">Lihat Agenda Aktif</a>
        @else
        @endif
    </div>
</div>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari & Tanggal</th>
                <th>Waktu</th>
                <th>Kegiatan</th>
                <th>Instansi</th>
                <th>Penanggung Jawab/Tim</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $groupedAgendas = $agendas->groupBy(function($agenda) {
                    return $agenda->day . ', ' . \Carbon\Carbon::parse($agenda->date)->translatedFormat('d F Y');
                });
                $no = 1;
            @endphp

            @forelse ($groupedAgendas as $date => $items)
                @foreach ($items as $key => $agenda)
                    <tr>
                        @if ($key == 0)
                            <td class="text-center align-middle" rowspan="{{ count($items) }}">{{ $no++ }}</td>
                            <td class="text-center align-middle" rowspan="{{ count($items) }}">{{ $date }}</td>
                        @endif
                        <td class="text-center align-middle">{{ $agenda->time }}</td>
                        <td class="text-center align-middle">
                            @php
                                $activities = json_decode($agenda->activity, true);
                            @endphp

                            @if(is_array($activities))
                                @foreach($activities as $act)
                                    {{ $act }}<br>
                                @endforeach
                            @else
                                {{ $agenda->activity }}
                            @endif
                        </td>

                        <td class="text-center align-middle">{{ $agenda->institution }}</td>
                        <td class="text-center align-middle">{{ $agenda->person_in_charge }}</td>

                        <td class="text-center align-middle">
                            @if (!$isArchived)
                                <a href="{{ route('admin.agenda.edit', $agenda->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>

                                <form action="{{ route('admin.agenda.archive', $agenda->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-secondary btn-sm mb-1" onclick="return confirm('Yakin mau arsipkan agenda ini?')">Arsipkan</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.agenda.destroy', ['agenda' => $agenda->id, 'archived' => request('archived')]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td class="text-center" colspan="7">
                        Tidak ada agenda ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
