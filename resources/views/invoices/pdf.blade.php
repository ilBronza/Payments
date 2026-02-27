<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page { margin: 28px 35px; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10.5px;
    color: #000;
    line-height: 1.25;
}

.small { 
    font-size: 8.5px; 
}

.bold { 
    font-weight: 600; 
}

.text-right { text-align: right; }
.text-center { text-align: center; }

.section { 
    margin-top: 12px; 
}

/* Header: Cedente (sinistra) + Dati documento (destra) */
.header-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 8px;
}

.header-table td {
    vertical-align: top;
    padding: 0 8px 0 0;
}

.header-left {
    width: 50%;
}

.header-right {
    width: 50%;
}

.header-section-title {
    font-weight: 600;
    margin-bottom: 4px;
}

.header-meta {
    font-size: 10px;
}

/* General tables */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    font-size: 9.5px;
    border-bottom: 1px solid #000;
    padding: 3px 2px;
    font-weight: 600;
}

td {
    padding: 2px 2px;
    vertical-align: top;
}

table.section td {
    vertical-align: top;
}

/* Articles table */
table thead tr {
    border-bottom: 1px solid #000;
}

table tbody tr {
    border-bottom: 0.3px solid #bbb;
}

table tbody tr:last-child {
    border-bottom: none;
}

/* VAT summary and totals */
.line-top {
    border-top: 1px solid #000;
    padding-top: 6px;
    margin-top: 12px;
}

.section.line-top table {
    width: 55%;
    margin-left: auto;
}

.section.line-top table td {
    padding: 3px 2px;
}

.section:last-of-type {
    margin-top: 18px;
}

/* Payment table */
.payment-table th,
.payment-table td {
    padding: 3px 4px;
}
</style>
</head>
<body>

<div class="small text-center">
Documento non valido ai fini fiscali ai sensi art.21 DPR 633/72. Originale disponibile all'indirizzo PEC o codice SDI fornito, o nell'area riservata dell'Agenzia delle Entrate
<br>
Versione FPR12 - Versione prodotta con foglio di stile Passepartout s.p.a. www.passepartout.net
</div>

<table class="header-table">
<tr>
<td class="header-left">
    <div class="bold" style="font-size:12px;">
        {{ $invoice->getCompanyName() }}
    </div>
    {{ $invoice->getCompanyAddress() }}<br>
    Identificativo fiscale ai fini IVA: {{ $invoice->getCompanyVat() }}<br>
    Codice fiscale: {{ $invoice->getCompanyFiscalCode() }}<br>
    Regime fiscale: {{ $invoice->getFiscalRegime() }}
    @if($invoice->getFiscalOperationDescription())
    <br>
    {{ $invoice->getFiscalOperationDescription() }}
    @endif
    @if($invoice->getRecipientAdministrativeCode())
    <br>
    Codice Amministrazione destinataria: {{ $invoice->getRecipientAdministrativeCode() }}
    @endif
</td>
<td class="header-right">
    <div class="header-section-title">Dati documento</div>
    <div class="header-meta">
        Tipologia documento: {{ $invoice->getDocumentType() }}<br>
        n. {{ $invoice->getNumber() }} del {{ $invoice->getDateFormatted() }}<br>
        Valuta importi: {{ $invoice->getCurrency() }}<br>
        Causale: {{ $invoice->getReason() }}<br>
        Bollo virtuale: {{ $invoice->getStampDutyLabel() }}<br>
        Importo bollo: {{ $invoice->getStampDutyFormatted() }}
    </div>
    @if($invoice->getHasSocialSecurity())
    <div class="header-meta" style="margin-top:6px;">
        <div class="bold">Cassa previdenziale</div>
        Tipologia cassa previdenziale: {{ $invoice->getSocialSecurityType() }}<br>
        Aliquota contributo cassa (%): {{ $invoice->getSocialSecurityRateFormatted() }}<br>
        Importo contributo cassa: {{ $invoice->getSocialSecurityAmountFormatted() }}<br>
        Aliquota IVA applicata: {{ $invoice->getSocialSecurityVatRateFormatted() }}<br>
        Tipologia di non imponibilità del contributo: {{ $invoice->getSocialSecurityExemptionCode() }}
    </div>
    @endif
