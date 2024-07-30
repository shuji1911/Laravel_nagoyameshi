const stripe = Stripe('pk_test_51MJ5CNIXjS4orlsm5MeCW5s99ZyRcO265xWcimIV0tr29q9WglcdsD3yThwRTGPKqqTlx54UHySU6cWUnBEyvts700twsTTUXz');

const elements = stripe.elements();
const cardElement = elements.create('card');
cardElement.mount('#card-element');

const cardHolderName = document.getElementById('card-holder-name');
const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;

const cardError = document.getElementById('card-error');
const errorList = document.getElementById('error-list');

cardButton.addEventListener('click', async (e) => {
    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
        payment_method: {
            card: cardElement,
            billing_details: { name: cardHolderName.value }
        }
    }
    );

    if (cardHolderName.value === '' || error) {
        while (errorList.firstChild) {
            errorList.removeChild(errorList.firstChild);
        }

        // Display "error.message" to the user...
        if (cardHolderName.value === '') {
            cardError.style.display = 'block';

            let li = document.createElement('li');
            li.textContent = 'カード名義人を入力してください。';
            errorList.appendChild(li);
        }

        if (error) {
            console.log(error);
            cardError.style.display = 'block';
            let li = document.createElement('li');
            li.textContent = error['message'];
            errorList.appendChild(li);
        }
    } else {
        // The card has been verified successfully...    
        stripePaymentIdHandler(setupIntent.payment_method);
    }
});

function stripePaymentIdHandler(paymentMethodId) {
    // Insert the paymentMethodId into the form so it gets submitted to the server
    const form = document.getElementById('card-form');

    const hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'paymentMethodId');
    hiddenInput.setAttribute('value', paymentMethodId);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}