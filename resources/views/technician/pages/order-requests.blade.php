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
            background: #e0f2fe;
            color: #0369a1;
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
            background: linear-gradient(to right, #3b82f6, #2563eb);
            color: white;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);
        }

        .view-btn:hover {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
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
        }

        .badge-new {
            background: #22c55e;
        }

        .badge-viewed {
            background: #6b7280;
        }
        h2 {
        font-weight: 700;
        font-size: 1.8rem;
        color: #1f2937;
    }

    </style>

    <div class="row">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="fw-bold " style="font-size: 1.8rem; color: #1f2937;">📦 Order Requests</h2>
            <span class="badge bg-success text-white px-3 py-2" style="border-radius: 12px; font-size: 0.9rem;">
                5 Orders Requests
            </span>
        </div>
        
        <div class="col-md-12 mb-4">
            <div class="order-card">
                <div class="order-badge badge-new">New</div>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="me-3">
                        <div class="order-title">Air Conditioner Repair</div>
                        <div class="order-desc">No cooling and making loud noise — urgent summer fix needed.</div>
                    </div>
                    <div class="text-end mt-3 mt-md-0">
                        <div class="order-location">G-10 Islamabad</div>
                        <button class="view-btn">View Order</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <div class="order-card">
                <div class="order-badge badge-viewed">Viewed</div>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="me-3">
                        <div class="order-title">Water Leakage Fix</div>
                        <div class="order-desc">Leak under sink causing kitchen flooding. Needs plumber.</div>
                    </div>
                    <div class="text-end mt-3 mt-md-0">
                        <div class="order-location">DHA Phase 2</div>
                        <button class="view-btn">View Order</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <div class="order-card">
                <div class="order-badge badge-new">New</div>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="me-3">
                        <div class="order-title">LED TV Installation</div>
                        <div class="order-desc">Mount 55” Smart TV on bedroom wall with concealed wiring.</div>
                    </div>
                    <div class="text-end mt-3 mt-md-0">
                        <div class="order-location">Bahria Town Phase 7</div>
                        <button class="view-btn">View Order</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <div class="order-card">
                <div class="order-badge badge-viewed">Viewed</div>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="me-3">
                        <div class="order-title">Washing Machine Service</div>
                        <div class="order-desc">Drainage issue suspected. Machine not finishing cycles.</div>
                    </div>
                    <div class="text-end mt-3 mt-md-0">
                        <div class="order-location">F-11 Markaz</div>
                        <button class="view-btn">View Order</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <div class="order-card">
                <div class="order-badge badge-new">New</div>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="me-3">
                        <div class="order-title">Ceiling Fan Replacement</div>
                        <div class="order-desc">Old fan removed and new one installed by customer’s request.</div>
                    </div>
                    <div class="text-end mt-3 mt-md-0">
                        <div class="order-location">I-8 Sector</div>
                        <button class="view-btn">View Order</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endsection
