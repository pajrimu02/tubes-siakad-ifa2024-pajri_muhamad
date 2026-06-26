@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
<div class="page-wrapper">

    <div class="page-header">
        <div class="header-left">
             
            <div class="header-title">
                <h1>Edit Profil</h1>
                <p>Perbarui informasi akun Anda</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- AVATAR PREVIEW --}}
    <div class="avatar-preview-card">
        <img id="avatarImg"
             src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&background=6366f1&color=fff&bold=true"
             alt="{{ $user->name }}">
        <div>
            <div class="av-name">{{ $user->name }}</div>
            <div class="av-email">{{ $user->email }}</div>
            <div style="font-size:.75rem;color:#94a3b8;margin-top:4px;">Avatar dihasilkan otomatis dari nama</div>
        </div>
    </div>

    {{-- FORM INFO --}}
    <div class="form-card">
        <div class="section-title">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            Informasi Dasar
        </div>

        <form action="{{ route('profil.update') }}" method="POST" id="profilForm">
            @csrf @method('PUT')

            <div class="form-grid">

                <div class="form-group full-width">
                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $user->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Nama lengkap Anda" required
                           oninput="updatePreview(this.value)">
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group full-width">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="email@domain.com" required>
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

            </div>

            <div class="section-divider"></div>
            <div class="section-title">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
                Ubah Password
                <span class="section-hint">Kosongkan jika tidak ingin mengubah password</span>
            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <div class="pass-wrap">
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 8 karakter" autocomplete="new-password">
                        <button type="button" class="eye-btn" onclick="togglePass('password', this)">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="pass-wrap">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control"
                               placeholder="Ulangi password baru" autocomplete="new-password">
                        <button type="button" class="eye-btn" onclick="togglePass('password_confirmation', this)">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('profil.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('styles')
<style>
    .page-wrapper { max-width: 720px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
    .page-header { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem; }
    .header-left { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .btn-back { display: inline-flex; align-items: center; gap: 6px; font-size: .85rem; color: #6b7280; text-decoration: none; padding: 6px 12px; border: 1px solid #e5e7eb; border-radius: 8px; transition: all .15s; white-space: nowrap; }
    .btn-back:hover { background: #f3f4f6; color: #111827; }
    .header-title h1 { font-size: 1.35rem; font-weight: 700; color: #111827; margin: 0; }
    .header-title p  { font-size: .85rem; color: #6b7280; margin: 2px 0 0; }

    .alert-danger { display: flex; align-items: flex-start; gap: .75rem; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; border-radius: 10px; padding: .9rem 1.1rem; margin-bottom: 1.25rem; font-size: .875rem; }
    .alert-danger svg { flex-shrink: 0; margin-top: 2px; }

    /* AVATAR PREVIEW */
    .avatar-preview-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 1.25rem; box-shadow: 0 1px 4px rgba(0,0,0,.05); margin-bottom: 1.25rem; }
    .avatar-preview-card img { width: 64px; height: 64px; border-radius: 50%; border: 3px solid #e0e7ff; flex-shrink: 0; }
    .av-name  { font-size: 1rem; font-weight: 700; color: #111827; }
    .av-email { font-size: .82rem; color: #6b7280; margin-top: 2px; }

    /* FORM CARD */
    .form-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 1.75rem; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
    .section-title { display: flex; align-items: center; gap: 7px; font-size: .88rem; font-weight: 700; color: #374151; margin-bottom: 1.25rem; }
    .section-hint { font-size: .77rem; font-weight: 400; color: #94a3b8; margin-left: 4px; }
    .section-divider { border: none; border-top: 1px solid #f1f5f9; margin: 1.5rem 0; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem 1.5rem; }
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-group.full-width { grid-column: 1 / -1; }
    label { font-size: .84rem; font-weight: 600; color: #374151; }
    .required { color: #ef4444; }
    .form-control { padding: .55rem .85rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: .9rem; color: #111827; background: #fff; transition: border-color .15s, box-shadow .15s; outline: none; width: 100%; box-sizing: border-box; }
    .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
    .form-control.is-invalid { border-color: #f87171; }
    .invalid-feedback { font-size: .78rem; color: #ef4444; }

    /* PASSWORD TOGGLE */
    .pass-wrap { position: relative; }
    .pass-wrap .form-control { padding-right: 2.5rem; }
    .eye-btn { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94a3b8; padding: 0; display: flex; align-items: center; transition: color .15s; }
    .eye-btn:hover { color: #6366f1; }

    .form-actions { display: flex; justify-content: flex-end; gap: .75rem; margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid #f3f4f6; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: .55rem 1.25rem; border-radius: 8px; font-size: .88rem; font-weight: 600; border: none; cursor: pointer; text-decoration: none; transition: all .15s; }
    .btn-primary { background: #6366f1; color: #fff; }
    .btn-primary:hover { background: #4f46e5; }
    .btn-secondary { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
    .btn-secondary:hover { background: #e5e7eb; }
    @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } .form-actions { flex-direction: column-reverse; } .btn { justify-content: center; } }
</style>
@endpush

@push('scripts')
<script>
// Live update avatar preview saat nama diubah
function updatePreview(name) {
    if (!name.trim()) return;
    document.getElementById('avatarImg').src =
        'https://ui-avatars.com/api/?name=' + encodeURIComponent(name) +
        '&size=128&background=6366f1&color=fff&bold=true';
}

// Toggle show/hide password
function togglePass(id, btn) {
    const input = document.getElementById(id);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.style.color = isText ? '#94a3b8' : '#6366f1';
}
</script>
@endpush