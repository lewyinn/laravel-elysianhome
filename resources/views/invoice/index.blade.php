<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .invoice-container {
            max-width: 850px;
            margin: 20px auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Header Section */
        .header {
            background: linear-gradient(135deg, #2d5a4a 0%, #4a8b6b 100%);
            color: white;
            padding: 40px 30px;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="wave" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M0,10 Q5,0 10,10 T20,10" stroke="rgba(255,255,255,0.1)" stroke-width="1" fill="none"/></pattern></defs><rect width="100" height="100" fill="url(%23wave)"/></svg>') repeat;
            opacity: 0.3;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            z-index: 2;
        }

        .invoice-title {
            font-size: 48px;
            font-weight: bold;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .invoice-number {
            font-size: 18px;
            opacity: 0.9;
            font-weight: 300;
        }

        .header-info {
            text-align: right;
        }

        .date-section {
            margin-bottom: 20px;
        }

        .date-label {
            color: #ffd700;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .date-value {
            font-size: 16px;
            font-weight: 300;
        }

        .company-info {
            text-align: right;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .company-contact {
            font-size: 14px;
            opacity: 0.9;
        }

        /* Content Section */
        .content {
            padding: 40px 30px;
        }

        /* Items Table */
        .items-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            color: #2d5a4a;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e8f5f0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .items-table thead {
            background: linear-gradient(90deg, #2d5a4a 0%, #4a8b6b 100%);
            color: white;
        }

        .items-table th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table th:last-child,
        .items-table td:last-child {
            text-align: right;
        }

        .items-table tbody tr:nth-child(even) {
            background-color: #f8fffe;
        }

        .items-table tbody tr:hover {
            background-color: #e8f5f0;
        }

        .items-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .product-name {
            font-weight: 600;
            color: #2d5a4a;
        }

        .quantity {
            text-align: center;
            font-weight: 600;
            color: #666;
        }

        .price {
            font-weight: 500;
            color: #555;
        }

        .total-row {
            font-weight: bold;
            background: linear-gradient(90deg, #f0f9f6 0%, #e8f5f0 100%);
            color: #2d5a4a;
            font-size: 16px;
        }

        /* Summary Section */
        .summary-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 30px;
        }

        .payment-info {
            flex: 1;
            background: #f8fffe;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #4a8b6b;
            margin-right: 30px;
        }

        .payment-title {
            font-size: 16px;
            font-weight: bold;
            color: #2d5a4a;
            margin-bottom: 15px;
        }

        .payment-details {
            font-size: 14px;
            line-height: 1.8;
        }

        .payment-details strong {
            color: #2d5a4a;
        }

        .total-summary {
            flex: 1;
            max-width: 300px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
        }

        .summary-row:last-child {
            border-bottom: none;
            padding-top: 15px;
            margin-top: 10px;
            border-top: 2px solid #2d5a4a;
        }

        .summary-label {
            font-weight: 600;
            color: #555;
        }

        .summary-value {
            font-weight: 600;
            color: #2d5a4a;
        }

        .final-total {
            font-size: 18px;
            font-weight: bold;
            color: #2d5a4a;
        }

        .final-total .summary-value {
            font-size: 20px;
        }

        /* Footer */
        .footer {
            background: #f8fffe;
            padding: 30px;
            text-align: center;
            margin-top: 40px;
            border-top: 1px solid #e0e0e0;
        }

        .thank-you {
            font-size: 24px;
            font-weight: bold;
            color: #2d5a4a;
            margin-bottom: 15px;
        }

        .contact-info {
            font-size: 14px;
            color: #666;
            line-height: 1.8;
        }

        .contact-info a {
            color: #4a8b6b;
            text-decoration: none;
            font-weight: 500;
        }

        /* Responsive adjustments for PDF */
        @media print {
            body {
                background-color: white;
            }

            .invoice-container {
                box-shadow: none;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div>
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-number">No. {{ $order->order_number }}</div>
                </div>

                <div class="header-info">
                    <div class="date-section">
                        <div class="date-label">Issued Date:</div>
                        <div class="date-value">{{ $order->created_at }}</div>
                    </div>

                    <div class="company-info">
                        <div class="company-name">LewyinDev Store</div>
                        <div class="company-contact">www.lewyindev.com</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Items Section -->
            <div class="items-section">
                <h3 class="section-title">Items</h3>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($order->orderItems->count() === 1)
                            @php
                                $item = $order->orderItems->first();
                            @endphp
                            <tr>
                                <td class="product-name">{{ $item->product->name }}</td>
                                <td class="quantity">{{ $item->quantity }}</td>
                                <td class="price">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="price">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                        @else
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td class="product-name">{{ $item->product->name }}</td>
                                    <td class="quantity">{{ $item->quantity }}</td>
                                    <td class="price">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="price">Rp
                                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Summary Section -->
            <div class="summary-section">
                <div class="payment-info">
                    <div class="payment-title">Catatan</div>
                    <div class="payment-details">
                        Silahkan Hubungi Customer Service kami jika ada Pertanyaan Mengenai invoice ini ataupun Mengenai
                        pesanan anda.<br>
                        <strong>WhatsApp</strong> : <a href="https://wa.me/6281234567890">+62 812-3456-7890</a><br>
                        <strong>Email</strong> : <a href="mailto:renzlewyin@gmail.com">renzlewyin@gmail.com</a>
                    </div>
                </div>

                <div class="total-summary">
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Tax (0%)</span>
                        <span class="summary-value">Rp 0</span>
                    </div>
                    <div class="summary-row final-total">
                        <span class="summary-label">Total Price</span>
                        <span class="summary-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">THANKS FOR YOUR PURCHASE</div>
            <div class="contact-info">
                Jika ada pertanyaan, silakan hubungi customer service kami di<br>
                Email: <a href="mailto:support@lewyindev.com">support@lewyindev.com</a> |
                Website: <a href="https://www.lewyindev.com">www.lewyindev.com</a>
            </div>
        </div>
    </div>
</body>

</html>
