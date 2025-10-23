<!-- resources/views/participant/settings/index.blade.php -->
@extends('layouts.app')

@section('title', 'Pengaturan Akun - PressGO')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3">Pengaturan Akun</h1>
                        <p class="text-muted">Kelola informasi akun dan pengaturan keamanan</p>
                    </div>
                    <a href="{{ route('participant.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                            <i class="fas fa-user me-2"></i>Profil
                        </a>
                        <a href="#password" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-lock me-2"></i>Ubah Password
                        </a>
                        <a href="#photo" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                            <i class="fas fa-camera me-2"></i>Foto Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">
            <div class="tab-content">
                <!-- Tab Profil -->
                <div class="tab-pane fade show active" id="profile">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user me-2"></i>Informasi Profil
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('participant.settings.update-profile') }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $participant->name) }}" 
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', $participant->email) }}" 
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="text" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" 
                                               name="phone" 
                                               value="{{ old('phone', $participant->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">NIM/NISN</label>
                                        <input type="text" 
                                               class="form-control" 
                                               value="{{ $participant->nim }}" 
                                               disabled>
                                        <small class="form-text text-muted">NIM tidak dapat diubah</small>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Program</label>
                                        <input type="text" 
                                               class="form-control" 
                                               value="{{ $participant->program_type }}" 
                                               disabled>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Institusi</label>
                                        <input type="text" 
                                               class="form-control" 
                                               value="{{ $participant->institution }}" 
                                               disabled>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <small class="text-muted">Terakhir update: {{ $participant->updated_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab Ubah Password -->
                <div class="tab-pane fade" id="password">
                    <div class="card shadow">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-lock me-2"></i>Ubah Password
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('participant.settings.update-password') }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password" 
                                           required
                                           placeholder="Masukkan password saat ini">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" 
                                           class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" 
                                           name="new_password" 
                                           required
                                           placeholder="Masukkan password baru (minimal 6 karakter)">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="new_password_confirmation" 
                                           name="new_password_confirmation" 
                                           required
                                           placeholder="Masukkan kembali password baru">
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Saat ini anda login menggunakan password NIM/NISN
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-key me-2"></i>Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tab Foto Profil -->
                <div class="tab-pane fade" id="photo">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-camera me-2"></i>Foto Profil
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <div class="mb-4">
                                        <img src="{{ $participant->gambar_url }}" 
                                             alt="{{ $participant->name }}" 
                                             class="rounded-circle img-thumbnail" 
                                             style="width: 200px; height: 200px; object-fit: cover;">
                                        <div class="mt-3">
                                            <small class="text-muted">Foto Profil Saat Ini</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-8">
                                    <form method="POST" action="{{ route('participant.settings.update-photo') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Pilih Foto Baru</label>
                                            <input type="file" 
                                                   class="form-control @error('photo') is-invalid @enderror" 
                                                   id="photo" 
                                                   name="photo" 
                                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                                            @error('photo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                Format yang didukung: JPG, PNG, GIF. Maksimal ukuran: 2MB.
                                            </div>
                                        </div>
                                        
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Perhatian:</strong> Foto akan ditampilkan di dashboard dan ID card.
                                        </div>
                                        
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <small class="text-muted">Rekomendasi: foto persegi 1:1 untuk hasil terbaik</small>
                                            </div>
                                            <button type="submit" class="btn btn-info">
                                                <i class="fas fa-upload me-2"></i>Upload Foto
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview image sebelum upload
    const photoInput = document.getElementById('photo');
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.querySelector('.img-thumbnail');
                    if (img) {
                        img.src = e.target.result;
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Tab activation
    const url = new URL(window.location.href);
    const hash = url.hash;
    if (hash) {
        const tabTrigger = document.querySelector(`[href="${hash}"]`);
        if (tabTrigger) {
            const tab = new bootstrap.Tab(tabTrigger);
            tab.show();
        }
    }
});
</script>
@endpush

@push('styles')
<style>
.list-group-item.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.list-group-item {
    border: none;
    padding: 1rem 1.25rem;
    font-weight: 500;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.tab-pane {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.img-thumbnail {
    border: 3px solid #dee2e6;
    transition: border-color 0.3s ease;
}

.img-thumbnail:hover {
    border-color: #0d6efd;
}
</style>
@endpush