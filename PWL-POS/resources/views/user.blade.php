@extends('layout')

@section('title', 'Data User')

@section('content')
<style>
    .page-header {
        margin-bottom: 2.5rem;
    }
    
    .page-header h1 {
        font-size: 2.2rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.25rem;
        letter-spacing: -0.5px;
    }
    
    .page-header p {
        color: var(--text-secondary);
        font-size: 0.95rem;
    }
    
    /* ===== TABLE STYLES ===== */
    .table-container {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table thead {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
    }
    
    .data-table thead th {
        padding: 1.25rem 1.5rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
    }
    
    .data-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: all 0.2s ease;
    }
    
    .data-table tbody tr:hover {
        background: var(--bg-hover);
    }
    
    .data-table tbody tr:last-child {
        border-bottom: none;
    }
    
    .data-table tbody td {
        padding: 1.125rem 1.5rem;
        color: var(--text-primary);
        font-size: 0.93rem;
    }
    
    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-secondary);
    }
    
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.6;
    }
    
    .empty-state p {
        font-size: 1rem;
    }
    
    /* ===== BADGE ===== */
    .badge {
        display: inline-block;
        padding: 0.4rem 0.85rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.2px;
    }
    
    .badge-primary {
        background: linear-gradient(135deg, rgba(91, 124, 255, 0.12) 0%, rgba(91, 124, 255, 0.08) 100%);
        color: var(--primary);
    }
    
    .badge-success {
        background: rgba(52, 199, 89, 0.12);
        color: var(--success);
    }
    
    .badge-warning {
        background: rgba(255, 149, 0, 0.12);
        color: var(--warning);
    }
    
    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.75rem;
        }
        
        .data-table thead th,
        .data-table tbody td {
            padding: 0.875rem 1rem;
            font-size: 0.85rem;
        }
    }
</style>

<div class="page-header">
    <h1>👤 Data User</h1>
    <p>Kelola dan lihat informasi semua pengguna sistem</p>
</div>

<div class="table-container">
    <table border="1" callpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
        </tr>
        <tr>
            <td><span class="badge badge-primary">{{ $data->user_id }}</span></td>
            <td><strong>{{ $data->username }}</strong></td>
            <td>{{ $data->nama }}</td>
            <td><span class="badge badge-success">Level {{ $data->level_id }}</span></td>
        </tr>
    </table>

    {{-- <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Jumlah Pengguna</th>
        </tr>
        <tr>
            <td>{{ $data }}</td>
        </tr>
    </table> --}}

    {{-- @if($data->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>ID Level Pengguna</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td><span class="badge badge-primary">{{ $d->user_id }}</span></td>
                    <td><strong>{{ $d->username }}</strong></td>
                    <td>{{ $d->nama }}</td>
                    <td><span class="badge badge-success">Level {{ $d->level_id }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <p>Tidak ada data pengguna tersedia</p>
        </div>
    @endif --}}
</div>

@endsection
