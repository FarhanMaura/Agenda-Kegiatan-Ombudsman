@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Agenda {{ $isArchived ? '(Arsip)' : '' }}</h2>
    <div>
        @if ($isArchived)
            <a href="{{ route('admin.agenda.index') }}" class="btn btn-primary">Lihat Agenda Aktif</a>
        @else
            <a href="{{ route('admin.agenda.index', ['archived' => 1]) }}" class="btn btn-secondary">Lihat Arsip</a>
            <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary">Tambah Agenda</a>
            <a href="{{ route('admin.agenda.export', ['archived' => $isArchived ? 1 : 0]) }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
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
                <th>Divisi</th>
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

            @foreach ($groupedAgendas as $date => $items)
                @foreach ($items as $key => $agenda)
                    <tr>
                        @if ($key == 0)
                            <td class="text-center align-middle" rowspan="{{ count($items) }}">{{ $no++ }}</td>
                            <td class="text-center align-middle" rowspan="{{ count($items) }}">{{ $date }}</td>
                        @endif
                        <td class="text-center align-middle">{{ $agenda->time }}</td>
                        <td class="text-center align-middle">
                            @php
                                $activities = [];
                                if (is_string($agenda->activity)) {
                                    $decoded = json_decode($agenda->activity, true);
                                    $activities = is_array($decoded) ? $decoded : [$agenda->activity];
                                } elseif (is_array($agenda->activity)) {
                                    $activities = $agenda->activity;
                                } else {
                                    $activities = [$agenda->activity];
                                }
                            @endphp

                            @foreach($activities as $activity)
                                <div>{{ $activity }}</div>
                            @endforeach
                        </td>
                        <td class="text-center align-middle">{{ $agenda->institution }}</td>
                        <td class="text-center align-middle">
                            @php
                                $divisionLabels = [
                                    'pvl' => 'PVL',
                                    'pl' => 'PL',
                                    'pc' => 'PC',
                                    'kaper' => 'Kaper',
                                    'sekretariat' => 'Sekretariat'
                                ];
                                echo $divisionLabels[$agenda->division] ?? '-';
                            @endphp
                        </td>
                        <td class="text-center align-middle">{{ $agenda->person_in_charge }}</td>
                        <td class="text-center align-middle">
                            <a href="{{ route('admin.agenda.edit', $agenda->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
                            <form action="{{ route('admin.agenda.archive', $agenda->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-secondary btn-sm mb-1" onclick="return confirm('Yakin mau arsipkan agenda ini?')">
                                    {{ $isArchived ? 'Aktifkan' : 'Arsipkan' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.agenda.destroy', $agenda->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
