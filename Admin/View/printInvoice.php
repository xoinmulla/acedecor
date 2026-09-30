<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', 0);

require_once "../vendor/autoload.php";
require_once "../DB Operations/invoiceOps.php";

$invoiceId = intval($_GET['id'] ?? 0);

if ($invoiceId <= 0) {
    die("Invalid invoice id.");
}

$invoice = DBInvoice::getById($invoiceId);

if (!$invoice) {
    die("Invoice not found.");
}

function invoiceMoney($value)
{
    return number_format((float) $value, 2);
}

function numberToIndianWords($number)
{
    $number = round((float) $number, 2);
    $rupees = (int) $number;
    $paise = (int) round(($number - $rupees) * 100);

    $ones = [
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen'
    ];

    $tens = [
        2 => 'Twenty',
        3 => 'Thirty',
        4 => 'Forty',
        5 => 'Fifty',
        6 => 'Sixty',
        7 => 'Seventy',
        8 => 'Eighty',
        9 => 'Ninety'
    ];

    $convertBelow100 = function ($n) use ($ones, $tens) {
        if ($n < 20) {
            return $ones[$n];
        }

        $text = $tens[(int) floor($n / 10)];
        $remainder = $n % 10;

        if ($remainder > 0) {
            $text .= ' ' . $ones[$remainder];
        }

        return $text;
    };

    $convertBelow1000 = function ($n) use ($ones, $convertBelow100) {
        if ($n < 100) {
            return $convertBelow100($n);
        }

        $text = $ones[(int) floor($n / 100)] . ' Hundred';
        $remainder = $n % 100;

        if ($remainder > 0) {
            $text .= ' ' . $convertBelow100($remainder);
        }

        return $text;
    };

    $convertIndian = function ($n) use ($convertBelow1000, $convertBelow100) {
        if ($n === 0) {
            return 'Zero';
        }

        $parts = [];

        $crore = intdiv($n, 10000000);
        $n %= 10000000;

        $lakh = intdiv($n, 100000);
        $n %= 100000;

        $thousand = intdiv($n, 1000);
        $n %= 1000;

        if ($crore > 0) {
            $parts[] = $convertBelow1000($crore) . ' Crore';
        }

        if ($lakh > 0) {
            $parts[] = $convertBelow1000($lakh) . ' Lakh';
        }

        if ($thousand > 0) {
            $parts[] = $convertBelow1000($thousand) . ' Thousand';
        }

        if ($n > 0) {
            $parts[] = $convertBelow1000($n);
        }

        return implode(' ', $parts);
    };

    $words = $convertIndian($rupees);

    if ($paise > 0) {
        $words .= ' And ' . $convertBelow1000($paise) . ' Paise';
    }

    return $words . ' Only.';
}

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'orientation' => 'P',
    'margin_top' => 8,
    'margin_bottom' => 8,
    'margin_left' => 8,
    'margin_right' => 8
]);

$itemCount = count($invoice['items']);
$itemsHtml = '';

$itemCount = count($invoice['items']);

$gstRate = (float) ($invoice['gst'] ?? 0);
$igstRate = (float) ($invoice['igst'] ?? 0);

$activeTaxRate = 0;
$useGST = false;
$useIGST = false;

// GST and IGST are mutually exclusive
if (!empty($invoice['gst']) || $invoice['gst'] === '0') {
    $activeTaxRate = $gstRate;
    $useGST = true;
} elseif (!empty($invoice['igst']) || $invoice['igst'] === '0') {
    $activeTaxRate = $igstRate;
    $useIGST = true;
}

$itemsHtml = '';

foreach ($invoice['items'] as $index => $item) {

    $baseAmount = (float) $item['amount'];

    $itemTax = $baseAmount * ($activeTaxRate / 100);

    $itemFinalAmount = round(
        $baseAmount + $itemTax,
        2
    );

    $itemsHtml .= '
        <tr>
            <td class="center" style="font-size: 11px;">' . ($index + 1) . '</td>
            <td style="font-size: 11px;">' . htmlspecialchars($item['description']) . '</td>
            <td class="center" style="font-size: 11px;">' . htmlspecialchars($item['qty']) . '</td>
            <td class="center" style="font-size: 11px;">' . htmlspecialchars($item['hsn']) . '</td>
            <td class="right" style="font-size: 11px;">₹ ' . invoiceMoney($item['unit_price']) . '</td>
            <td class="right" style="font-size: 11px;">₹ ' . invoiceMoney($itemFinalAmount) . '</td>
        </tr>';
}

