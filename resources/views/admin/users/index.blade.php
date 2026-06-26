@extends('layouts.admin')

@push('styles')
<style>
    .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.18s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        color: #fff;
    }

    .btn-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(0,0,0,0.14);
    }

    .btn-add { background: linear-gradient(135deg,#6366f1,#4f46e5); }
    .btn-export { background: linear-gradient(135deg,#22c55e,#16a34a); }
    .btn-import { background: linear-gradient(135deg,#0ea5e9,#0284c7); }

    /* SEARCH */
    .search-wrap {
        position: relative;
    }

    .search-wrap .search-ico {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
    }

    .search-wrap input {
        padding: 9px 16px 9px 34px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        width: 280px;
        outline: none;
        font-size: 13.5px;
    }

    .search-wrap input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    }

    /* CARD */
    .card-modern {
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .card-modern .card-header {
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-modern .card-header h5 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
    }

    /* TABLE */
    .table-modern thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 13px 14px;
    }

    .table-modern tbody td {
        padding: 13px 14px;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-modern tbody tr:hover td {
        background: #fafbff;
    }

    /* ROLE BADGE */
    .badge-role {
        display: inline-flex;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .role-admin {
        background: #fee2e2;
        color: #b91c1c;
    }

    .role-mahasiswa {
        background: #dbeafe;
        color: #1d4ed8;
    }

    /* ACTION (MEPET KANAN FIX) */
    .action-wrap {
        display: flex;
        justify-content: flex-end; /* 🔥 ini bikin mepet kanan */
        gap: 6px;
        width: 100%;
    }

    .act-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: 12.5px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: 0.15s;
        white-space: nowrap;
    }

    .act-btn:hover {
        transform: translateY(-1px);
        opacity: 0.9;
    }

    .act-detail { background:#e0f2fe; color:#0369a1; }
    .act-edit   { background:#fef9c3; color:#92400e; }
    .act-delete { background:#fee2e2; color:#b91c1c; }

    /* EMPTY */
    .empty-state {
        padding: 50px;
        text-align: center;
        color: #94a3b8;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="row mb-3 align-items-center">

        <div class="col-md-6">
            <div class="d-flex gap-2 flex-wrap">

                <a href="{{ route('users.create') }}" class="btn-modern btn-add">
                    <i class="fa fa-plus"></i> Tambah User
                </a>

                <a href="{{ route('users.export.excel') }}" class="btn-modern btn-export">
                    <i class="fa fa-file-excel"></i> Export
                </a>

                <form action="{{ route('users.import.excel') }}"
                      method="POST"
                      enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <input type="file" id="file" name="file" hidden>
                    <button type="button"
                            class="btn-modern btn-import"
                            onclick="document.getElementById('file').click();">
                        <i class="fa fa-upload"></i> Import
                    </button>
                </form>

            </div>
        </div>

        {{-- SEARCH --}}
        <div class="col-md-6 d-flex justify-content-end mt-2 mt-md-0">

            <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2">

                <div class="search-wrap">
                    <i class="fa fa-search search-ico"></i>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari user..."
                           autocomplete="off">
                </div>

                <button class="btn-modern btn-add" style="padding:9px 14px;">
                    <i class="fa fa-search"></i>
                </button>

                @if(request('search'))
                    <a href="{{ route('users.index') }}"
                       class="btn-modern"
                       style="background:#94a3b8;padding:9px 14px;">
                        <i class="fa fa-times"></i>
                    </a>
                @endif

            </form>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card card-modern">

        <div class="card-header">
            <h5>
                <i class="fa fa-users" style="color:#6366f1;"></i>
                Data User
            </h5>

            <small class="text-muted">{{ $users->total() }} data</small>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-modern mb-0">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="120" class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($users as $key => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            {{-- ROLE CATEGORY --}}
                            <td>
                                @foreach($user->getRoleNames() as $role)
                                    @if($role == 'admin')
                                        <span class="badge-role role-admin">Admin</span>
                                    @else
                                        <span class="badge-role role-mahasiswa">Mahasiswa</span>
                                    @endif
                                @endforeach
                            </td>

                      
                            <td class="text-end">
                                <div class="action-wrap">

                                    <a href="{{ route('users.show', $user->id) }}"
                                       class="act-btn act-detail">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>

                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="act-btn act-edit">
                                        <i class="fa fa-pen"></i> Edit
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="act-btn act-delete"
                                                onclick="return confirm('Hapus user?')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="fa fa-users"></i>
                                Tidak ada data user
                            </td>
                        </tr>
                    @endforelse

                    </tbody>

                </table>
            </div>

        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center px-4 py-3"
             style="border-top:1px solid #f1f5f9;">
            <small class="text-muted">
                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                dari {{ $users->total() }}
            </small>

            {{ $users->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

@endsection