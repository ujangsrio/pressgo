@extends('layouts.sidebar')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-primary">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Data Absensi
                    </h1>
                    <p class="text-muted mb-0">Perbarui data absensi peserta</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('attendance.show', $attendance) }}" class="btn btn-outline-primary">
                        <i class="bi bi-eye me-2"></i>
                        Lihat Detail
                    </a>
                    <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-custom">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-check me-2"></i>
                        Form Edit Absensi
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.update', $attendance) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="participant_id" class="form-label fw-semibold">Peserta <span class="text-danger">*</span></label>
                                <select class="form-select @error('participant_id') is-invalid @enderror" 
                                        id="participant_id" 
                                        name="participant_id"
                                        required>
                                    <option value="">Pilih Peserta</option>
                                    @foreach($participants as $participant)
                                        <option value="{{ $participant->id }}" 
                                            {{ old('participant_id', $attendance->participant_id) == $participant->id ? 'selected' : '' }}>
                                            {{ $participant->name }} ({{ $participant->nim }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('participant_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="date" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       id="date" 
                                       name="date" 
                                       value="{{ old('date', $attendance->date) }}"
                                       required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="check_in" class="form-label fw-semibold">Masuk <span class="text-danger">*</span></label>
                                <input type="time" 
                                       class="form-control @error('check_in') is-invalid @enderror" 
                                       id="check_in" 
                                       name="check_in" 
                                       value="{{ old('check_in', $attendance->check_in) }}"
                                       required>
                                @error('check_in')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <small>Check in setelah jam 08:00 akan otomatis status Terlambat</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="check_out" class="form-label fw-semibold">Keluar</label>
                                <input type="time" 
                                       class="form-control @error('check_out') is-invalid @enderror" 
                                       id="check_out" 
                                       name="check_out" 
                                       value="{{ old('check_out', $attendance->check_out) }}">
                                @error('check_out')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status"
                                        required>
                                    <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Tepat Waktu</option>
                                    <option value="late" {{ old('status', $attendance->status) == 'late' ? 'selected' : '' }}>Terlambat</option>
                                    <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Absen</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label fw-semibold">Catatan</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" 
                                          name="notes" 
                                          rows="3" 
                                          placeholder="Masukkan catatan tambahan...">{{ old('notes', $attendance->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Current Data Info -->
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Informasi Data Saat Ini
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small><strong>Peserta:</strong> {{ $attendance->participant->name }}</small><br>
                                            <small><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</small>
                                        </div>
                                        <div class="col-md-6">
                                            <small><strong>Masuk:</strong> {{ $attendance->check_in }}</small><br>
                                            <small><strong>Keluar:</strong> {{ $attendance->check_out ?? '-' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-2"></i>
                                            Update Data
                                        </button>
                                        <a href="{{ route('attendance.show', $attendance) }}" class="btn btn-secondary">
                                            <i class="bi bi-x-circle me-2"></i>
                                            Batal
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash me-2"></i>
                                            Hapus Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data absensi ini?</p>
                <div class="alert alert-warning">
                    <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Data yang sudah dihapus tidak dapat dikembalikan. Tindakan ini akan menghapus permanen data absensi.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('attendance.destroy', $attendance) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto update status based on check_in time
    const checkInInput = document.getElementById('check_in');
    const statusSelect = document.getElementById('status');
    
    checkInInput.addEventListener('change', function() {
        const checkInTime = this.value;
        if (checkInTime) {
            const [hours, minutes] = checkInTime.split(':');
            if (parseInt(hours) > 8 || (parseInt(hours) === 8 && parseInt(minutes) > 0)) {
                statusSelect.value = 'late';
            } else {
                statusSelect.value = 'present';
            }
        }
    });

    // Validate check_out time
    const checkOutInput = document.getElementById('check_out');
    
    checkOutInput.addEventListener('change', function() {
        const checkInTime = checkInInput.value;
        const checkOutTime = this.value;
        
        if (checkInTime && checkOutTime) {
            if (checkOutTime <= checkInTime) {
                alert('Check out time harus setelah check in time');
                this.value = '';
                this.focus();
            }
        }
    });
});
</script>

<style>
.form-text small {
    font-size: 0.8rem;
}

.alert {
    border-radius: 0.75rem;
}

.btn {
    border-radius: 0.5rem;
}
</style>
@endsection