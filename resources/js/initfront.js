$(document).ready(function() {
    console.log($('meta[name="csrf-token"]').attr('content'));
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

var elements = stripe.elements();
var cardElement = elements.create('card',{
    hidePostalCode: true
});
document.getElementById('backdetails').addEventListener('click', function (event) {
    document.getElementById('user-details-form').style.display = 'block';
    document.getElementById('payment-form').style.display = 'none';
});

document.getElementById('submit-user-details').addEventListener('click', function (event) {
    event.preventDefault();

    // Get personal details from form
    var name = document.querySelector('input[name="name"]').value;
    var email = document.querySelector('input[name="email"]').value;
    var phone = document.querySelector('input[name="phone"]').value;
    var street = document.querySelector('input[name="address"]').value ?? '';
    var city = document.querySelector('input[name="city"]').value ?? '';
    var state = document.querySelector('input[name="state"]').value ?? '';
    var zipcode = document.querySelector('input[name="zipcode"]').value ?? '';
    var country = document.querySelector('input[name="country"]').value ?? '';
    var countryCode = "US";

    function validateFields() {
        let isValid = true;

        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = ''; // Clear previous errors
        });
        if (!name) {
            document.getElementById('error-name').textContent = "Name is required.";
            isValid = false;
        }

        if (!email) {
            document.getElementById('error-email').textContent = "Email is required.";
            isValid = false;
        } else {
            // Simple email validation
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('error-email').textContent = "Please enter a valid email address.";
                isValid = false;
            }
        }

        if (!phone) {
            document.getElementById('error-phone').textContent = "Phone number is required.";
            isValid = false;
        } 

        if (!street) {
            document.getElementById('error-address').textContent = "Address is required.";
            isValid = false;
        }

        // if (!city) {
        //     document.getElementById('error-city').textContent = "City is required.";
        //     isValid = false;
        // }

        // if (!state) {
        //     document.getElementById('error-state').textContent = "State is required.";
        //     isValid = false;
        // }

        if (!zipcode) {
            document.getElementById('error-zipcode').textContent = "Zipcode is required.";
            isValid = false;
        }


        return isValid;
    }

    if (!validateFields()) {
        return;
    }
    $.ajax({
        type: 'POST',
        url: check_email_point,
        data: {
            email: email,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token here
        },
        success: function(response) {
            if (response.exists) {
                // Show email exists error
                document.getElementById('error-email').textContent = "This email is already registered.";

            } else {
                // Proceed with setting up the form if email is unique
                document.getElementById('street_ad').value = street;
                document.getElementById('country').value = countryCode;

                // Set hidden input fields with personal details
                document.getElementById('hidden-name').value = name;
                document.getElementById('hidden-email').value = email;
                document.getElementById('hidden-phone').value = phone;
                document.getElementById('hidden-street').value = street;
                document.getElementById('hidden-city').value = city;
                document.getElementById('hidden-state').value = state;
                document.getElementById('hidden-zipcode').value = zipcode;
                document.getElementById('hidden-country').value = countryCode;

                // Hide user details form and show Stripe card form
                document.getElementById('user-details-form').style.display = 'none';
                document.getElementById('payment-form').style.display = 'block';

                // Mount Stripe card element
                cardElement.mount('#card-element');
            }
        },
        error: function() {
            alert("An error occurred while checking the email.");
        }
    });
});

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

            localStorage.clear();
            form.submit();
        }
    });
});



document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#user-details-form');
    const expirationTime = 1 * 60 * 1000; // 5 minutes in milliseconds

    if (form) {
        const currentTime = new Date().getTime();

        // Check and clear expired data
        const storedTime = localStorage.getItem('form-save-time');
        if (storedTime && currentTime - parseInt(storedTime, 10) > expirationTime) {
            // Clear all form-related localStorage keys
            document.querySelectorAll('#user-details-form input').forEach(input => {
                localStorage.removeItem(input.name);
            });
            localStorage.removeItem('form-save-time');
        }

        // Save input values and the save timestamp to localStorage
        document.querySelectorAll('#user-details-form input').forEach(input => {
            input.addEventListener('input', () => {
                localStorage.setItem(input.name, input.value);
                localStorage.setItem('form-save-time', new Date().getTime().toString()); // Save the current time
            });
        });

        // Load values from localStorage
        document.querySelectorAll('#user-details-form input').forEach(input => {
            input.value = localStorage.getItem(input.name) || '';
        });
    }
});

let autocomplete;
    function initAutocomplete() {
        // Initialize Google Autocomplete
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('autocomplete'),
            { types: ['address'],componentRestrictions: { country: ["us"] }, }
        );

        // Add listener to populate address fields on selection
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();
        const addressComponents = place.address_components;

        // Clear existing values
        //document.getElementById('country').value = '';
        document.getElementById('state').value = '';
        document.getElementById('city').value = '';
        document.getElementById('zipcode').value = '';

        // Loop through address components and assign values to fields
        addressComponents.forEach(component => {
            const types = component.types;
            const value = component.long_name;

            if (types.includes("country")) {
                //document.getElementById('country').value = value;
            } else if (types.includes("administrative_area_level_1")) {
                document.getElementById('state').value = value;
            } else if (types.includes("locality") || types.includes("postal_town")) {
                document.getElementById('city').value = value;
            } else if (types.includes("postal_code")) {
                document.getElementById('zipcode').value = value;
            }
        });
    }