<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sales and Inventory Management System</title>
  <link rel="stylesheet" type="text/css" href="nextsyle.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="next.js"></script>


</head>
<body><div></div>
  <div class="title-container">
    <h1 class="header">Sales and Inventory Management</h1>
</div>
<div class="side-bar">
  <div class="menu">
    <div class="item"><a href="cashiering.php" target="MainIframe"><i class="fas fa-desktop"></i>Cashiering </a>
    </div>

    <div class="item"><a class="sub-btn"><i class="fas fa-desktop"></i>Inventory Management
    <i class="fas fa-angle-right dropdown"></i>
    </a>
    <div class="sub-menu">
      <a href="itemanage.php" target="MainIframe" class="sub-module">Item Management</a>
      <a href="stockadj.php" target="MainIframe" class="sub-module">Stock Adjusment</a>
      <a href="discount.php" target="MainIframe" class="sub-module">Discount</a>
      <a href="packagelist.html" target="MainIframe" class="sub-module">Packages</a>
    </div>
    </div>

    <div class="item"><a class="sub-btn" href="usermanage.html" target="MainIframe"><i class="fas fa-desktop"></i>User Management</a>
    </div>

    <div class="item"><a class="sub-btn" href="customermanage.php" target="MainIframe"><i class="fas fa-desktop"></i>Customer Information Management</a>
    </div>

    <div class="item"><a class="sub-btn" class="sub-btn"><i class="fas fa-desktop"></i>Supplier
      <i class="fas fa-angle-right dropdown"></i>
    </a>
      <div class="sub-menu">
        <a href="supplierinfo.php" target="MainIframe" class="sub-module">Supplier Information Management</a>
        <a href="purchaseOrder.php" target="MainIframe" class="sub-module">Purchased Oder to Supplier</a>
        <a href="suppdel.html" target="MainIframe" class="sub-module">Supplier Delivery</a>
      </div>
    </div>

    <div class="item"><a class="sub-btn"><i class="fas fa-desktop"></i>Utility
      <i class="fas fa-angle-right dropdown"></i>
    </a>
      <div class="sub-menu">
        <a href="customereturn.html" target="MainIframe" class="sub-module">Customer Return</a>
        <a href="suppreturn.html" target="MainIframe" class="sub-module">Supplier Return</a>
        <a href="reposidatabase.html" target="MainIframe" class="sub-module">Database Backup and Restore</a>
        <a href="audit.html" target="MainIframe" class="sub-module">Audit Trail</a>
        <a href="itembarcode.html" target="MainIframe" class="sub-module">Item Barcode</a>
      </div>
    </div>

    <div class="item"><a class="sub-btn"><i class="fas fa-desktop"></i>Reporting and Analytics
      <i class="fas fa-angle-right dropdown"></i>
    </a>
      <div class="sub-menu">
        <a href="invreport.html" target="MainIframe" class="sub-module">Inventory Report</a>
        <a href="stockadjreport.html" target="MainIframe" class="sub-module">Stock Adjusment Report</a>
        <a href="salesreport.html" target="MainIframe" class="sub-module">Sales Report</a>
        <a href="cusreturnreport.html" target="MainIframe" class="sub-module">Customer Return Report</a>
        <a href="suppreturnreport.html" target="MainIframe" class="sub-module">Supplier Return Report</a>
        <a href="reodrlistreport.html" target="MainIframe" class="sub-module">Re Order List Report</a>
        <a href="suppdevreport.html" target="MainIframe" class="sub-module">Supplier Delivery Report</a>
        <a href="prdexpreport.html" target="MainIframe"  class="sub-module">Product Experiration Report</a>
        <a href="datanalreport.html" target="MainIframe"  class="sub-module">Data Analytics</a>
      </div>
    </div>

    <div class="item"><a class="sub-btn"><i class="fas fa-desktop"></i>Maintenance
      <i class="fas fa-angle-right dropdown"></i>
    </a>
      <div class="sub-menu">
        <a href="pricemaintenance.html" target="MainIframe" class="sub-module">Pricing Maintenance</a>
        <a href="recieptmaintenance.html" target="MainIframe"  class="sub-module">Receipt Maintenance</a>
        <a href="updtpolicy.html" target="MainIframe"  class="sub-module">Update Policy</a>
      </div>
    </div>

    <div class="item"><a class="sub-btn" href="policy.html" target="MainIframe" ><i class="fas fa-desktop"></i>Policy</a>
    </div>
    <div class="item">
    <a class="sub-btn" href="#" onclick="logout();">
    <i class="fas fa-desktop"></i>Logout
    </a>
    </div>

    
  </div>
</div>

<div class="center-embedded">
  <div class="embedded-cashiering">
    <iframe class= "iframescreen" src="" name="MainIframe" frameborder="0"></iframe>
  </div>
</div>





<script>
$(document).ready(function(){
  $('.sub-btn').click(function(){
    $(this).next('.sub-menu').slideToggle();
    $(this).find('.dropdown').toggleClass('rotate');

  });
});
</script>
</body>
</html>
