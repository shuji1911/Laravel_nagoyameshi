const stripe = Stripe('pk_test_51PjzMVCzyQSNFj3Nx12ZSvh5Tnd0oqU29zpPFDedu79aXdSOPT7p2TNobI6YaD9wYEeMeOiWSbPS8hE15YH95jNK00wAg1sPfP');

cardElement.mount('#card-element');

const cardHolderName = document.getElementById('card-holder-name');
const cardButton = document.getElementById('card-button');
const clientSecret = cardButton.dataset.secret;

// エラーメッセージを表示するdiv要素を取得する
const cardError = document.getElementById('card-error');
// エラーメッセージを表示するul要素を取得する
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

    if (cardHolderName.value === '') {
      cardError.style.display = 'block';

      let li = document.createElement('li');
      li.textContent = 'カード名義人の入力は必須です。';
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
    stripePaymentIdHandler(setupIntent.payment_method);
  }
});

function stripePaymentIdHandler(paymentMethodId) {
  const form = document.getElementById('card-form');

  const hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'paymentMethodId');
  hiddenInput.setAttribute('value', paymentMethodId);
  form.appendChild(hiddenInput);

  form.submit();
}