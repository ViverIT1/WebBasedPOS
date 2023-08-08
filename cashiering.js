const productList = [];

const addButton = document.getElementById("add-product");
const productListElement = document.getElementById("product-list");

addButton.addEventListener("click", () => {
    const productCode = document.getElementById("product").value;
    const product = findProductByCode(productCode);

    if (product) {
        productList.push(product);
        updateProductList();
        updateTotal();
    } else {
        alert("Product not found");
    }
});

function findProductByCode(code) {
    // You would implement code here to fetch product details by code
    // For now, let's assume there's a function getProductByCode(code)
    // that returns product details or null if not found
    return getProductByCode(code);
}

function updateProductList() {
    productListElement.innerHTML = "";
    productList.forEach((product, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${product.quantity}</td>
            <td>${product.unit}</td>
            <td>${product.name}</td>
            <td>${product.unitPrice}</td>
            <td>${product.quantity * product.unitPrice}</td>
        `;
        productListElement.appendChild(row);
    });
}

function updateTotal() {
    // Calculate and update subtotal, discount, and grand total
    // You would implement this logic based on your requirements
}