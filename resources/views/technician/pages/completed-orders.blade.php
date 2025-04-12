@extends('technician.index')

@section('content')
<style>
    body {
        background: #f9fafb;
    }

    .order-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .order-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .order-desc {
        font-size: 0.95rem;
        color: #4b5563;
    }

    .order-location {
        font-size: 0.75rem;
        font-weight: 600;
        background: #fef3c7;
        color: #92400e;
        padding: 6px 14px;
        border-radius: 9999px;
        display: inline-block;
        margin-bottom: 10px;
    }

    .view-btn {
        font-size: 0.85rem;
        padding: 8px 16px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(to right, #10b981, #059669);
        color: white;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
    }

    .view-btn:hover {
        background: linear-gradient(to right, #059669, #047857);
        box-shadow: 0 6px 15px rgba(5, 150, 105, 0.3);
    }

    .order-badge {
        position: absolute;
        top: 0;
        right: 0;
        font-size: 0.75rem;
        font-weight: bold;
        padding: 6px 14px;
        border-radius: 0 16px 0 16px;
        color: white;
        background: #10b981;
    }
</style>

<div class="row">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0" style="font-size: 1.8rem; color: #1f2937;">✅ Completed Orders</h2>
        <span class="badge bg-success text-white px-3 py-2" style="border-radius: 12px; font-size: 0.9rem;">
            5 Orders Completed {{ Auth::user()->name }}
        </span>
    </div>

    <div class="col-md-12 mb-4">
        <div class="order-card">
            <div class="order-badge">Completed</div>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-3">
                    <div class="order-title">Microwave Repair</div>
                    <div class="order-desc">Fixed heating issue and replaced internal fuse.</div>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <div class="order-location">F-10 Islamabad</div>
                    <button class="view-btn">View Details</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="order-card">
            <div class="order-badge">Completed</div>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-3">
                    <div class="order-title">CCTV Installation</div>
                    <div class="order-desc">Installed 4 cameras and configured mobile view.</div>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <div class="order-location">Gulberg Green</div>
                    <button class="view-btn">View Details</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="order-card">
            <div class="order-badge">Completed</div>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-3">
                    <div class="order-title">Fridge Gas Refill</div>
                    <div class="order-desc">Recharged gas to restore proper cooling.</div>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <div class="order-location">G-11 Markaz</div>
                    <button class="view-btn">View Details</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="order-card">
            <div class="order-badge">Completed</div>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-3">
                    <div class="order-title">Inverter AC Service</div>
                    <div class="order-desc">Complete cleaning and performance testing.</div>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <div class="order-location">PWD Colony</div>
                    <button class="view-btn">View Details</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="order-card">
            <div class="order-badge">Completed</div>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="me-3">
                    <div class="order-title">Geyser Replacement</div>
                    <div class="order-desc">Old geyser removed and new one installed.</div>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <div class="order-location">I-10 Islamabad</div>
                    <button class="view-btn">View Details</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