</td>
</tr>
</table>

<div class="section">
<div class="bold">Destinatario</div>
{{ $invoice->getCustomerName() }}<br>
{{ $invoice->getCustomerAddress() }}<br>
Identificativo fiscale ai fini IVA: {{ $invoice->getCustomerVat() }}<br>
Codice Fiscale: {{ $invoice->getCustomerFiscalCode() }}
</div>

<div class="section">
<table>
<thead>
<tr>
<th style="width:4%">#</th>
<th style="width:38%">ARTICOLO</th>
<th style="width:10%">U.M.</th>
<th style="width:10%">QUANTITA'</th>
<th style="width:12%" class="text-right">PREZZO UNITARIO</th>
<th style="width:8%" class="text-right">SCONTO/<br>MAGG.</th>
<th style="width:12%" class="text-right">IMPORTO</th>
<th style="width:6%" class="text-center">%IVA</th>
</tr>
</thead>
<tbody>
@foreach($invoice->getDetails() as $detail)
@php
    $amount = isset($detail[2]) && isset($detail[3]) ? round($detail[2] * $detail[3], 2) : 0;
    $amountFormatted = number_format($amount, 2, ',', '.');
@endphp
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $detail[0] ?? '' }}</td>
<td>{{ $detail[1] ?? '' }}</td>
<td class="text-right">{{ isset($detail[2]) ? number_format($detail[2], 2, ',', '.') : '' }}</td>
<td class="text-right">{{ isset($detail[3]) ? number_format($detail[3], 2, ',', '.') : '' }}</td>
<td class="text-right"></td>
<td class="text-right">{{ $amountFormatted }}</td>
<td class="text-center">{{ $detail[4] ?? '' }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<div class="section line-top">
<table>
<tr class="bold">
<td style="width:30%">Esigibilità IVA</td>
<td style="width:15%">%IVA</td>
<td style="width:25%">Imposta</td>
<td style="width:30%">Imponibile</td>
</tr>
<tr>
<td>{{ $invoice->getVatExigibilityCode() }}</td>
<td>{{ $invoice->getVatRateFormatted() }}</td>
<td>{{ $invoice->getVatTotalFormatted() }}</td>
<td>{{ $invoice->getTaxableTotalFormatted() }}</td>
</tr>
</table>
</div>

<div class="section line-top">
<table class="payment-table">
<tr class="bold">
<td style="width:30%">Pagamento</td>
<td style="width:35%">Scadenza</td>
<td style="width:35%" class="text-right">Importo</td>
</tr>
<tr>
<td>{{ $invoice->getPaymentMethod() }}</td>
<td>{{ $invoice->getPaymentDueDateFormatted() ?? '' }}</td>
<td class="text-right">{{ $invoice->getGrandTotalFormatted() }}</td>
</tr>
</table>
</div>

<div class="section line-top">
<table>
<tr>
<td class="bold">Totale Imponibile</td>
<td class="text-right">{{ $invoice->getTaxableTotalFormatted() }}</td>
</tr>
<tr>
<td class="bold">Totale Iva</td>
<td class="text-right">{{ $invoice->getVatTotalFormatted() }}</td>
</tr>
<tr>
<td class="bold">Totale documento</td>
<td class="text-right">{{ $invoice->getGrandTotalFormatted() }}</td>
</tr>
<tr>
<td class="bold">Totale da pagare</td>
<td class="text-right">{{ $invoice->getGrandTotalFormatted() }}</td>
</tr>
</table>
</div>

<div class="section">
Istituto Finanziario: {{ $invoice->getBankName() }}<br>
IBAN: {{ $invoice->getIban() }}
</div>

</body>
</html>
