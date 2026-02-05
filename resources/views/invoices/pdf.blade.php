@php
    $subtotal = $invoice->lines->sum('line_total');
    $btw = round($subtotal * 0.21, 2);
    $totaal = round($subtotal + $btw, 2);
@endphp

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Factuur {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .top { display: flex; justify-content: space-between; align-items: flex-start; }
        .title { font-size: 28px; font-weight: bold; letter-spacing: 1px; }
        .logo { width: 140px; margin-left: 520px; display: block; }
        .row { margin-top: 16px; display: flex; justify-content: space-between; }
        .col-left { width: 55%; }
        .col-right { width: 40%; text-align: right; margin-left: auto; }
        .block { margin-top: 14px; }
        .line { height: 3px; background: #facc15; margin: 18px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        th { text-align: left; font-weight: bold; padding: 6px 0; border-bottom: 1px solid #ddd; }
        td { padding: 6px 0; border-bottom: 1px solid #eee; }
        .right { text-align: right; }
        .totals { margin-top: 14px; width: 100%; }
        .totals td { border: none; }
        .footer { margin-top: 30px; font-style: italic; }
        .muted { color: #666; }
    </style>
</head>
<body>
    <div class="top">
        <div class="title">FACTUUR</div>
        <img class="logo" src="{{ public_path('images/Logo6_klein.png') }}" alt="Barroc Intens">
    </div>

    <div class="row">
        <div class="col-left">
            <strong>{{ $invoice->customer->company_name ?? '-' }}</strong><br>
            {{ $invoice->customer->contact_name ?? '' }}<br>
            {{ $invoice->customer->contact_email ?? '' }}
        </div>
        <div class="col-right">
            <strong>Barroc Intens</strong><br>
            Terheijdenseweg 350<br>
            4826 AA Breda
        </div>
    </div>

    <div class="block">
        <strong>Datum:</strong> {{ $invoice->issue_date }}<br>
        <strong>Factuurnr.:</strong> {{ $invoice->invoice_number }}<br>
        <strong>Omschrijving:</strong> {{ $invoice->omschrijving }}
    </div>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th>Omschrijving</th>
                <th class="right">Aantal</th>
                <th class="right">Prijs p/st</th>
                <th class="right">Subtotaal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->lines as $line)
                <tr>
                    <td>{{ $line->description }}</td>
                    <td class="right">{{ $line->quantity }}</td>
                    <td class="right">€ {{ number_format($line->unit_price,2,',','.') }}</td>
                    <td class="right">€ {{ number_format($line->line_total,2,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="right muted">Subtotaal:</td>
            <td class="right">€ {{ number_format($subtotal,2,',','.') }}</td>
        </tr>
        <tr>
            <td class="right muted">BTW (21%):</td>
            <td class="right">€ {{ number_format($btw,2,',','.') }}</td>
        </tr>
        <tr>
            <td class="right"><strong>Totaal:</strong></td>
            <td class="right"><strong>€ {{ number_format($totaal,2,',','.') }}</strong></td>
        </tr>
    </table>

    <div class="footer">
        Te betalen binnen 14 dagen na dagtekening.
    </div>
</body>
</html>