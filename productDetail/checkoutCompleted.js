//Show notification after checkout completed
function checkInput(){
    var modalPaymentSuccess = document.querySelector('.modalPaymentSuccess');
    var btnPayment = document.getElementById('paymentButton');
    var userName = document.getElementById('username');
    var phoneNumber = document.getElementById('phoneNumber');
    var address = document.getElementById('address');
    if (userName.value !== "" && phoneNumber.value !== "" && email.value !== "" && address.value !== ""){
    modalPaymentSuccess.id = "notifyPaymentSuccess";
    btnPayment.addEventListener("click", function(event){
        event.preventDefault();        
    });
    }else{
        modalPaymentSuccess.id = "";
        btnPayment.removeEventListener("click", function(event){
        event.preventDefault();
        
    });
    }

}