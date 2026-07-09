<?php 
use App\Models\Commanmodel;
$commanmodel = new Commanmodel();
$addressView = $commanmodel->get_single_query('address', ['id' => 1]); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice PDF</title>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
body { font-family:Poppins, sans-serif; margin:0; padding:0; }
.invoice-wrapper { width: 210mm; margin:auto; padding:10mm 15mm; background:#fff; }
.header, .footer, .notes { page-break-inside: avoid; }
.header img { max-width:150px; }
.header .text { float:right; text-align:right; }
.header .text h2 { color:#f44018; margin:0 0 5px 0; }
.header .text p { font-size:13px; margin:2px 0; }
.bill-to { border:1px solid #ddd; padding:10px; margin-bottom:15px; border-radius:6px; page-break-inside:avoid; }
.bill-to h3 { color:#f44018; font-size:16px; margin:0 0 5px 0; }
.bill-to p { font-size:13px; margin:2px 0; }
table { width:100%; border-collapse:collapse; page-break-inside:auto; }
th, td { border:1px solid #ddd; padding:8px; font-size:13px; text-align:left; page-break-inside:avoid; }
th { background:#f44018; color:#fff; }
td:last-child, th:last-child { text-align:right; }
tr:nth-child(even) td { background:#fff8f6; }
.notes p { font-size:13px; }
.footer { text-align:center; font-size:12px; color:#777; border-top:1px solid #ddd; padding-top:5px; page-break-inside:avoid; }
.no-print { text-align:center; margin:15px; }
.no-print button { background:#f44018; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; font-family:Poppins; }
.invoice-wrapper {
    width: 100%;      /* Full width for PDF */
    max-width: 210mm; /* Optional max width */
    margin: auto;
    padding: 10px;    /* Small padding instead of 20mm */
    background: #fff;
}



</style>
</head>
<body>

<div class="invoice-wrapper" id="invoice">

  <div class="header">
      <img src="<?= base_url('assets/img/'.$addressView->header_logo) ?>" alt="Logo">
      <div class="text">
          <h2>Invoice</h2>
          <p>Invoice No: <?= $item->booking_product_order_id ?></p>
          <p>Date: <?= $order->order_book_date ?></p>
      </div>
      <div style="clear:both;"></div>
  </div>

  <div class="bill-to">
      <h3>Bill To</h3>
      <p><?= $order->order_book_user_name ?></p>
      <p><?= $order->order_shipping_user_name ?>, <?= $order->order_shipping_address ?>, <?= $order->order_shipping_city ?>, <?= $order->order_shipping_state ?>, <?= $order->order_shipping_pin_no ?></p>
      <p><?= $order->order_book_phone ?></p>
      <p><?= $order->order_book_email ?></p>
  </div>

  <table>
      <thead>
          <tr>
              <th>Order ID</th>
              <th>Photo</th>
              <th>Product name</th>
              <th>Unit</th>
              <th>Price</th>
              <th>Sub total</th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <td><?= $item->booking_product_order_id ?></td>
              <td><img src="<?= $item->booking_product_image ?>" style="width:50px;"></td>
              <td><?= $item->booking_product_product_name ?></td>
              <td><?= $item->booking_product_quantity ?></td>
              <td><?= $item->booking_product_price ?></td>
              <td><?= $item->booking_product_sub_total ?></td>
          </tr>
          <tr>
              <td colspan="4"></td>
              <td>Total:</td>
              <td><?= $item->booking_product_sub_total ?></td>
          </tr>
          <tr>
              <td colspan="4"></td>
              <td>Gst (<?= $item->booking_product_tax ?>):</td>
              <td><?= $item->booking_product_tax_rate ?></td>
          </tr>
          <tr>
              <td colspan="4"></td>
              <td>Discount:</td>
              <td><?= $item->discount_per_product ?></td>
          </tr>
          <tr>
              <td colspan="4"></td>
              <td>Shipping:</td>
              <td><?= $item->booking_product_shipping ?></td>
          </tr>
          <tr>
              <td colspan="4"></td>
              <td>Grand Total:</td>
              <td><?= ($item->booking_product_sub_total + $item->booking_product_tax_rate + $item->booking_product_shipping) - $item->discount_per_product ?></td>
          </tr>
      </tbody>
  </table>

  <div class="notes">
      <h3>Notes</h3>
      <p>Thank you for your purchase! Please retain this invoice for your records.</p>
  </div>

  <div class="footer">
      © 2025 Heywansaa | support@yourcompany.com | +1 234 567 890
  </div>
</div>

<div class="no-print">
    <button id="downloadPdfBtn">🖨 Download PDF</button>
</div>

<script>


document.getElementById('downloadPdfBtn').addEventListener('click', () => {
    const element = document.getElementById('invoice');
 const opt = {
    margin: 0.1,                // small margin
    filename: 'Invoice.pdf',
    image: { type: 'jpeg', quality: 1 },
    html2canvas: { scale: 2, useCORS: true, width: document.getElementById('invoice').scrollWidth },
    jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' },
    pagebreak: { mode: ['css','legacy'] }
};
    html2pdf().set(opt).from(element).save();
});
</script>

</body>
</html>
