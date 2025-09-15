document.addEventListener("DOMContentLoaded", function() {
    const productDataElement = document.getElementById("product-data");
    // If the element doesn't exist, do nothing.
    if (!productDataElement) {
        return;
    }

    const sizeQuantities = JSON.parse(productDataElement.dataset.sizes);
    
    const sizeSelect = document.getElementById("size_select");
    const quantityInput = document.getElementById("soluong_input");
    const btnDecrease = document.getElementById("giam");
    const btnIncrease = document.getElementById("tang");

    function updateMaxQuantity() {
        if (!sizeSelect || !quantityInput) return;
        
        const selectedSize = sizeSelect.value;
        const maxQuantity = sizeQuantities[selectedSize] || 0;
        
        quantityInput.max = maxQuantity;
        
        if (parseInt(quantityInput.value) > maxQuantity) {
            quantityInput.value = 1;
        }
    }

    // Run on page load
    updateMaxQuantity();

    // Add event listeners if elements exist
    if (sizeSelect) {
        sizeSelect.addEventListener("change", function() {
            quantityInput.value = 1;
            updateMaxQuantity();
        });
    }

    if (btnIncrease) {
        btnIncrease.addEventListener("click", function() {
            let currentVal = parseInt(quantityInput.value);
            let maxVal = parseInt(quantityInput.max);
            if (currentVal < maxVal) {
                quantityInput.value = currentVal + 1;
            }
        });
    }

    if (btnDecrease) {
        btnDecrease.addEventListener("click", function() {
            let currentVal = parseInt(quantityInput.value);
            if (currentVal > 1) {
                quantityInput.value = currentVal - 1;
            }
        });
    }
    
    if (quantityInput) {
        quantityInput.addEventListener("input", function() {
            let val = parseInt(this.value);
            let max = parseInt(this.max);
            if (val > max) { this.value = max; }
            if (val < 1) { this.value = 1; }
        });
    }
});