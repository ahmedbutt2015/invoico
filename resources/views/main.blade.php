<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="css/app.css">

    <link rel="stylesheet" type="text/css" href="css/app.css">

    <link rel="stylesheet" type="text/css" href="css/invoice.css">
    <script>
        function disableSubmitters() {
            document.querySelectorAll('button:not([name]), input[type=reset], input[type=button]').forEach(function (b) {
                b.disabled = true;
            });
            document.querySelectorAll('input, datalist, textarea, select, button[name], input[type=submit]').forEach(function (i) {
                i.readOnly = true;
            });
        }

        function disableEnterSubmit(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        }

        function autosizeTextarea() {
            this.style.height = '';
            this.style.height = (this.scrollHeight + 2) + 'px';
        }

        window.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('textarea').forEach(function (ta) {
                if (!ta.value || ta.value.length == 0) return;
                ta.style.height = '';
                ta.style.height = (ta.scrollHeight + 2) + 'px';
            });
        });
    </script>


    <script>
         expenseData = [
            {
                description: "",
                quantity: 1000,
                value: 0
            },
        ];

        const tax1Data = {
            percent: null,
            description: null,
        };
        const tax2Data = {
            percent: null,
            description: null,
        };
        const defaultDueDays = null;
    </script>


    <script>
        function invoiceDeletePrompt(event) {
            if (confirm('Are you sure you want to delete this invoice?')) {
                disableSubmitters();
                return true;
            }
            event.preventDefault();
            return false;
        };
    </script>
</head>
<body>

<div class="bg-white">
    <div class="app p-v-sm p-v-md--tablet">
        <nav class="nav flex flex--center">

            <a href="/"><img id="logo" class="vam m-r-md m-r-lg--tablet" width="32" height="32" src="/images/home-icon.png" alt="Spacedive"></a>


            <span class="flex__grow ws-nowrap ellipsis m-r-md">

			<a class="nav__breadcrumb underline--hover m-r-md" href="/">Dashboard</a>


			</span>


            <a class="blue underline--hover ws-nowrap m-l-lg" href="/new_invoice">New Invoice</a>

            <label class="nav__menuButton pointer m-l-lg" for="nav_menuToggle">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <g fill="#CECECE">
                        <rect x="0" y="2" width="16" height="2"></rect>
                        <rect x="0" y="7" width="16" height="2"></rect>
                        <rect x="0" y="12" width="16" height="2"></rect>
                    </g>
                </svg>
            </label>

            <input type="checkbox" autocomplete="off" class="display--none" id="nav_menuToggle">

            <label class="nav__menuCloserOverlay" for="nav_menuToggle"></label>
            <div class="nav__menu p-h-sm bg-white">
                <a class="noOutline" href="/"><div class="nav__menu__item p-sm">
                        <img src="" width="16" height="16">
                        <span class="m-l-sm">Dashboard</span>
                    </div></a>
                <a class="noOutline" href="/logout"><div class="nav__menu__item p-sm">
                        <img src="" width="16" height="16">
                        <span class="m-l-sm">Log Out</span>
                    </div></a>
                <div class="nav__menuHackSpacer"></div>
            </div>


        </nav>
        @yield('body')

    </div>
</div>



<script>
    const currencyData = {
        code: "USD",
        precision: 2,
        step: "0.01"
    };

    const formatData = {
        negDisplay: 0,
        fSep: 46,
        gSep: 44,
        gLen: 3
    };

    function handlePaymentSubmit(e) {
        if (currencyData.precision == 0) return true;

        const paymentInput = document.getElementById('payment__input');
        paymentInput.value = Math.round(paymentInput.value * ('1e' + currencyData.precision));
        return true;
    }

</script>

<script src="js/mithril.min.js" charset="utf-8" defer></script>
<script src="js/invoice.js?v=2" charset="utf-8" defer></script>
<script src="js/app.js"></script>

<script>
    function disableSubmitters() {
        document.querySelectorAll('button:not([name]), input[type=reset], input[type=button]').forEach(function(b) { b.disabled = true; });
        document.querySelectorAll('input, datalist, textarea, select, button[name], input[type=submit]').forEach(function(i) { i.readOnly = true; });
    }

    function disableEnterSubmit(e) {
        if(e.keyCode == 13) {
            e.preventDefault();
        }
    }

    function autosizeTextarea() {
        this.style.height = '';
        this.style.height = (this.scrollHeight + 2) + 'px';
    }

    window.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('textarea').forEach(function(ta) {
            if(!ta.value || ta.value.length == 0) return;
            ta.style.height = '';
            ta.style.height = (ta.scrollHeight + 2) + 'px';
        });
    });
    // const allCheckbox = document.getElementById('draft_all_checkbox');
    const invoiceCheckboxes = document.querySelectorAll('.draft__checkbox');
    // const invoiceActions = document.getElementById('invoice_actions');

    let totalChecked = 0;

    function handleInvoiceCheckboxChanged() {
        totalChecked = 0;
        invoiceCheckboxes.forEach(function(checkbox) {
            if(checkbox.checked) totalChecked++;
        });

        // allCheckbox.classList.remove('label--checked', 'label--semi-checked');
        // invoiceActions.classList.remove('display--none');

        // if(totalChecked == invoiceCheckboxes.length) {
        //     allCheckbox.classList.add('label--checked');
        // } else if(totalChecked > 0) {
        //     allCheckbox.classList.add('label--semi-checked');
        // } else if(totalChecked == 0) {
        //     // invoiceActions.classList.add('display--none');
        // }
    }

    invoiceCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', handleInvoiceCheckboxChanged);
    });

    // allCheckbox.addEventListener('click', function() {
    //     if(totalChecked == invoiceCheckboxes.length) {
    //         invoiceCheckboxes.forEach(function(checkbox) {
    //             checkbox.checked = false;
    //         });
    //     } else {
    //         invoiceCheckboxes.forEach(function(checkbox) {
    //             checkbox.checked = true;
    //         });
    //     }
    //     handleInvoiceCheckboxChanged();
    // });

    // Update for clients that support JavaScript
        // allCheckbox.classList.remove('display--none');
    // invoiceActions.classList.add('display--none');

    function confirmDraftsDelete(event) {
        if(!confirm('Are you sure you want to delete ' + totalChecked + ' invoice' + (totalChecked > 1 ? 's' : '') + '?')) {
            event.stopPropagation();
            event.preventDefault();
            return false;
        }
    }
</script>
</body>
</html>
