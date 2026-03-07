@extends('layout')

@section('title', 'Profile - ' . $user['name'])

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
    
    .breadcrumb {
        color: var(--text-secondary);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .breadcrumb a {
        color: var(--primary);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .breadcrumb a:hover {
        color: var(--primary-dark);
    }
    
    .profile-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
    }
    
    /* ===== SIDEBAR ===== */
    .profile-sidebar {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 2rem;
        height: fit-content;
        box-shadow: var(--shadow-sm);
        position: sticky;
        top: 2.5rem;
    }
    
    .profile-avatar-container {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border);
    }
    
    .profile-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        font-weight: 700;
        box-shadow: 0 8px 16px rgba(91, 124, 255, 0.3);
    }
    
    .profile-name {
        font-size: 1.4rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.3px;
    }
    
    .profile-role {
        color: var(--text-secondary);
        font-size: 0.9rem;
        display: inline-block;
        background: var(--bg-hover);
        padding: 0.375rem 0.875rem;
        border-radius: 8px;
        margin-top: 0.5rem;
        font-weight: 500;
    }
    
    .profile-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 1.75rem;
        padding-top: 1.75rem;
        border-top: 1px solid var(--border);
    }
    
    .stat-item {
        text-align: center;
        padding: 1rem;
        background: var(--bg-hover);
        border-radius: 10px;
        transition: all 0.2s;
    }
    
    .stat-item:hover {
        background: linear-gradient(135deg, rgba(91, 124, 255, 0.08) 0%, rgba(91, 124, 255, 0.04) 100%);
    }
    
    .stat-value {
        font-size: 1.6rem;
        color: var(--primary);
        font-weight: 700;
        line-height: 1;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.375rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        font-weight: 600;
    }
    
    .btn-edit {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 1.5rem;
        box-shadow: var(--shadow-md);
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    /* ===== MAIN CONTENT ===== */
    .profile-main {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }
    
    .info-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
    }
    
    .info-card h2 {
        font-size: 1.15rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        letter-spacing: -0.2px;
    }
    
    .info-card h2::before {
        content: '';
        width: 3px;
        height: 24px;
        background: linear-gradient(180deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 2px;
    }
    
    .info-row {
        display: grid;
        grid-template-columns: 150px 1fr;
        padding: 1.25rem 0;
        border-bottom: 1px solid var(--border);
        align-items: center;
    }
    
    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .info-label {
        font-size: 0.85rem;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .info-value {
        font-size: 0.95rem;
        color: var(--text-primary);
        font-weight: 500;
    }
    
    .status-badge {
        display: inline-block;
        background: linear-gradient(135deg, rgba(52, 199, 89, 0.1) 0%, rgba(82, 216, 144, 0.1) 100%);
        color: var(--success);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .role-badge {
        display: inline-block;
        background: linear-gradient(135deg, rgba(91, 124, 255, 0.1) 0%, rgba(123, 159, 255, 0.1) 100%);
        color: var(--primary);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    @media (max-width: 1024px) {
        .profile-layout {
            grid-template-columns: 1fr;
        }
        
        .profile-sidebar {
            position: relative;
            top: auto;
        }
    }
    
    @media (max-width: 768px) {
        .info-row {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
        
        .info-label {
            margin-bottom: 0.25rem;
        }
    }
    .page-header {
        margin-bottom: 2.5rem;
        animation: slideDown 0.4s ease;
    }
    
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .page-header h1 {
        font-size: 2.25rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .breadcrumb {
        color: var(--text-secondary);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .breadcrumb a {
        color: var(--primary);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .breadcrumb a:hover {
        color: var(--primary-dark);
    }
    
    .profile-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 2.5rem;
    }
    
    .profile-sidebar {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 2.5rem 2rem;
        height: fit-content;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        position: sticky;
        top: 2.5rem;
    }
    
    .profile-avatar-container {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border);
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        font-weight: 700;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
    }
    
    .profile-name {
        font-size: 1.5rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.375rem;
    }
    
    .profile-role {
        color: var(--text-secondary);
        font-size: 0.95rem;
        display: inline-block;
        background: var(--bg-primary);
        padding: 0.375rem 1rem;
        border-radius: 8px;
        margin-top: 0.5rem;
    }
    
    .profile-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border);
    }
    
    .stat-item {
        text-align: center;
        padding: 1rem;
        background: var(--bg-primary);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .stat-item:hover {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(148, 163, 241, 0.05) 100%);
    }
    
    .stat-value {
        font-size: 1.875rem;
        color: var(--primary);
        font-weight: 700;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-top: 0.375rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    
    .btn-edit {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }
    
    .profile-main {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    
    .info-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        border-color: var(--primary);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.1);
    }
    
    .info-card h2 {
        font-size: 1.25rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .info-card h2::before {
        content: '';
        width: 4px;
        height: 24px;
        background: linear-gradient(180deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 2px;
    }
    
    .info-row {
        display: grid;
        grid-template-columns: 180px 1fr;
        padding: 1.5rem 0;
        border-bottom: 1px solid var(--border);
        align-items: center;
    }
    
    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .info-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    
    .info-value {
        font-size: 0.95rem;
        color: var(--text-primary);
        font-weight: 500;
    }
    
    .status-badge {
        display: inline-block;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(52, 211, 153, 0.1) 100%);
        color: var(--success);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .role-badge {
        display: inline-block;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(129, 140, 248, 0.1) 100%);
        color: var(--primary);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    @media (max-width: 1024px) {
        .profile-layout {
            grid-template-columns: 1fr;
        }
        
        .profile-sidebar {
            position: relative;
            top: auto;
        }
    }
    
    @media (max-width: 768px) {
        .info-row {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
        
        .info-label {
            margin-bottom: 0.25rem;
        }
    }
</style>

<div class="page-header">
    <h1>Profile</h1>
    <div class="breadcrumb">
        <a href="/">Dashboard</a>
        <span>/</span>
        <span>Profile</span>
    </div>
</div>

<div class="profile-layout">
    <div class="profile-sidebar">
        <div class="profile-avatar-container">
            <div class="profile-avatar">
                {{ strtoupper(substr($user['name'], 0, 1)) }}
            </div>
            <div class="profile-name">{{ $user['name'] }}</div>
            <div class="profile-role">{{ $user['role'] }}</div>
        </div>
        
        <div class="profile-stats">
            <div class="stat-item">
                <div class="stat-value">45</div>
                <div class="stat-label">Sales</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">12</div>
                <div class="stat-label">Today</div>
            </div>
        </div>
        
        <button class="btn-edit">✏️ Edit Profile</button>
    </div>

    <div class="profile-main">
        <div class="info-card">
            <h2>Personal Information</h2>
            <div class="info-row">
                <div class="info-label">User ID</div>
                <div class="info-value">#{{ str_pad($user['id'], 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Full Name</div>
                <div class="info-value">{{ $user['name'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email Address</div>
                <div class="info-value">{{ $user['email'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Role</div>
                <div class="info-value">
                    <div class="role-badge">{{ $user['role'] }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Joined Date</div>
                <div class="info-value">{{ date('F d, Y', strtotime($user['joined_date'])) }}</div>
            </div>
        </div>

        <div class="info-card">
            <h2>Activity</h2>
            <div class="info-row">
                <div class="info-label">Last Login</div>
                <div class="info-value">{{ date('F d, Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Transaction</div>
                <div class="info-value">2 hours ago</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <div class="status-badge">🟢 Active</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
