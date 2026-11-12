<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice #{{ $billing->id }} - DentalCare</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f1f5f9;
            color: #1e293b;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .invoice {
            max-width: 850px;
            margin: auto;
            padding: 40px;
            background: white;
            border: 1px solid #e2e8f0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding-bottom: 25px;
            border-bottom: 2px solid #2563eb;
        }

        .clinic-name {
            margin: 0;
            color: #1d4ed8;
            font-size: 27px;
            font-weight: bold;
        }

        .invoice-title {
            margin: 0;
            font-size: 26px;
            text-align: right;
        }

        .muted {
            color: #64748b;
        }

        .section {
            margin-top: 30px;
        }

        .section-title {
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: bold;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .info-item {
            margin-bottom: 12px;
        }

        .info-label {
            margin-bottom: 5px;
            color: #64748b;
            font-size: 12px;
        }

        .info-value {
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #eff6ff;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-box {
            margin-top: 20px;
            padding: 20px;
            background: #eff6ff;
            text-align: right;
        }

        .total-label {
            color: #475569;
        }

        .total-amount {
            margin-top: 5px;
            color: #1d4ed8;
            font-size: 27px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
        }

        .paid {
            background: #dcfce7;
            color: #15803d;
        }

        .unpaid {
            background: #fef3c7;
            color: #92400e;
        }

        .cancelled {
            background: #fee2e2;
            color: #b91c1c;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }

        .print-actions {
            max-width: 850px;
            margin: 0 auto 20px;
            text-align: right;
        }

        .print-button {
            padding: 11px 20px;
            border: none;
            border-radius: 7px;
            background: #2563eb;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        @media print {
            body {
                padding: 0;
                background: white;
            }

            .invoice {
                max-width: none;
                padding: 20px;
                border: none;
            }

            .print-actions {
                display: none;
            }

            @page {
                size: A4;
                margin: 15mm;
            }
        }

        @media screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .invoice {
                padding: 20px;
            }

            .header {
                flex-direction: column;
            }

            .invoice-title {
                text-align: left;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="print-actions">
        <button onclick="window.print()" class="print-button">
            Cetak / Simpan PDF
        </button>
    </div>

    <div class="invoice">

        {{-- HEADER KLINIK --}}
        <div class="header">
            <div>
                <h1 class="clinic-name">
                    DentalCare
                </h1>

                <p class="muted">
                    Klinik Gigi
                </p>

                <p class="muted">
                    Invoice resmi pembayaran layanan kesehatan gigi.
                </p>
            </div>

            <div>
                <h2 class="invoice-title">
                    INVOICE
                </h2>

                <p class="text-right">
                    <strong>
                        #INV-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}
                    </strong>
                </p>

                <p class="text-right muted">
                    {{ $billing->created_at?->format('d F Y') ?? '-' }}
                </p>
            </div>
        </div>

        {{-- INFORMASI PASIEN --}}
        <div class="section">
            <h3 class="section-title">
                Informasi Pasien
            </h3>

            <div class="info-grid">
                <div>
                    <div class="info-item">
                        <div class="info-label">
                            Nama Pasien
                        </div>

                        <div class="info-value">
                            {{ $billing->patient?->user?->name ?? '-' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            Email
                        </div>

                        <div class="info-value">
                            {{ $billing->patient?->user?->email ?? '-' }}
                        </div>
                    </div>
                </div>

                <div>
                    <div class="info-item">
                        <div class="info-label">
                            Nomor Rekam Medis
                        </div>

                        <div class="info-value">
                            #{{ $billing->dental_record_id ?? '-' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            Dokter Pemeriksa
                        </div>

                        <div class="info-value">
                            {{ $billing->dentalRecord?->doctor?->user?->name ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RINCIAN TINDAKAN --}}
        <div class="section">
            <h3 class="section-title">
                Rincian Tindakan Layanan
            </h3>

            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Tindakan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($billing->items as $index => $item)
                        <tr>
                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ $item->treatment?->name ?? '-' }}
                            </td>

                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>

                            <td class="text-right">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>

                            <td class="text-right">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Belum ada rincian tindakan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TOTAL DAN STATUS --}}
        <div class="total-box">
            <div class="total-label">
                Total Pembayaran
            </div>

            <div class="total-amount">
                Rp {{ number_format($billing->total_amount, 0, ',', '.') }}
            </div>

            <div style="margin-top: 12px;">
                Status Pembayaran:

                @if ($billing->status === 'paid')
                    <span class="status paid">
                        LUNAS
                    </span>

                @elseif ($billing->status === 'unpaid')
                    <span class="status unpaid">
                        BELUM LUNAS
                    </span>

                @else
                    <span class="status cancelled">
                        DIBATALKAN
                    </span>
                @endif
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <p>
                <strong>DentalCare - Klinik Gigi</strong>
            </p>

            <p>
                Terima kasih telah mempercayakan perawatan gigi Anda kepada kami.
            </p>

            <p>
                Invoice ini diterbitkan secara elektronik oleh sistem DentalCare.
            </p>
        </div>

    </div>

</body>

</html>