if ($itemsHtml === '') {
    $itemsHtml = '<tr><td colspan="6" class="center">No items</td></tr>';
}

// ---------------------------------------------------------------------
// Fill-the-page math.
//
// mPDF has no flexbox / "stretch to fill remaining space" — every block
// has to be given an explicit height, or the page just ends wherever the
// content ends (that's the gap at the bottom we're fixing). So instead of
// a fixed row height, we work out how much vertical space is LEFT after
// every other section on the page, then divide that among the item rows.
// There are no blank filler rows anymore — only the invoice's actual
// items are rendered, and those rows stretch to use the same space.
//
// A4 = 297mm tall, minus the 8mm top/bottom margins set on Mpdf = 281mm
// of usable content height.
//
// FIXED_CHROME_MM below is the combined height of everything that is NOT
// the item table (masthead, buyer/dispatch panel, item table header row,
// totals block, declaration/bank/signature footer) at the font sizes and
// paddings used in the HTML further down. It was measured against this
// exact template — if you change paddings/font-sizes in the <style>
// block, or the buyer address regularly runs to many lines, nudge this
// constant to match; a couple of mm off just means a hairline gap or a
// slightly taller footer, not a broken layout.
$pageContentHeightMm = 281;
$fixedChromeMm = 121;

$availableForItemsMm = $pageContentHeightMm - $fixedChromeMm;
$numRows = max($itemCount, 1); // at least 1 row so "No items" state still renders sensibly

// mm per row, filled edge-to-edge — this is what actually removes the
// bottom gap regardless of how few items the invoice has.
$itemRowHeight = $availableForItemsMm / $numRows;

// Ceiling so a single-item invoice doesn't stretch into one absurdly
// tall row — past this point extra space is better left as a touch of
// margin than an oversized row. Floor so rows never get so short the
// text can't sit inside them; enough items to hit that floor means the
// invoice spills onto a second page rather than becoming unreadable.
$itemRowHeight = max(6, min(13, $itemRowHeight));

// Font size tracks the row height so text stays visually centered and
// proportional whether rows are tall (few items) or tight (many items).
$itemFontSize = min(10.5, max(6.5, $itemRowHeight * 0.62));

$subTotal = 0;

foreach ($invoice['items'] as $item) {
    $subTotal += (float) $item['amount'];
}

$subTotal = round($subTotal, 2);

$sgstRate = 0;
$cgstRate = 0;

$sgstAmount = 0;
$cgstAmount = 0;
$igstAmount = 0;

if ($useGST) {
    $sgstRate = $gstRate / 2;
    $cgstRate = $gstRate / 2;

    $sgstAmount = round($subTotal * ($sgstRate / 100), 2);
    $cgstAmount = round($subTotal * ($cgstRate / 100), 2);

} elseif ($useIGST) {

    $igstAmount = round($subTotal * ($igstRate / 100), 2);
}

$total = round(
    $subTotal +
    $sgstAmount +
    $cgstAmount +
    $igstAmount,
    2
);

$html = '
<style>
body {
    font-family: dejavusans, sans-serif;
    font-size: 9.5px;
    color: #1c2126;
}

.page {
    border: 1px rgb(43, 89, 136);
}

table {
    width: 100%;
    border-collapse: collapse;
}

td, th {
    padding: 4px 6px;
}

.center { text-align: center; }
.right { text-align: right; }
.bold { font-weight: bold; }

/* ---------- Header (dark masthead) ---------- */
.header-table {
    background: rgb(43, 89, 136);
    width: 100%;
    height: 200px;
}

.brand-block {
    padding: 20px 20px 16px 20px;
    font-size: 20px;
}

.company-name {
    font-size: 35px;
    font-weight: bold;
    color: #ffffff;
    letter-spacing: 0.4px;
    padding: 20px 20px 16px 20px;
}

.company-meta {
    font-size: 15.5px;
    color: #b9c4d0;
    line-height: 1.55;
    margin-top: 4px;
}

.invoice-tag {
    padding: 20px 20px 16px 20px;
    text-align: right;
    font-size: 14px;
    color: #ffffff;
}

.invoice-tag .tag {
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
    color: rgb(43, 89, 136);
    background: #ffffff;
    padding: 5px 14px;
    letter-spacing: 1.5px;
}

.invoice-tag .num {
    margin-top: 7px;
    font-size: 9.5px;
    color: #dfe6ee;
}

.invoice-tag .num b {
    color: #ffffff;
}

.accent-bar {
    background: #c8a24a;
    height: 2.5px;
    line-height: 2.5px;
    font-size: 1px;
}

