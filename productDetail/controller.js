const priceProduct = document.querySelectorAll('.price-product');
const quantityInput = document.querySelectorAll('.quantityInput');
const totalPriceDisplay = document.querySelectorAll('.total-price');
const btnIncre = document.querySelectorAll('.incrementBtn');
const btnDecre = document.querySelectorAll('.decrementBtn');
const totalCart = document.getElementById('totalCart');
const newQuantityInput = document.querySelector('[name="newQuantity"]');


function updateTotalPrice(index) {
    const price = parseFloat(priceProduct[index].textContent);
    const quantity = parseInt(quantityInput[index].value);
    const totalPrice = price * quantity;
    totalPriceDisplay[index].textContent = "$" + totalPrice.toFixed(2);
}
function updateNewQuantity() {
    let sumQuantity = 0;
    for (let i = 0; i < quantityInput.length; i++) {
        sumQuantity += parseInt(quantityInput[i].value);
    }
    newQuantityInput.value = sumQuantity;
}
for (let i = 0; i < btnIncre.length; i++) {
    btnIncre[i].addEventListener('click', function() {
        quantityInput[i].value = parseInt(quantityInput[i].value) + 1;  
        updateTotalPrice(i);
        updateNewQuantity();
        updateTotalCart()
    })
};

for (let i = 0; i < btnDecre.length; i++) {
    btnDecre[i].addEventListener('click', function() {
        if(quantityInput[i].value >1)
        quantityInput[i].value = parseInt(quantityInput[i].value) - 1;  
        updateTotalPrice(i);
        updateNewQuantity();
        updateTotalCart()
    })
};

function updateTotalCart() {
    let sum = 0;
    for (let i = 0; i < totalPriceDisplay.length; i++) {
        sum += parseFloat(totalPriceDisplay[i].textContent.replace("$", ""));
    }
    totalCart.textContent = "$" + sum.toFixed(2);
}


for (let i = 0; i < totalPriceDisplay.length; i++) {
    updateTotalPrice(i);
    updateTotalCart()
}






