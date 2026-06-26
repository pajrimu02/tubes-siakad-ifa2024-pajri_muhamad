@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')
<div class="page-wrapper">

    <div class="page-header">
        <div class="header-left">
            <div class="header-title">
                <h1>Profil Saya</h1>
                <p>Informasi akun dan data pengguna</p>
            </div>
        </div>
        <a href="{{ route('profil.edit') }}" class="btn btn-edit">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Edit Profil
        </a>
    </div>

    @if(session('success'))
    <div class="flash-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- AVATAR CARD --}}
    <div class="avatar-card">
        <div class="av-circle">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&background=6366f1&color=fff&bold=true"
                 alt="{{ $user->name }}">
        </div>
        <div class="av-info">
            <div class="av-name">{{ $user->name }}</div>
            <div class="av-email">{{ $user->email }}</div>
            <div class="av-roles">
                @foreach($user->getRoleNames() as $role)
                    <span class="role-badge">{{ ucfirst($role) }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- DETAIL CARD --}}
    <div class="detail-card">
        <div class="detail-head">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>
            </svg>
            Informasi Akun
        </div>
        <table class="detail-table">
            <tr>
                <td class="dt-label">Nama Lengkap</td>
                <td class="dt-val">{{ $user->name }}</td>
            </tr>
            <tr>
                <td class="dt-label">Email</td>
                <td class="dt-val">{{ $user->email }}</td>
            </tr>
            <tr>
                <td class="dt-label">Role</td>
                <td class="dt-val">
                    @foreach($user->getRoleNames() as $role)
                        <span class="role-badge">{{ ucfirst($role) }}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="dt-label">Bergabung</td>
                <td class="dt-val">{{ $user->created_at?->format('d M Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="dt-label">Terakhir Diperbarui</td>
                <td class="dt-val">{{ $user->updated_at?->format('d M Y, H:i') ?? '-' }}</td>
            </tr>
        </table>
    </div>

</div>
@endsection

@push('styles')
<style>
    .page-wrapper { max-width: 720px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
    .page-header  { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .header-title h1 { font-size: 1.35rem; font-weight: 700; color: #111827; margin: 0; }
    .header-title p  { font-size: .85rem; color: #6b7280; margin: 2px 0 0; }
    .btn.btn-edit { display: inline-flex; align-items: center; gap: 6px; padding: .5rem 1.1rem; border-radius: 9px; font-size: .85rem; font-weight: 600; background: #fef3c7; color: #92400e; border: 1px solid #fde68a; text-decoration: none; transition: all .15s; }
    .btn.btn-edit:hover { background: #fde68a; }

    .flash-success { display: flex; align-items: center; gap: 8px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 10px; padding: .75rem 1rem; font-size: .875rem; font-weight: 500; margin-bottom: 1.25rem; }

    /* AVATAR CARD */
    .avatar-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 1.75rem; display: flex; align-items: center; gap: 1.5rem; box-shadow: 0 1px 4px rgba(0,0,0,.05); margin-bottom: 1.25rem; flex-wrap: wrap; }
    .av-circle img { width: 80px; height: 80px; border-radius: 50%; border: 3px solid #e0e7ff; object-fit: cover; }
    .av-name  { font-size: 1.15rem; font-weight: 700; color: #111827; }
    .av-email { font-size: .85rem; color: #6b7280; margin-top: 2px; }
    .av-roles { margin-top: .5rem; display: flex; gap: .4rem; flex-wrap: wrap; }
    .role-badge { background: #ede9fe; color: #5b21b6; font-size: .73rem; font-weight: 700; padding: 2px 10px; border-radius: 999px; }

    /* DETAIL CARD */
    .detail-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
    .detail-head { display: flex; align-items: center; gap: 8px; font-size: .88rem; font-weight: 700; color: #374151; background: #f8fafc; padding: .9rem 1.25rem; border-bottom: 1px solid #e5e7eb; }
    .detail-table { width: 100%; border-collapse: collapse; }
    .detail-table tr:not(:last-child) td { border-bottom: 1px solid #f1f5f9; }
    .dt-label { padding: .85rem 1.25rem; font-size: .83rem; font-weight: 600; color: #94a3b8; width: 200px; white-space: nowrap; }
    .dt-val   { padding: .85rem 1.25rem; font-size: .88rem; color: #1e293b; font-weight: 500; }
</style>
@endpush