/* ---------- Info strip: buyer / meta ---------- */
.info-table {
    border-collapse: collapse;
}

.info-table td {
    border: 1px solid #dfe2e6;
    vertical-align: top;
}

.info-label {
    font-size: 12px;
    letter-spacing: 0.5px;
    color:rgb(0, 0, 0);
    font-weight: bold;
    margin-bottom: 3px;
}

.info-value {
    font-size: 14px;
    color: rgb(43, 89, 136);
    line-height: 1.5;
}

.info-value b {
    color: rgb(43, 89, 136);
}

.buyer-box {
    padding: 10px 14px;
}

.meta-box {
    padding: 10px 14px;
}

.meta-row {
    margin-bottom: 6px;
}

.meta-row:last-child {
    margin-bottom: 0;
}

/* ---------- Items table ---------- */
.item-table {
    border-collapse: collapse;
}

.item-table th {
    text-align: center;
    background: rgb(43, 89, 136);
    color: #ffffff;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    padding: 5px 6px;
    border: 1px solid rgb(43, 89, 136);
}

.item-table td {
    font-size: 11px;
    border-left: 1px solid #dde1e6;
    border-right: 1px solid #dde1e6;
    border-bottom: 1px solid #dde1e6;
}

.item-table tr:nth-child(even) td {
    background: #f7f8fa;
}

.item-table td, .item-table th {
    font-size: ' . $itemFontSize . 'px;
}

.item-table td {
    height: ' . $itemRowHeight . 'mm;
    vertical-align: middle;
}

/* ---------- Totals ---------- */
.totals-table {
    border-collapse: collapse;
}

.words-cell {
    padding: 12px 14px;
    vertical-align: middle;
    border: 1px solid #dde1e6;
    border-right: none;
}

.words-label {
    font-size: 10.5px;
    letter-spacing: 0.5px;
    color: #6b7280;
    font-weight: bold;
}

.words-value {
    font-size: 10.5px;
    color: rgb(43, 89, 136);
    font-weight: bold;
    margin-top: 5px;
    line-height: 1.5;
}

.charges-table {
    border: 1px solid #dde1e6;
    border-bottom: none;
}

.charges-table td {
    padding: 6.5px 12px;
    font-size: 9px;
    border-bottom: 1px solid #eceef0;
}

.charges-table .charge-label {
    font-size: 11px;
    color: #55606b;
}

.charges-table .charge-value {
    font-size: 11px;
    text-align: right;
    color: #1c2126;
}

.grand-total-row td {
    background: rgb(43, 89, 136);
    border-bottom: none;
    padding: 9px 12px;
    font-size: 12px;
    font-weight: bold;
    color: #ffffff;
}

.grand-total-row .charge-value {
    color: #ffffff;
}

/* ---------- Footer ---------- */
.footer-table {
    border-collapse: collapse;
}

.footer-table td {
    border: 1px solid #dde1e6;
    vertical-align: top;
    padding: 10px 14px;
}

.footer-title {
    font-size: 17px;
    letter-spacing: 0.5px;
    color: rgb(43, 89, 136);
    font-weight: bold;
    margin-bottom: 5px;
}

.footer-text {
    font-size: 15px;
    color: rgb(43, 89, 136);
    line-height: 1.6;
}

.sign-row td {
    border-top: none;
    height: 65px;
    vertical-align: bottom;
    font-size: 8.5px;
    color: rgb(43, 89, 136);
}
</style>

<div class="page">

<table class="header-table">
    <tr>
        <td width="80%" class="brand-block">
            <div class="company-name" > Ace Decors</div>
            <div class="company-meta text-white">
                Opp Doddaw Oil Mill, Lakhmannhalli PB Road, Dharwad&nbsp;-&nbsp;580004<br>
                Mobile: 9742367112 &nbsp;|&nbsp; GSTIN: 29ABGFA0355B1ZM<br>
                E-Mail: acedecorsofficial@gmail.com
            </div>
        </td>
        <td width="42%" class="invoice-tag">
            <span class="tag text-white">TAX INVOICE</span>
            <div class="num text-white">
                Invoice No: <b>' . htmlspecialchars($invoice['invoice_number']) . '</b><br>
                Dated: <b>' . date('d-M-Y', strtotime($invoice['invoice_date'])) . '</b>
            </div>
        </td>
    </tr>
</table>

<div class="accent-bar">&nbsp;</div>

