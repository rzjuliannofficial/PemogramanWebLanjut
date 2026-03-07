@extends('layout')

@section('title', 'Sales Transaction')

@section('content')
<style>
    .page-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        animation: fadeInUp 0.4s ease;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .page-header-left h1 {
        font-size: 2rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    
    .breadcrumb a {
        color: var(--primary);
        text-decoration: none;
        transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .breadcrumb a:hover {
        color: var(--primary-dark);
    }
    
    /* Filter Bar */
    .filter-bar {
        display: flex;
        align-items: flex-end;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        flex-wrap: wrap;
    }
    
    .filter-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex: 0 1 200px;
    }
    
    .filter-item label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .filter-item select {
        padding: 0.75rem 0.875rem;
        background: var(--bg-primary);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--text-primary);
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .filter-item select:hover {
        border-color: var(--primary);
        background: var(--bg-secondary);
    }
    
    .filter-item select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(91, 124, 255, 0.1);
    }
    
    /* Transaction List */
    .transaction-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .transaction-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
    }
    
    .transaction-card:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }
    
    /* Transaction Header */
    .transaction-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, var(--bg-primary) 0%, rgba(91, 124, 255, 0.04) 100%);
        border-bottom: 1px solid var(--border);
    }
    
    .transaction-id {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .transaction-badge {
        padding: 0.4rem 0.875rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        transition: all 0.25s;
    }
    
    .badge-completed {
        background: rgba(52, 199, 89, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .badge-pending {
        background: rgba(255, 149, 0, 0.1);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    
    /* Transaction Body */
    .transaction-body {
        padding: 1.5rem;
    }
    
    .transaction-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }
    
    .info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .info-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    /* Items Table */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }
    
    .items-table thead {
        background: var(--bg-primary);
    }
    
    .items-table th {
        padding: 0.875rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 1px solid var(--border);
    }
    
    .items-table td {
        padding: 0.875rem;
        color: var(--text-primary);
        border-top: 1px solid var(--border);
    }
    
    .items-table tbody tr {
        transition: background 0.2s;
    }
    
    .items-table tbody tr:hover {
        background: var(--bg-primary);
    }
    
    .items-table td[style*="text-align: right"],
    .items-table th[style*="text-align: right"] {
        text-align: right;
        font-family: 'Courier New', monospace;
        font-weight: 600;
    }
    
    /* Transaction Footer */
    .transaction-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 2px solid var(--primary);
    }
    
    .total-label {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .total-value {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-family: 'Courier New', monospace;
    }
    
    /* New Transaction Button */
    .btn-new {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(91, 124, 255, 0.25);
        white-space: nowrap;
    }
    
    .btn-new:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(91, 124, 255, 0.35);
    }
    
    .btn-new:active {
        transform: translateY(0);
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .transaction-info {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
        }
        
        .page-header-left h1 {
            font-size: 1.5rem;
        }
        
        .btn-new {
            width: 100%;
            justify-content: center;
        }
        
        .filter-bar {
            flex-direction: column;
        }
        
        .filter-item {
            flex: 1 1 100%;
        }
        
        .filter-item select {
            width: 100%;
        }
        
        .transaction-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
        
        .transaction-info {
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
        }
        
        .items-table {
            font-size: 0.8rem;
        }
        
        .items-table td,
        .items-table th {
            padding: 0.625rem;
        }
        
        .total-value {
            font-size: 1.25rem;
        }
    }
</style>

<div class="page-header">
    <div class="page-header-left">
        <h1>Sales Transactions</h1>
        <div class="breadcrumb">
            <a href="/">Dashboard</a>
            <span>/</span>
            <span>Sales</span>
        </div>
    </div>
    <button class="btn-new">➕ New Transaction</button>
</div>

<div class="filter-bar">
    <div class="filter-item">
        <label>Status</label>
        <select>
            <option>All Status</option>
            <option>Completed</option>
            <option>Pending</option>
        </select>
    </div>
    <div class="filter-item">
        <label>Date Range</label>
        <select>
            <option>Today</option>
            <option>This Week</option>
            <option>This Month</option>
        </select>
    </div>
</div>

<div class="transaction-list">
    @foreach($sales as $sale)
        <div class="transaction-card">
            <div class="transaction-header">
                <div class="transaction-id">{{ $sale['id'] }}</div>
                <div class="transaction-badge badge-{{ strtolower($sale['status']) }}">
                    {{ $sale['status'] }}
                </div>
            </div>
            
            <div class="transaction-body">
                <div class="transaction-info">
                    <div class="info-item">
                        <div class="info-label">📅 Date</div>
                        <div class="info-value">{{ date('M d, Y', strtotime($sale['date'])) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">👤 Customer</div>
                        <div class="info-value">{{ $sale['customer'] }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">📦 Items</div>
                        <div class="info-value">{{ count($sale['items']) }} items</div>
                    </div>
                </div>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Price</th>
                            <th style="text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale['items'] as $item)
                            <tr>
                                <td>{{ $item['product'] }}</td>
                                <td style="text-align: center;">{{ $item['qty'] }}</td>
                                <td style="text-align: right;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td style="text-align: right; font-weight: 700;">Rp {{ number_format($item['qty'] * $item['price'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="transaction-footer">
                    <span class="total-label">Total Amount</span>
                    <span class="total-value">Rp {{ number_format($sale['total'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
