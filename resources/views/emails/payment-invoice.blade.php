<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: #f9fafb; 
            padding: 20px;
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: #fff; 
            border-radius: 16px; 
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
        }
        .header { 
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
            color: #fff; 
            padding: 40px; 
            text-align: center; 
        }
        .header h1 { 
            font-size: 28px; 
            margin-bottom: 8px; 
            font-weight: 600;
        }
        .header p { 
            opacity: 0.9; 
            font-size: 14px; 
        }
        .content { padding: 40px; }
        .invoice-badge {
            display: inline-block;
            background: #DBEAFE;
            color: #1E40AF;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
        }
        .status-badge {
            display: inline-block;
            background: #D1FAE5;
            color: #065F46;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .info-section { 
            margin-bottom: 32px; 
        }
        .info-section h2 { 
            font-size: 18px; 
            color: #1f2937; 
            margin-bottom: 16px;
            font-weight: 600;
        }
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            padding: 10px 0;
            color: #6b7280;
            font-size: 14px;
            width: 40%;
        }
        .info-value {
            display: table-cell;
            padding: 10px 0;
            color: #1f2937;
            font-size: 14px;
            font-weight: 500;
        }
        .divider { 
            border: 0; 
            border-top: 1px solid #e5e7eb; 
            margin: 24px 0; 
        }
        .package-card {
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 24px;
            margin: 24px 0;
        }
        .package-name {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .package-desc {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }
        .price-table {
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0;
        }
        .price-table tr {
            border-bottom: 1px solid #f3f4f6;
        }
        .price-table tr:last-child {
            border-bottom: none;
        }
        .price-table td {
            padding: 12px 0;
            font-size: 14px;
        }
        .price-table td:last-child {
            text-align: right;
            font-weight: 500;
        }
        .price-label {
            color: #6b7280;
        }
        .total-row {
            background: #F9FAFB;
            padding: 16px 0 !important;
        }
        .total-row td {
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
            padding: 16px 0 !important;
        }
        .total-amount {
            color: #3B82F6 !important;
            font-size: 20px !important;
        }
        .features-list {
            margin-top: 16px;
            padding-left: 20px;
        }
        .features-list li {
            color: #4b5563;
            font-size: 14px;
            margin-bottom: 8px;
            line-height: 1.5;
        }
        .cta-button {
            display: inline-block;
            background: #3B82F6;
            color: #fff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            text-align: center;
            margin: 24px 0;
        }
        .cta-button:hover {
            background: #2563EB;
        }
        .footer { 
            background: #f9fafb;
            padding: 32px 40px; 
            text-align: center; 
            font-size: 13px; 
            color: #6b7280; 
            border-top: 1px solid #e5e7eb;
        }
        .footer p { 
            margin-bottom: 8px; 
        }
        .footer a {
            color: #3B82F6;
            text-decoration: none;
        }
        .note-box {
            background: #FEF3C7;
            border-left: 4px solid #F59E0B;
            padding: 16px;
            border-radius: 8px;
            margin: 24px 0;
        }
        .note-box p {
            color: #92400E;
            font-size: 14px;
            margin: 0;
        }
        @media only screen and (max-width: 600px) {
            body { padding: 10px; }
            .header, .content, .footer { padding: 24px; }
            .header h1 { font-size: 24px; }
            .package-name { font-size: 18px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>💍 {{ config('app.name') }}</h1>
            <p>Invoice Pembayaran</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Invoice Info -->
            <div class="invoice-badge">
                📄 Invoice #{{ $payment->order_id }}
            </div>
            <div style="margin-bottom: 24px;">
                <span class="status-badge">✓ Pembayaran Berhasil</span>
            </div>

            <p style="font-size: 15px; color: #4b5563; margin-bottom: 32px;">
                Halo <strong>{{ $user->name }}</strong>,<br>
                Terima kasih atas pembayaran Anda! Berikut adalah detail invoice pembayaran paket undangan digital Anda.
            </p>

            <hr class="divider">

            <!-- Customer Info -->
            <div class="info-section">
                <h2>📋 Informasi Pelanggan</h2>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    @if($invitation)
                    <div class="info-row">
                        <div class="info-label">Undangan</div>
                        <div class="info-value">{{ $invitation->title ?? 'N/A' }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Info -->
            <div class="info-section">
                <h2>💳 Informasi Pembayaran</h2>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Order ID</div>
                        <div class="info-value">{{ $payment->order_id }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Transaction ID</div>
                        <div class="info-value">{{ $payment->transaction_id ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tanggal Bayar</div>
                        <div class="info-value">{{ $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') . ' WIB' : '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Metode Pembayaran</div>
                        <div class="info-value">{{ ucwords(str_replace('_', ' ', $payment->payment_type ?? 'N/A')) }}</div>
                    </div>
                </div>
            </div>

            <hr class="divider">

            <!-- Package Details -->
            <div class="package-card">
                <div class="package-name">{{ $package->name }}</div>
                <div class="package-desc">{{ $package->description }}</div>
                
                @if($package->features)
                <ul class="features-list">
                    @foreach((is_array($package->features) ? $package->features : json_decode($package->features, true)) ?? [] as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
                @endif
            </div>

            <!-- Price Breakdown -->
            <table class="price-table">
                <tr>
                    <td class="price-label">Harga Paket</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
                @if($payment->discount_amount > 0)
                <tr>
                    <td class="price-label">Diskon</td>
                    <td style="color: #059669;">- Rp {{ number_format($payment->discount_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td><strong>Total Pembayaran</strong></td>
                    <td class="total-amount"><strong>Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</strong></td>
                </tr>
            </table>

            <hr class="divider">

            <!-- Subscription Info -->
            <div class="note-box">
                <p><strong>📅 Periode Aktif:</strong> Paket ini berlaku selama {{ $package->duration_days }} hari sejak pembayaran berhasil.</p>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center; margin-top: 32px;">
                <a href="{{ route('customer.dashboard') }}" class="cta-button">
                    🎨 Buat Undangan Sekarang
                </a>
            </div>

            <p style="font-size: 14px; color: #6b7280; text-align: center; margin-top: 16px;">
                Atau login ke dashboard Anda di <a href="{{ config('app.url') }}" style="color: #3B82F6;">{{ config('app.url') }}</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Butuh bantuan?</strong></p>
            <p>Hubungi kami di <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a></p>
            <p style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
