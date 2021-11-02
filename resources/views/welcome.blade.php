<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
        }

        input {
            font-size: 16px;
            line-height: 24px;
            padding: 16px;
            background-color: transparent;
            display: block;
            margin: 0;
            width: 100%;
            border: none;
            display: block;
            margin-top: 0em;
        }

        input::placeholder {
            color: #a0a0a0;
        }

    </style>
    <link href="{{ asset('css/square.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

</head>

<body>
    <div id="form-container" class="sq-payment-form">
        <div class="image-section" style="display: flex ; justify-content: center; width: 100%;">
            <img src="{{ url('resources/img/loginlogo.jpg') }}" style="width: 70px"/>
        </div>
        <div class="sq-field" style="padding-left: 30px">
            <label class="sq-label" style="font-size: 20px; font-family: system-ui;">Excuse me Payment via cridet card is temporarily unavailable Currently available to pay via PayPal  </label>


        </div>


    </body>
<!-- link to the SqPaymentForm library -->
<script type="text/javascript" src="https://js.squareupsandbox.com/v2/paymentform">
</script>
<script>
    $('#success').hide();
    var paymentForm = new SqPaymentForm({
        // Initialize the payment form elements
        //TODO: Replace with your sandbox application ID
        applicationId: "sandbox-sq0idb-yKjG2UMenL_HX5VkPVHuOQ",
        inputClass: 'sq-input',
        autoBuild: false,
        // Customize the CSS for SqPaymentForm iframe elements
        inputStyles: [{
            fontSize: '16px',
            lineHeight: '24px',
            padding: '16px',
            placeholderColor: '#a0a0a0',
            backgroundColor: 'transparent',
        }],
        // Initialize the credit card placeholders
        cardNumber: {
            elementId: 'sq-card-number',
            placeholder: 'Card Number'
        },
        cvv: {
            elementId: 'sq-cvv',
            placeholder: 'CVV'
        },
        expirationDate: {
            elementId: 'sq-expiration-date',
            placeholder: 'MM/YY'
        },
        postalCode: {
            elementId: 'sq-postal-code',
            placeholder: 'Postal'
        },
        // SqPaymentForm callback functions
        callbacks: {
            /*
             * callback function: cardNonceResponseReceived
             * Triggered when: SqPaymentForm completes a card nonce request
             */
            cardNonceResponseReceived: function(errors, nonce, cardData) {
                if (errors) {
                    // Log errors from nonce generation to the browser developer console.
                    console.error('Encountered errors:');
                    errors.forEach(function(error) {
                        console.error('  ' + error.message);
                    });
                    alert('Error in your Card details');
                    location.href = 'https://wesalinternational.com/un_successfully_paid'
                    return;
                }
                //TODO: Replace alert with code in step 2.1
                //  alert('here is your card token ' + nonce);
                var name = document.getElementById("name").value;
                var amount = document.getElementById("amount").value;
                console.log(name + amount);
                $('#success').hide();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('add.card') }}",
                    type: "POST",
                    data: {
                        nonce,
                        name,
                        amount
                    },
                    success: function(data) {
                        $('#success').show();
                        console.log('data', data);
                        location.href = 'https://wesalinternational.com/successfully_paid'
                    },
                    error: function(xhr, status, error) {
                        console.log('error', error)
                    }
                });
            }
        }
    });
    paymentForm.build();

    // onGetCardNonce is triggered when the "Pay $1.00" button is clicked
    function onGetCardNonce(event) {
        // Don't submit the form until SqPaymentForm returns with a nonce
        event.preventDefault();
        // Request a nonce from the SqPaymentForm object
        paymentForm.requestCardNonce();


    }
</script>

</html>
