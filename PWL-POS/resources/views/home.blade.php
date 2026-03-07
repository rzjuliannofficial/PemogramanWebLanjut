@extends('layout')

@section('title', 'Dashboard')

@section('content')
<style>
    .page-header {
        margin-bottom: 3rem;
    }
    
    .page-header h1 {
        font-size: 2.2rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }
    
    .page-header p {
        color: var(--text-secondary);
        font-size: 1rem;
    }
    
    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    
    .stat-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
    }
    
    .stat-card.success::before {
        background: linear-gradient(90deg, var(--success), #52D890);
    }
    
    .stat-card.warning::before {
        background: linear-gradient(90deg, var(--warning), #FFB023);
    }
    
    .stat-card.info::before {
        background: linear-gradient(90deg, var(--info), #1FD9E8);
    }
    
    .stat-card:hover {
        border-color: var(--primary);
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }
    
    .stat-card:hover.success {
        border-color: var(--success);
    }
    
    .stat-card:hover.warning {
        border-color: var(--warning);
    }
    
    .stat-card:hover.info {
        border-color: var(--info);
    }
    
    .stat-content {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
    }
    
    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        background: var(--bg-hover);
        flex-shrink: 0;
    }
    
    .stat-info h3 {
        font-size: 0.85rem;
        color: var(--text-secondary);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 0.5rem;
    }
    
    .stat-value {
        font-size: 1.75rem;
        color: var(--text-primary);
        font-weight: 700;
        line-height: 1;
        letter-spacing: -0.3px;
    }
    
    /* ===== ACTIONS ===== */
    .actions-section {
        margin-top: 3rem;
    }
    
    .section-title {
        font-size: 1.1rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.95rem;
    }
    
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .action-card {
        padding: 2rem;
        border-radius: 12px;
        color: white;
        text-decoration: none;
        display: block;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }
    
    .action-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15), transparent);
        pointer-events: none;
    }
    
    .action-card.primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        box-shadow: var(--shadow-md);
    }
    
    .action-card.secondary {
        background: linear-gradient(135deg, var(--success) 0%, #52D890 100%);
        box-shadow: var(--shadow-md);
    }
    
    .action-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
    }
    
    .action-content {
        position: relative;
        z-index: 1;
    }
    
    .action-card h3 {
        font-size: 1.2rem;
        margin-bottom: 0.75rem;
        font-weight: 700;
        letter-spacing: -0.2px;
    }
    
    .action-card p {
        opacity: 0.95;
        font-size: 0.9rem;
        line-height: 1.5;
    }
</style>

<div class="page-header">
    <h1>Dashboard</h1>
    <p>Welcome! Here's your store overview</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-content">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <h3>Products</h3>
                <div class="stat-value">1,234</div>
            </div>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-icon">💰</div>
            <div class="stat-info">
                <h3>Revenue</h3>
                <div class="stat-value">Rp 125M</div>
            </div>
        </div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-content">
            <div class="stat-icon">📊</div>
            <div class="stat-info">
                <h3>Sales Today</h3>
                <div class="stat-value">45</div>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <h3>Customers</h3>
                <div class="stat-value">892</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="actions-section">
    <h2 class="section-title">Quick Actions</h2>
    <div class="actions-grid">
        <a href="/sales" class="action-card primary">
            <div class="action-content">
                <h3>💳 New Sale</h3>
                <p>Create and process a new sales transaction</p>
            </div>
        </a>
        <a href="/category/food-beverage" class="action-card secondary">
            <div class="action-content">
                <h3>🏪 Products</h3>
                <p>Manage and view all available products</p>
            </div>
        </a>
    </div>
</div>
@endsection
