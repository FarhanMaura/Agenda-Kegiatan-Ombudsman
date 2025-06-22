@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Edit Agenda</h2>
    <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.agenda.update', $agenda->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="day" class="form-label">Hari</label>
        <input type="text" class="form-control" id="day" name="day" value="{{ old('day', $agenda->day) }}" readonly required>
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="date" name="date"
           value="{{ old('date', \Carbon\Carbon::parse($agenda->date)->format('Y-m-d')) }}" required>
    </div>

    <div class="mb-3">
        <label for="start_time" class="form-label">Jam Mulai</label>
        <input type="text" class="form-control time-24h" id="start_time" name="start_time"
               value="{{ old('start_time', $agenda->start_time) }}" required placeholder="00:00"
               pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
               title="Format 24 jam (00:00 - 23:59)">
    </div>

    <div class="mb-3">
        <label for="end_time" class="form-label">Jam Selesai</label>
        <input type="text" class="form-control time-24h" id="end_time" name="end_time"
               value="{{ old('end_time', $agenda->end_time) }}" required placeholder="00:00"
               pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
               title="Format 24 jam (00:00 - 23:59)">
    </div>

    <div class="mb-3">
        <label class="form-label">Kegiatan (minimal 1, maksimal 8)</label>
        <div id="activities">
            @php
                $activities = json_decode($agenda->activity, true) ?? [];
                if (empty($activities)) $activities = [''];
            @endphp

            @foreach($activities as $index => $activity)
            @php
                $isLainnya = !in_array($activity, ['Rapat Koordinasi', 'Kunjungan Lapangan', 'Penerimaan Tamu', 'Sosialisasi']);
            @endphp
            <div class="input-group mb-2 activity-item">
                <select class="form-control activity-select" name="activities[]" required>
                    <option value="">-- Pilih Kegiatan --</option>
                    <option value="Rapat Koordinasi" {{ $activity == 'Rapat Koordinasi' ? 'selected' : '' }}>Rapat Koordinasi</option>
                    <option value="Kunjungan Lapangan" {{ $activity == 'Kunjungan Lapangan' ? 'selected' : '' }}>Kunjungan Lapangan</option>
                    <option value="Penerimaan Tamu" {{ $activity == 'Penerimaan Tamu' ? 'selected' : '' }}>Penerimaan Tamu</option>
                    <option value="Sosialisasi" {{ $activity == 'Sosialisasi' ? 'selected' : '' }}>Sosialisasi</option>
                    <option value="Lainnya" {{ $isLainnya ? 'selected' : '' }}>Lainnya</option>
                </select>
                <input type="text" class="form-control other-activity-input"
                       style="{{ $isLainnya ? 'display:block' : 'display:none' }}"
                       placeholder="Ketik kegiatan lainnya"
                       name="other_activities[]"
                       value="{{ $isLainnya ? $activity : '' }}">
                @if($loop->index > 0)
                <button type="button" class="btn btn-danger remove-activity">Hapus</button>
                @endif
            </div>
            @endforeach
        </div>
        <button type="button" id="add-activity" class="btn btn-primary btn-sm">Tambah Kegiatan</button>
    </div>

    <div class="mb-3">
        <label for="institution" class="form-label">Instansi</label>
        <input type="text" class="form-control" id="institution" name="institution" value="{{ old('institution', $agenda->institution) }}" required>
    </div>

    <div class="mb-3">
        <label for="division" class="form-label">Divisi</label>
        <select class="form-control" id="division" name="division" required>
            <option value="">-- Pilih Divisi --</option>
            <option value="pvl" {{ old('division', $agenda->division) == 'pvl' ? 'selected' : '' }}>PVL</option>
            <option value="pl" {{ old('division', $agenda->division) == 'pl' ? 'selected' : '' }}>PL</option>
            <option value="pc" {{ old('division', $agenda->division) == 'pc' ? 'selected' : '' }}>PC</option>
            <option value="kaper" {{ old('division', $agenda->division) == 'kaper' ? 'selected' : '' }}>Kaper</option>
            <option value="sekretariat" {{ old('division', $agenda->division) == 'sekretariat' ? 'selected' : '' }}>Sekretariat</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="person_in_charge" class="form-label">Penanggung Jawab / Tim</label>
        <select class="form-control" id="person_in_charge" name="person_in_charge" required>
            <option value="">-- Pilih Penanggung Jawab --</option>
            <option value="Ismi" {{ $agenda->person_in_charge == 'Ismi' ? 'selected' : '' }}>Ismi</option>
            <option value="Riko" {{ $agenda->person_in_charge == 'Riko' ? 'selected' : '' }}>Riko</option>
            <option value="Dodi" {{ $agenda->person_in_charge == 'Dodi' ? 'selected' : '' }}>Dodi</option>
            <option value="Kaper" {{ $agenda->person_in_charge == 'Kaper' ? 'selected' : '' }}>Kaper</option>
            <option value="Prana" {{ $agenda->person_in_charge == 'Prana' ? 'selected' : '' }}>Prana</option>
            <option value="Windu" {{ $agenda->person_in_charge == 'Windu' ? 'selected' : '' }}>Windu</option>
            <option value="Dio" {{ $agenda->person_in_charge == 'Dio' ? 'selected' : '' }}>Dio</option>
            <option value="Lainnya" {{ !in_array($agenda->person_in_charge, ['Ismi', 'Riko', 'Dodi', 'Kaper', 'Prana', 'Windu', 'Dio']) ? 'selected' : '' }}>Lainnya</option>
        </select>
        <input type="text" class="form-control mt-2" id="other_pic_input" name="other_pic"
               style="{{ !in_array($agenda->person_in_charge, ['Ismi', 'Riko', 'Dodi', 'Kaper', 'Prana', 'Windu', 'Dio']) ? 'display:block' : 'display:none' }}"
               placeholder="Ketik nama penanggung jawab"
               value="{{ !in_array($agenda->person_in_charge, ['Ismi', 'Riko', 'Dodi', 'Kaper', 'Prana', 'Windu', 'Dio']) ? $agenda->person_in_charge : '' }}">
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill hari berdasarkan tanggal
    const dateInput = document.getElementById('date');
    const dayInput = document.getElementById('day');

    function updateDayName() {
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const selectedDate = new Date(dateInput.value);
        dayInput.value = days[selectedDate.getDay()];
    }

    dateInput.addEventListener('change', updateDayName);
    if (dateInput.value) updateDayName();

    // Validasi format waktu
    document.querySelectorAll('.time-24h').forEach(input => {
        input.addEventListener('blur', function() {
            const timeRegex = /^([01]?[0-9]|2[0-3]):([0-5][0-9])$/;
            if (!timeRegex.test(this.value)) {
                alert('Format waktu harus 00:00 - 23:59');
                this.value = '';
            }
        });
    });

    // Toggle input manual untuk kegiatan "Lainnya"
    function toggleActivityInput(selectElement) {
        const otherInput = selectElement.closest('.activity-item').querySelector('.other-activity-input');
        otherInput.style.display = (selectElement.value === 'Lainnya') ? 'block' : 'none';
        otherInput.required = (selectElement.value === 'Lainnya');
    }

    // Inisialisasi toggle saat load
    document.querySelectorAll('.activity-select').forEach(select => {
        toggleActivityInput(select);
        select.addEventListener('change', () => toggleActivityInput(select));
    });

    // Tambah kegiatan baru
    document.getElementById('add-activity').addEventListener('click', function() {
        const activitiesContainer = document.getElementById('activities');
        if (activitiesContainer.children.length >= 8) {
            alert('Maksimal 8 kegiatan!');
            return;
        }

        const newItem = document.createElement('div');
        newItem.className = 'input-group mb-2 activity-item';
        newItem.innerHTML = `
            <select class="form-control activity-select" name="activities[]" required>
                <option value="">-- Pilih Kegiatan --</option>
                <option value="Rapat Koordinasi">Rapat Koordinasi</option>
                <option value="Kunjungan Lapangan">Kunjungan Lapangan</option>
                <option value="Penerimaan Tamu">Penerimaan Tamu</option>
                <option value="Sosialisasi">Sosialisasi</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <input type="text" class="form-control other-activity-input" style="display:none"
                   placeholder="Ketik kegiatan lainnya" name="other_activities[]">
            <button type="button" class="btn btn-danger remove-activity">Hapus</button>
        `;
        activitiesContainer.appendChild(newItem);
        newItem.querySelector('.activity-select').addEventListener('change', function() {
            toggleActivityInput(this);
        });
    });

    // Hapus kegiatan
    document.getElementById('activities').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-activity')) {
            if (this.children.length <= 1) {
                alert('Minimal 1 kegiatan harus ada!');
                return;
            }
            e.target.closest('.activity-item').remove();
        }
    });

    // Toggle input PIC "Lainnya"
    const picSelect = document.getElementById('person_in_charge');
    const otherPicInput = document.getElementById('other_pic_input');

    picSelect.addEventListener('change', function() {
        otherPicInput.style.display = (this.value === 'Lainnya') ? 'block' : 'none';
        otherPicInput.required = (this.value === 'Lainnya');
    });
});
</script>
@endsection
