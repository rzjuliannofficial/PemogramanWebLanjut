@extends('layout')

@section('title', 'Ubah Data User')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
    }
    
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
    
    .form-wrapper {
        background: var(--bg-secondary);
        padding: 2.5rem;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
    }
    
    .form-group {
        margin-bottom: 1.75rem;
        display: flex;
        flex-direction: column;
    }
    
    .form-group:last-of-type {
        margin-bottom: 2rem;
    }
    
    .form-group label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        letter-spacing: 0.2px;
    }
    
    .form-group input {
        padding: 0.875rem 1rem;
        border: 1px solid var(--border);
        border-radius: 9px;
        font-size: 0.95rem;
        font-family: inherit;
        transition: all 0.2s ease;
        color: var(--text-primary);
        background: #FFFFFF;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: var(--primary);
        background: var(--bg-hover);
        box-shadow: 0 0 0 3px rgba(91, 124, 255, 0.1);
    }
    
    .form-group input::placeholder {
        color: var(--text-tertiary);
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-start;
    }
    
    .btn {
        padding: 0.875rem 2rem;
        border-radius: 9px;
        border: none;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        letter-spacing: 0.3px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    .btn-secondary {
        background: var(--text-tertiary);
        color: white;
        box-shadow: var(--shadow-sm);
    }
    
    .btn-secondary:hover {
        background: var(--text-secondary);
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .form-wrapper {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>

<div class="form-container">
    <div class="page-header">
        <h1>✏️ Ubah Data User</h1>
        <p>Perbarui informasi pengguna sistem</p>
    </div>
    
    <div class="form-wrapper">
        <form method="post" action="/user/ubah_simpan/{{ $data->user_id }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" value="{{ $data->username }}" required>
            </div>
            
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" value="{{ $data->nama }}" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah password">
            </div>
            
            <div class="form-group">
                <label for="level_id">Level Pengguna</label>
                <input type="number" id="level_id" name="level_id" placeholder="Masukkan ID level (contoh: 1, 2, 3)" value="{{ $data->level_id }}" min="1" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="/user" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection