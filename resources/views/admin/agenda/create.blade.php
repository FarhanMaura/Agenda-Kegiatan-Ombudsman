@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Tambah Agenda</h2>
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

<form action="{{ route('admin.agenda.store') }}" method="POST">
    @csrf

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="day" class="form-label">Hari</label>
            <input type="text" class="form-control" id="day" name="day" value="{{ old('day') }}" readonly required>
        </div>
        <div class="col-md-6">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="start_time" class="form-label">Jam Mulai</label>
            <input type="text" class="form-control time-24h" id="start_time" name="start_time"
                   value="{{ old('start_time') }}" required placeholder="00:00"
                   pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
                   title="Format 24 jam (00:00 - 23:59)">
        </div>
        <div class="col-md-4">
            <label for="end_time" class="form-label">Jam Selesai</label>
            <input type="text" class="form-control time-24h" id="end_time" name="end_time"
                   value="{{ old('end_time') }}" required placeholder="00:00"
                   pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]"
                   title="Format 24 jam (00:00 - 23:59)">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Kegiatan (minimal 1, maksimal 8)</label>
        <div id="activities">
            <div class="input-group mb-2 activity-item">
                <select class="form-control activity-select" name="activities[]" required>
                    <option value="">-- Pilih Kegiatan --</option>
                    <option value="Rapat Koordinasi">Rapat Koordinasi</option>
                    <option value="Kunjungan Lapangan">Kunjungan Lapangan</option>
                    <option value="Penerimaan Tamu">Penerimaan Tamu</option>
                    <option value="Sosialisasi">Sosialisasi</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <input type="text" class="form-control other-activity-input" style="display: none;"
                       placeholder="Ketik kegiatan lainnya" name="other_activities[]">
                <button type="button" class="btn btn-danger remove-activity">Hapus</button>
            </div>
        </div>
        <button type="button" id="add-activity" class="btn btn-primary btn-sm">Tambah Kegiatan</button>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="institution" class="form-label">Instansi</label>
            <input type="text" class="form-control" id="institution" name="institution" value="{{ old('institution') }}" required>
        </div>
        <div class="col-md-6">
            <label for="division" class="form-label">Divisi</label>
            <select class="form-control" id="division" name="division" required>
                <option value="">-- Pilih Divisi --</option>
                <option value="pvl" {{ old('division') == 'pvl' ? 'selected' : '' }}>PVL</option>
                <option value="pl" {{ old('division') == 'pl' ? 'selected' : '' }}>PL</option>
                <option value="pc" {{ old('division') == 'pc' ? 'selected' : '' }}>PC</option>
                <option value="kaper" {{ old('division') == 'kaper' ? 'selected' : '' }}>Kaper</option>
                <option value="sekretariat" {{ old('division') == 'sekretariat' ? 'selected' : '' }}>Sekretariat</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="person_in_charge" class="form-label">Penanggung Jawab / Tim</label>
            <select class="form-control" id="person_in_charge" name="person_in_charge" required>
                <option value="">-- Pilih Penanggung Jawab --</option>
                <option value="Ismi">Ismi</option>
                <option value="Riko">Riko</option>
                <option value="Dodi">Dodi</option>
                <option value="Kaper">Kaper</option>
                <option value="Prana">Prana</option>
                <option value="Windu">Windu</option>
                <option value="Dio">Dio</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <input type="text" class="form-control mt-2" id="other_pic_input" name="other_pic"
                   style="display: none;" placeholder="Ketik nama penanggung jawab">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Time format handling
    document.querySelectorAll('.time-24h').forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + ':' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        input.addEventListener('blur', function(e) {
            const timeRegex = /^([01]?[0-9]|2[0-3]):([0-5][0-9])$/;
            if (!timeRegex.test(e.target.value)) {
                e.target.value = '';
                alert('Masukkan waktu yang valid (00:00 - 23:59)');
            }
        });
    });

    // Day name auto-fill
    const dateInput = document.getElementById('date');
    const dayInput = document.getElementById('day');

    function getDayName(dateString) {
        if (!dateString) return '';
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        try {
            const date = new Date(dateString);
            const adjustedDate = new Date(date.getTime() + date.getTimezoneOffset() * 60000);
            return days[adjustedDate.getDay()];
        } catch (e) {
            console.error('Error parsing date:', e);
            return '';
        }
    }

    dateInput.addEventListener('change', function() {
        dayInput.value = getDayName(this.value);
    });

    if (dateInput.value) {
        dayInput.value = getDayName(dateInput.value);
    }

    // Activities management
    const activitiesContainer = document.getElementById('activities');
    const addActivityBtn = document.getElementById('add-activity');

    function toggleActivityInput(selectElement) {
        const inputGroup = selectElement.closest('.activity-item');
        const manualInput = inputGroup.querySelector('.other-activity-input');

        if (selectElement.value === 'Lainnya') {
            manualInput.style.display = 'block';
            manualInput.required = true;
        } else {
            manualInput.style.display = 'none';
            manualInput.required = false;
            manualInput.value = '';
        }
    }

    addActivityBtn.addEventListener('click', function() {
        const currentActivities = activitiesContainer.querySelectorAll('.activity-item').length;
        if (currentActivities >= 8) {
            alert('Maksimal 8 kegiatan!');
            return;
        }

        const newActivity = document.createElement('div');
        newActivity.classList.add('input-group', 'mb-2', 'activity-item');
        newActivity.innerHTML = `
            <select class="form-control activity-select" name="activities[]" required>
                <option value="">-- Pilih Kegiatan --</option>
                <option value="Rapat Koordinasi">Rapat Koordinasi</option>
                <option value="Kunjungan Lapangan">Kunjungan Lapangan</option>
                <option value="Penerimaan Tamu">Penerimaan Tamu</option>
                <option value="Sosialisasi">Sosialisasi</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <input type="text" class="form-control other-activity-input" style="display: none;" placeholder="Ketik kegiatan lainnya" name="other_activities[]">
            <button type="button" class="btn btn-danger remove-activity">Hapus</button>
        `;
        activitiesContainer.appendChild(newActivity);
    });

    activitiesContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('activity-select')) {
            toggleActivityInput(e.target);
        }
    });

    activitiesContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-activity')) {
            const currentActivities = activitiesContainer.querySelectorAll('.activity-item').length;
            if (currentActivities <= 1) {
                alert('Minimal 1 kegiatan harus ada!');
                return;
            }
            e.target.closest('.activity-item').remove();
        }
    });

    // Person in charge handling
    const picSelect = document.getElementById('person_in_charge');
    const otherPicInput = document.getElementById('other_pic_input');

    picSelect.addEventListener('change', function() {
        if (this.value === 'Lainnya') {
            otherPicInput.style.display = 'block';
            otherPicInput.required = true;
        } else {
            otherPicInput.style.display = 'none';
            otherPicInput.required = false;
            otherPicInput.value = '';
        }
    });

    // Form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        // Validate activities
        document.querySelectorAll('.activity-item').forEach(item => {
            const select = item.querySelector('.activity-select');
            const input = item.querySelector('.other-activity-input');

            if (select.value === 'Lainnya' && !input.value.trim()) {
                e.preventDefault();
                alert('Harap isi kegiatan untuk pilihan "Lainnya"');
                input.focus();
                return;
            }
        });

        // Handle person in charge "Lainnya"
        if (picSelect.value === 'Lainnya' && otherPicInput.value.trim() !== '') {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'person_in_charge';
            hiddenInput.value = otherPicInput.value.trim();
            this.appendChild(hiddenInput);
            picSelect.disabled = true;
        }
    });
});
</script>
@endsection
