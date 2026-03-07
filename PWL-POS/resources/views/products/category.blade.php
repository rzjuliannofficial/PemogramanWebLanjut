@extends('layout')

@section('title', 'Products - ' . $category)

@section('content')
<style>
    .page-header {
        margin-bottom: 2.5rem;
    }
    
    .page-header h1 {
        font-size: 2.2rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
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
    
    .search-filter-bar {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        padding: 1.5rem;
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
    }
    
    .search-box {
        flex: 1;
        position: relative;
    }
    
    .search-box input {
        width: 100%;
        padding: 0.85rem 1rem 0.85rem 2.75rem;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 0.9rem;
        transition: all 0.25s;
        background: var(--bg-hover);
        color: var(--text-primary);
        font-weight: 500;
    }
    
    .search-box input::placeholder {
        color: var(--text-tertiary);
    }
    
    .search-box input:focus {
        outline: none;
        border-color: var(--primary);
        background: var(--bg-secondary);
        box-shadow: 0 0 0 3px rgba(91, 124, 255, 0.1);
    }
    
    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 1rem;
        pointer-events: none;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }
    
    .product-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.5rem 1.25rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-sm);
    }
    
    .product-card:hover {
        border-color: var(--primary);
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }
    
    .product-image {
        width: 100%;
        height: 150px;
        background: linear-gradient(135deg, var(--bg-hover) 0%, rgba(91, 124, 255, 0.05) 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin-bottom: 1.25rem;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-id {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .product-name {
        font-size: 1rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }
    
    .product-price {
        font-size: 1.3rem;
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 1rem;
        flex-grow: 1;
    }
    
    .add-btn {
        width: 100%;
        padding: 0.75rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s;
        box-shadow: var(--shadow-sm);
    }
    
    .add-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    .add-btn:active {
        transform: translateY(0);
    }
    
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }
    
    .empty-state-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
    }
    
    .empty-state h3 {
        font-size: 1.5rem;
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    @media (max-width: 1024px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.5rem;
        }

        .search-filter-bar {
            flex-direction: column;
        }

        .search-box {
            flex: 1;
        }

        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }

        .product-card {
            padding: 1rem;
        }

        .product-image {
            height: 120px;
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        .product-name {
            font-size: 0.9rem;
        }

        .product-price {
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
        }

        .add-btn {
            padding: 0.625rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1>{{ $category }}</h1>
        <div class="breadcrumb">
            <a href="/">Dashboard</a>
            <span>/</span>
            <a href="#">Products</a>
            <span>/</span>
            <span>{{ $category }}</span>
        </div>
    </div>
</div>

<div class="search-filter-bar">
    <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Search products...">
    </div>
</div>

@if(count($products) > 0)
    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card">
                <div class="product-image">🛍️</div>
                <div class="product-info">
                    <div class="product-id">#{{ str_pad($product['id'], 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="product-name">{{ $product['name'] }}</div>
                    <div class="product-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</div>
                </div>
                <button class="add-btn">🛒 Add to Cart</button>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">📦</div>
        <h3>No products found</h3>
        <p>There are no products in this category yet</p>
    </div>
@endif
@endsection
