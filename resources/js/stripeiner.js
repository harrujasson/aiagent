var elements = stripe.elements();
    var cardElement = elements.create('card',{
        hidePostalCode: true
    });

    var countryCode = "US";
    // Set hidden input fields with personal details
    document.getElementById('hidden-country').value = countryCode;
    document.getElementById('payment-form').style.display = 'block';

    // Mount Stripe card element
    cardElement.mount('#card-element');


    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: document.getElementById('hidden-name').value,
                email: document.getElementById('hidden-email').value,
                phone: document.getElementById('hidden-phone').value,
                address: {
                    line1: document.getElementById('hidden-street').value,
                    city: document.getElementById('hidden-city').value,
                    state: document.getElementById('hidden-state').value,
                    postal_code: document.getElementById('hidden-zipcode').value,
                    country: document.getElementById('hidden-country').value
                }
            },
        }).then(function(result) {
            if (result.error) {
                // Show error to your customer
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Add PaymentMethod ID to hidden input
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', result.paymentMethod.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        });
    });