<table class="info-table">
    <tr>
        <td width="78%" class="buyer-box">
            <div class="info-label">Buyer</div>
            <div class="info-value">
                <b>' . nl2br(htmlspecialchars($invoice['client_name'])) . '</b><br>
                ' . nl2br(htmlspecialchars($invoice['address'])) . '<br>
                ' . htmlspecialchars($invoice['location']) . '<br>
                ' . htmlspecialchars($invoice['contact']) . '
            </div>
        </td>
        <td width="42%" class="meta-box">
            <div class="meta-row">
                <div class="info-label">Dispatched Through: <span style="color: rgb(43, 89, 136);">' . htmlspecialchars($invoice['dispatch_through']) . '</span></div>
            </div><br>
            <div class="meta-row">
                <div class="info-label">Destination: <span style="color: rgb(43, 89, 136);">' . htmlspecialchars($invoice['destination']) . '</span></div>
            </div><br>
            <div class="meta-row">
    <div class="info-label">
        Vehicle No:
        <span style="color: rgb(43, 89, 136);">
            ' . htmlspecialchars($invoice['vehicle_no'] ?? '') . '
        </span>
    </div>
</div>
        </td>
    </tr>
</table>

<table class="item-table">
    <thead >
        <tr>
            <th width="6%" style="font-size: 11px;">#</th>
            <th width="39%" style="font-size: 11px;">Description of Goods</th>
            <th width="8%" style="font-size: 11px;">Qty</th>
            <th width="12%" style="font-size: 11px;">HSN</th>
            <th width="17%" style="font-size: 11px;">Unit Price</th>
            <th width="18%" style="font-size: 11px;">Amount</th>
        </tr>
    </thead>
    <tbody style="font-size: 11px;">
        ' . $itemsHtml . '
    </tbody>
</table>

<table class="totals-table">
    <tr>
        <td width="74%" class="words-cell">
            <div class="words-label">Amount Chargeable (in words)</div>
            <div class="words-value">' . htmlspecialchars(numberToIndianWords($total)) . '</div>
        </td>
        <td width="40%" style="padding:0; vertical-align:top;">
            <table class="charges-table">
                <tr>
                    <td class="charge-label">Sub Total</td>
                    <td class="charge-value">₹ ' . invoiceMoney($subTotal) . '</td>
                </tr>
                <tr>
                    <td class="charge-label">SGST ' . number_format($sgstRate, 2) . '%</td>
                    <td class="charge-value">₹ ' . invoiceMoney($sgstAmount) . '</td>
                </tr>

                <tr>
                    <td class="charge-label">CGST ' . number_format($cgstRate, 2) . '%</td>
                    <td class="charge-value">₹ ' . invoiceMoney($cgstAmount) . '</td>
                </tr>

                <tr>
                    <td class="charge-label">IGST ' . number_format($igstRate, 2) . '%</td>
                    <td class="charge-value">₹ ' . invoiceMoney($igstAmount) . '</td>
                </tr>
                <tr class="grand-total-row">
                    <td>Total</td>
                    <td class="charge-value">₹ ' . invoiceMoney($total) . '</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="footer-table">
    <tr>
        <td width="93%">
            <div class="footer-title">Declaration:</div>
            <div class="footer-text">
                1) We declare that this invoice shows the actual price of the goods described
                and that all particulars are true and correct.<br><br>
                2) All disputes are subject to Dharwad Jurisdiction only.
            </div>
        </td>
        <td width="50%">
            <div class="footer-title">Company Bank Details:</div>
            <div class="footer-text">
                Name: Ace Decors<br>
                Bank Name: Bank Of Baroda<br>
                A/c No: 64220200001316<br>
                IFSC: BARB0VJLAKAM
            </div>
        </td>
    </tr>
    <tr class="sign-row">
        <td style="font-size: 15px;">Customer&rsquo;s Seal and Signature</td>
        <td class="right" style="font-size: 15px;">Signature &amp; Date</td>
    </tr>
</table>

</div>';

$mpdf->WriteHTML($html);

$fileName = 'Invoice_' . preg_replace(
    '/[^A-Za-z0-9_-]/',
    '_',
    $invoice['invoice_number']
) . '.pdf';

$pdfDirectory = __DIR__ . '/../pdfs/invoice/';

if (!is_dir($pdfDirectory)) {
    mkdir($pdfDirectory, 0777, true);
}

$pdfPath = $pdfDirectory . $fileName;

// Generate and save PDF
$mpdf->Output(
    $pdfPath,
    \Mpdf\Output\Destination::FILE
);

// Open generated PDF in browser
if (file_exists($pdfPath)) {
    header("Location: ../pdfs/invoice/" . rawurlencode($fileName));
    exit;
}

die("Unable to create invoice PDF.");