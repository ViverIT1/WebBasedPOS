<?php
require('fpdf/fpdf.php'); // Include the FPDF library

// Get the JSON data sent from the client
$jsonData = file_get_contents('php://input');
$receiptData = json_decode($jsonData, true);

// Create a new PDF document using FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', '', 12);

// Define the maximum line width for your content (e.g., 80mm for a standard receipt)
$maxLineWidth = 80;

// Calculate the number of lines in the content
$numLines = count($receiptData) + 6; // 6 lines for headers and totals

// Calculate the content height based on the number of lines
$contentHeight = $numLines * 10; // Assuming each line is 10 units in height

// Calculate the width and height of the content
$contentWidth = $maxLineWidth;
$contentHeight = $numLines * 10;

// Set the page size to match the content size
$pdf->AddPage('P', array($contentWidth, $contentHeight));

// Add receipt content
$content = '
Receipt
----------------------------------------------
Qty | Product | SRP | Total
';

foreach ($receiptData as $item) {
    $content .= $item['quantity'] . ' | ' . $item['productName'] . ' | ' . number_format($item['srp'], 2) . ' | ' . number_format($item['total'], 2) . "\n";
}

$content .= '
----------------------------------------------
Subtotal: ' . number_format($subTotal, 2) . '
Discount: ' . number_format($discount, 2) . '
Tax: ' . number_format($tax, 2) . '
Grand Total: ' . number_format($grandTotal, 2);

$pdf->MultiCell(0, 10, $content);

// Set headers to indicate that a PDF file is being sent
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="receipt.pdf"');

// Output the PDF directly to the client
$pdf->Output();
?>
