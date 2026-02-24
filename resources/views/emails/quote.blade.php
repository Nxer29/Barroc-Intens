@php
    $subtotal = $quote->items->sum('line_total');
    $btw = round($subtotal * 0.21, 2);
    $totaal = round($subtotal + $btw, 2);
@endphp

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Offerte {{ $quote->quote_number }}</title>
</head>
<body style="margin:0; padding:0; font-family:Arial, sans-serif; background:#f5f5f5;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5; padding:24px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.08);">
                <tr>
                    <td style="background:#111827; color:#ffffff; padding:20px 24px; font-size:18px;">
                        Barroc Intens – Offerte
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px; color:#111827; font-size:14px; line-height:1.6;">
                        <p style="margin:0 0 12px;">Beste {{ $quote->customer->contact_name ?? 'klant' }},</p>
                        <p style="margin:0 0 12px;">
                            Hartelijk dank voor uw interesse. In de bijlage vindt u uw offerte
                            <strong>{{ $quote->quote_number }}</strong>.
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" style="margin:16px 0; border:1px solid #e5e7eb; border-radius:6px;">
                            <tr>
                                <td style="padding:10px 12px; background:#f9fafb;">Subtotaal</td>
                                <td style="padding:10px 12px; text-align:right;">€ {{ number_format($subtotal,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 12px; background:#f9fafb;">BTW (21%)</td>
                                <td style="padding:10px 12px; text-align:right;">€ {{ number_format($btw,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td style="padding:12px; font-weight:bold;">Totaal</td>
                                <td style="padding:12px; text-align:right; font-weight:bold;">€ {{ number_format($totaal,2,',','.') }}</td>
                            </tr>
                        </table>

                        <p style="margin:0 0 12px;">
                            Heeft u vragen of wilt u de offerte bevestigen? Laat het ons gerust weten.
                        </p>

                        <p style="margin:0;">Met vriendelijke groet,<br>Barroc Intens</p>
                    </td>
                </tr>
                <tr>
                    <td style="background:#f3f4f6; color:#6b7280; padding:12px 24px; font-size:12px;">
                        Dit is een automatisch bericht.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>