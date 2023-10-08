<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sales and Inventory Management System</title>
    <link rel="stylesheet" href="nextsyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="next.js"></script>


</head>
<body><div class="sidebar">
        <div class="logo-details">
            <i class="fa-brands fa-centos"></i>
            <span class="logo_name">POS</span>
        </div>
        <ul class="nav-links">

            <li>
                <a href="#" id="submenu-item-1">
                    <i class="fa-solid fa-cash-register"></i>
                    <span class="link_name">Cashiering</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="cashiering.php" id="submenu-blank-1">Cashiering</a></li>
                </ul>
            </li>

            <li class="drop">
                <div class="iocn-link">
                <a href="#">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span class="link_name">Inventory Management</span>
                </a>
               <i class="fa-solid fa-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Inventory Management</a></li>
                <li><a href="itemanage.php" target="MainIframe">Item Management</a></li>
                <li><a href="stockadj.php" target="MainIframe">Stock Adjusment</a></li>
                <li><a href="discount.php" target="MainIframe">Discount</a></li>
                <li><a href="packagelist.html" target="MainIframe">Packages</a></li>
                </ul>
            </li>

            <li>
                <a href="#" id="submenu-item-2">
                    <i class="fa-solid fa-user-gear"></i>
                    <span class="link_name">User Management</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="usermanage.html" id="submenu-blank-2">User Management</a></li>
                </ul>
            </li>

            <li>
                <a href="#" id="submenu-item-3">
                    <i class="fa-solid fa-users-gear"></i>
                    <span class="link_name">Customer Management</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="customermanage.php" id="submenu-blank-3">Customer Management</a></li>
                </ul>
            </li>

            <li class="drop">
                <div class="iocn-link">
                <a href="#">
                    <i class="fa-solid fa-truck-field"></i>
                    <span class="link_name">Supplier</span>
                </a>
               <i class="fa-solid fa-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Supplier</a></li>
                <li><a href="supplierinfo.php" target="MainIframe">Supplier Information Management</a></li>
                <li><a href="purchaseOrder.php" target="MainIframe">Purchased Oder to Supplier</a></li>
                <li><a href="suppdel.php" target="MainIframe">Supplier Delivery</a></li>
                </ul>
            </li>

            <li class="drop">
                <div class="iocn-link">
                <a href="#">
                    <i class="fa-solid fa-circle-info"></i>
                    <span class="link_name">Utility</span>
                </a>
               <i class="fa-solid fa-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Utility</a></li>
                <li><a href="customereturn.html" target="MainIframe">Customer Return</a></li>
                <li><a href="suppreturn.html" target="MainIframe">Supplier Return</a></li>
                <li><a href="reposidatabase.html" target="MainIframe">Database Backup and Restore</a></li>
                <li><a href="audit.html" target="MainIframe">Audit Trail</a></li>
                <li><a href="itemqrcode.html" target="MainIframe">Item QR code</a></li>
                </ul>
            </li>

            <li class="drop">
                <div class="iocn-link">
                <a href="#">
                    <i class="fa-solid fa-list-check"></i>
                    <span class="link_name">Reporting and Analytics</span>
                </a>
               <i class="fa-solid fa-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Reporting and Analytics</a></li>
                <li><a href="invreport.html" target="MainIframe">Inventory Report</a></li>
                <li><a href="stockadjreport.html" target="MainIframe">Stock Adjusment Report</a></li>
                <li><a href="salesreport.html" target="MainIframe">Sales Report</a></li>
                <li><a href="cusreturnreport.html" target="MainIframe">Customer Return Report</a></li>
                <li><a href="suppreturnreport.html" target="MainIframe">Supplier Return Report</a></li>
                <li><a href="reodrlistreport.html" target="MainIframe">Re Order List Report</a></li>
                <li><a href="suppdevreport.html" target="MainIframe">Supplier Delivery Report</a></li>
                <li><a href="prdexpreport.html" target="MainIframe" >Product Experiration Report</a></li>
                <li><a href="datanalreport.html" target="MainIframe" >Data Analytics</a></li>
                </ul>
            </li>

            <li class="drop">
                <div class="iocn-link">
                <a href="#">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span class="link_name">Maintenance</span>
                </a>
               <i class="fa-solid fa-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Maintenance</a></li>
                <li><a href="pricemaintenance.html" target="MainIframe">Pricing Maintenance</a></li>
                <li><a href="recieptmaintenance.html" target="MainIframe" >Receipt Maintenance</a></li>
                <li><a href="discountmaintenance.html" target="MainIframe" >Discount Maintenance</a></li>
                <li><a href="categorymaintenance.html" target="MainIframe" >Category Maintenance</a></li>
                <li><a href="unitmaintenance.html" target="MainIframe" >Unit Maintenance</a></li>
                <li><a href="updtpolicy.html" target="MainIframe" >Update Policy</a></li>
                </ul>
            </li>

            <li>
                <a href="#" id="submenu-item-4">
                    <i class="fa-solid fa-gavel"></i>
                    <span class="link_name">Policy</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="policy.html" id="submenu-blank-4">Policy</a></li>
                </ul>
            </li>

            <li>
                <a href="#" onclick="logout();">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-rotate-180"></i>
                    <span class="link_name">Logout</span>
                </a>
            </li>
            
            </li>
            </ul>
    </div>

    <section class="home-section">
        <div class="home-content">
            <i class="fa fa-bars"></i>
            <span class="text">Sales and Inventory</span>
        </div>
    </section>

    <div class="center-embedded">
        <div class="embedded-iframe">
          <iframe class="iframescreen" src="" name="MainIframe" frameborder="0"></iframe>
        </div>
      </div>

     <script>     
        let menuItems = document.querySelectorAll(" .drop");

        for (var i = 0; i < menuItems.length; i++) {
        menuItems[i].addEventListener("click", (e) => {
        let menuItem = e.currentTarget; // Get the clicked <li> element

        // Check if the clicked <li> has a submenu (class "sub-menu")
        if (menuItem.querySelector(".sub-menu")) {
            menuItem.classList.toggle("showMenu");
                }
            });
        }

        let submenuItems = document.querySelectorAll(".sub-menu");
        for (var i = 0; i < submenuItems.length; i++) {
            submenuItems[i].addEventListener("click", (e) => {
                e.stopPropagation();
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".fa-bars");
        console.log(sidebarBtn);
        sidebarBtn.addEventListener("click", ()=>{
            sidebar.classList.toggle("close");
        });

        let iframe = document.querySelector(".iframescreen");

        // Submenu item 1 for Cashiering
        let submenuItem1 = document.getElementById("submenu-item-1");
        let submenuBlank1 = document.getElementById("submenu-blank-1");

        submenuItem1.addEventListener("click", function (e) {
            e.preventDefault();
            iframe.src = "cashiering.php";
        });

                // Submenu item 2 for User Management
        let submenuItem2 = document.getElementById("submenu-item-2");
        let submenuBlank2 = document.getElementById("submenu-blank-2");

        submenuItem2.addEventListener("click", function (e) {
            e.preventDefault();
            iframe.src = "usermanage.html";
        });

                // Submenu item 3 for Customer Management
        let submenuItem3 = document.getElementById("submenu-item-3");
        let submenuBlank3 = document.getElementById("submenu-blank-3");

        submenuItem3.addEventListener("click", function (e) {
            e.preventDefault();
            iframe.src = "customermanage.php";
        });

                // Submenu item 4 for Policy
        let submenuItem4 = document.getElementById("submenu-item-4");
        let submenuBlank4 = document.getElementById("submenu-blank-4");

        submenuItem4.addEventListener("click", function (e) {
            e.preventDefault();
            iframe.src = "policy.html";
        });
    </script>

</body>
</html>