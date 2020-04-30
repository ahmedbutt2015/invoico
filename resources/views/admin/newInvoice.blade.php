@extends('dashboard',['a' => 'New Invoice'])
@section('body')
    <div class="row">
        <div class="app">
            <form id="invoice" enctype="multipart/form-data" method="post" >

            <div class="flex flex--wrap flex--justify-space-between m-v-md  m-v-xl--desktop" id="invoice__buttons">


                <a href="javascript:window.print()" >
                    <div class="button button--blue-inverted m-v-sm">
                        <!--                <img src="img/icon_file_sm.svg" width="10" height="10" alt="file" class="m-r-sm">-->
                        <span style="color: #5354CE">Print</span>
                    </div>
                </a>

                <a href="javascript:window.print()" >
                    <div class="button button--blue-inverted m-v-sm">
                        <!--                <img src="img/icon_file_sm.svg" width="10" height="10" alt="file" class="m-r-sm">-->
                        <span style="color: #5354CE">Preview</span>
                    </div>
                </a>



                <div class="button button--blue-inverted m-v-sm">
                    <select name="client_id" class="" id="clients">
                        <option value="">Select client</option>
                        @foreach($clients as $client)
                            <option value="{{$client->id}}"
                                    data-name="{{$client->name}}"
                                    data-num="{{$client->num}}"
                                    data-address="{{$client->address}}"
                                    data-cname="{{$client->cname}}"
                                    data-email="{{$client->email}}"
                                    data-phone="{{$client->phone}}"
                            >{{$client->name}}</option>
                        @endforeach
                    </select>
                </div>

                <a data-toggle="modal" data-target="#addClient" >
                    <div class="button button--blue-inverted m-v-sm">
                        <!--                <img src="img/icon_file_sm.svg" width="10" height="10" alt="file" class="m-r-sm">-->
                        <span style="color: #5354CE">+ new cLient</span>
                    </div>
                </a>
                <div style="flex: 1 0 10px;"></div>

                <button form="invoice__delete" class="invoice__deleteImageFlip button button--blue-inverted button--red-inverted-hover m-v-sm">
                    <!--            <img src="img/icon_delete_sm_blue.svg" width="10" height="10" alt="x" class="m-r-sm">-->
                    <!--            <img src="img/icon_delete_sm_red.svg" width="10" height="10" alt="x" class="m-r-sm display&#45;&#45;none">-->
                    <span style="color: #5354CE">Delete</span>
                </button>
            </div>

                <div class="card bg-white display--block m-t-md m-t-lg--tablet m-t-xl--desktop m-b-md m-b-lg--tablet" >
                {{csrf_field()}}
                <div class="invoice__titles m-v-md ">
{{--
                    <div class="m-v-md ">
                        <input type="file" name="logo"  class="form-control" id="imgInp">
                    </div>
                    <div class="m-v-md ">
                        <img src="" height="100px" width="100px" alt="" id="blah">
                    </div>--}}
                    <div class="m-v-md ">
                        <input type="text" name="invoice_num" placeholder="" value="Invoice {{\App\Invoice::where('user_id',auth()->id())->count() + 1}}" class="font-size--header blue ">
                    </div>

                    <div>
                        <input id="invoice__description" class="invoice__description invoice__description--input inputBorder p-sm ellipsis" type="text" name="description" value="" placeholder="Project / Description" maxlength="255" autocomplete="off"
                               onkeypress="disableEnterSubmit(event);">
                    </div>

                </div>

                <div class="invoice__dates m-v-lg">
                    <div class="m-v-md">

                        <div class="gray m-r-sm display--inline--tablet">Issued</div>
                        <input id="invoice__dateIssued" class="inputBorder p-sm" name="date_issued" type="date" placeholder="yyyy-mm-dd" value="{{date('Y-m-d')}}" autocomplete="off" required onkeypress="disableEnterSubmit(event);"
                               class="display--block display--inline--tablet">

                    </div>


                    <div class="m-v-md">
                        <div class="gray m-r-sm display--inline--tablet">Due</div>
                        <input id="invoice__dateDue" class="inputBorder p-sm" name="date_due" type="date" placeholder="yyyy-mm-dd" autocomplete="off" onkeypress="disableEnterSubmit(event);">
                    </div>

                </div>

                <div class="clear"></div>

                <h4 style="color: #4E4E4E;margin-bottom: 10px">Who are you invoicing?</h4>

                <div class="flex flex--start">

                    <div class="m-v-md ">

                        <input type="text" id="name" name="client" placeholder="Company Name" class="">
                    </div>
                </div>
                <div class="flex flex--start">

                    <div class="m-v-md ">
{{--                        <label for="">Registration Number</label>--}}

                        <input type="text" id="num" name="reg_num" placeholder="Registration Number" class="">
                    </div>
                </div>
                <div class="flex flex--start">

                    <div class="m-v-md ">
{{--                        <label for="">Billing Address</label>--}}

                        <input type="text" id="address" name="address" placeholder="Billing Address" class="">
                    </div>
                </div>
                <div class="flex flex--start">

                    <div class="m-v-md ">
{{--                        <label for="">Contact Name</label>--}}

                        <input type="text" id="cname" name="contact" placeholder="Contact Name" class="">
                    </div>
                </div>
                <div class="flex flex--start">

                    <div class="m-v-md ">
{{--                        <label for="">Company Email</label>--}}

                        <input type="text" id="email" name="email" placeholder="Email" class="">
                    </div>
                </div>
                <div class="flex flex--start">

                    <div class="m-v-md ">
{{--                        <label for="">Company Phone</label>--}}

                        <input type="text" id="phone" name="phone" placeholder="Phone" class="">
                    </div>
                </div>



                <ul class="invoice__expenses display--table fullWidth fullWidth--max m-t-lg m-t-xl--tablet">
                    <li class="gray display--table-row">
                        <span class="expense__colDesc display--table-cell left">Description</span>
                        <span class="expense__colQty display--table-cell right">Qty.</span>
                        <span class="expense__colPrice display--table-cell right">Price</span><span
                            class="expense__colTotal display--table-cell right">Total</span>
                    </li>
                </ul>

                <div id="expenses">

                </div>

                <div class="clear"></div>

                <div class="m-v-md ">

                    <textarea id="invoice__notes" name="notes" class="textarea--v p-sm borderBox fullWidth" placeholder="Notes..." autocomplete="off" maxlength="2000" oninput="autosizeTextarea.bind(this, event)();"></textarea>

                </div>

                <hr/>

                <section class="flex flex--baseline flex--wrap flex--justify-space-between m-t-lg m-t-xl--tablet m-b-md">
                    <div class="details__column flex__grow flex flex--baseline">
            <span>
                <label for="invoice__currency" class="gray m-r-sm">Currency</label>
                <select id="invoice__currency" name="currency" class="m-r-md">

                    <option value="AED">AED (.د.إ)</option>

                    <option value="AFN">AFN (؋)</option>

                    <option value="ALL">ALL (L)</option>

                    <option value="AMD">AMD (դր.)</option>

                    <option value="ANG">ANG (ƒ)</option>

                    <option value="AOA">AOA ()</option>

                    <option value="ARS">ARS ($)</option>

                    <option value="AUD">AUD ($)</option>

                    <option value="AWG">AWG (ƒ)</option>

                    <option value="AZN">AZN (₼)</option>

                    <option value="BAM">BAM (KM)</option>

                    <option value="BBD">BBD ($)</option>

                    <option value="BDT">BDT ()</option>

                    <option value="BGN">BGN (лв)</option>

                    <option value="BIF">BIF ()</option>

                    <option value="BMD">BMD ($)</option>

                    <option value="BND">BND ($)</option>

                    <option value="BOB">BOB (Bs.)</option>

                    <option value="BRL">BRL (R$)</option>

                    <option value="BSD">BSD ($)</option>

                    <option value="BWP">BWP (P)</option>

                    <option value="BZD">BZD (BZ$)</option>

                    <option value="CAD">CAD ($)</option>

                    <option value="CDF">CDF ()</option>

                    <option value="CHF">CHF (CHF)</option>

                    <option value="CLP">CLP ($)</option>

                    <option value="CNY">CNY (元)</option>

                    <option value="COP">COP ($)</option>

                    <option value="CRC">CRC (₡)</option>

                    <option value="CVE">CVE ()</option>

                    <option value="CZK">CZK (Kč)</option>

                    <option value="DJF">DJF ()</option>

                    <option value="DKK" selected>DKK (kr)</option>

                    <option value="DOP">DOP (RD$)</option>

                    <option value="DZD">DZD (.د.ج)</option>

                    <option value="EGP">EGP (£)</option>

                    <option value="ETB">ETB ()</option>

                    <option value="EUR">EUR (€)</option>

                    <option value="FJD">FJD ($)</option>

                    <option value="FKP">FKP (£)</option>

                    <option value="GBP">GBP (£)</option>

                    <option value="GEL">GEL ()</option>

                    <option value="GIP">GIP (£)</option>

                    <option value="GMD">GMD ()</option>

                    <option value="GNF">GNF ()</option>

                    <option value="GTQ">GTQ (Q)</option>

                    <option value="GYD">GYD ($)</option>

                    <option value="HKD">HKD ($)</option>

                    <option value="HNL">HNL (L)</option>

                    <option value="HRK">HRK (kn)</option>

                    <option value="HTG">HTG ()</option>

                    <option value="HUF">HUF (Ft)</option>

                    <option value="IDR">IDR (Rp)</option>

                    <option value="ILS">ILS (₪)</option>

                    <option value="INR">INR (₹)</option>

                    <option value="ISK">ISK (kr)</option>

                    <option value="JMD">JMD (J$)</option>

                    <option value="JPY">JPY (¥)</option>

                    <option value="KES">KES (KSh)</option>

                    <option value="KGS">KGS (сом)</option>

                    <option value="KHR">KHR (៛)</option>

                    <option value="KMF">KMF ()</option>

                    <option value="KRW">KRW (₩)</option>

                    <option value="KYD">KYD ($)</option>

                    <option value="KZT">KZT (₸)</option>

                    <option value="LAK">LAK (₭)</option>

                    <option value="LBP">LBP (£)</option>

                    <option value="LKR">LKR (₨)</option>

                    <option value="LRD">LRD ($)</option>

                    <option value="LSL">LSL ()</option>

                    <option value="MAD">MAD (.د.م)</option>

                    <option value="MDL">MDL ()</option>

                    <option value="MGA">MGA ()</option>

                    <option value="MKD">MKD (ден)</option>

                    <option value="MMK">MMK ()</option>

                    <option value="MNT">MNT (₮)</option>

                    <option value="MOP">MOP ()</option>

                    <option value="MRO">MRO ()</option>

                    <option value="MUR">MUR (₨)</option>

                    <option value="MVR">MVR ()</option>

                    <option value="MWK">MWK ()</option>

                    <option value="MXN">MXN ($)</option>

                    <option value="MYR">MYR (RM)</option>

                    <option value="MZN">MZN (MT)</option>

                    <option value="NAD">NAD ($)</option>

                    <option value="NGN">NGN (₦)</option>

                    <option value="NIO">NIO (C$)</option>

                    <option value="NOK">NOK (kr)</option>

                    <option value="NPR">NPR (₨)</option>

                    <option value="NZD">NZD ($)</option>

                    <option value="PAB">PAB (B/.)</option>

                    <option value="PEN">PEN (S/)</option>

                    <option value="PGK">PGK ()</option>

                    <option value="PHP">PHP (₱)</option>

                    <option value="PKR">PKR (₨)</option>

                    <option value="PLN">PLN (zł)</option>

                    <option value="PYG">PYG (Gs)</option>

                    <option value="QAR">QAR (﷼)</option>

                    <option value="RON">RON (lei)</option>

                    <option value="RSD">RSD (Дин.)</option>

                    <option value="RUB">RUB (₽)</option>

                    <option value="RWF">RWF ()</option>

                    <option value="SAR">SAR (﷼)</option>

                    <option value="SBD">SBD ($)</option>

                    <option value="SCR">SCR (₨)</option>

                    <option value="SEK">SEK (kr)</option>

                    <option value="SGD">SGD ($)</option>

                    <option value="SHP">SHP (£)</option>

                    <option value="SLL">SLL ()</option>

                    <option value="SOS">SOS (S)</option>

                    <option value="SRD">SRD ($)</option>

                    <option value="STD">STD ()</option>

                    <option value="SVC">SVC ($)</option>

                    <option value="SZL">SZL ()</option>

                    <option value="THB">THB (฿)</option>

                    <option value="TJS">TJS ()</option>

                    <option value="TOP">TOP ()</option>

                    <option value="TRY">TRY (₺)</option>

                    <option value="TTD">TTD (TT$)</option>

                    <option value="TWD">TWD (NT$)</option>

                    <option value="TZS">TZS (TSh)</option>

                    <option value="UAH">UAH (₴)</option>

                    <option value="UGX">UGX (USh)</option>

                    <option value="USD" >USD ($)</option>

                    <option value="UYU">UYU ($U)</option>

                    <option value="UZS">UZS (so’m)</option>

                    <option value="VND">VND (₫)</option>

                    <option value="VUV">VUV ()</option>

                    <option value="WST">WST ()</option>

                    <option value="XAF">XAF ()</option>

                    <option value="XCD">XCD ($)</option>

                    <option value="XOF">XOF ()</option>

                    <option value="XPF">XPF ()</option>

                    <option value="YER">YER (﷼)</option>

                    <option value="ZAR">ZAR (R)</option>

                    <option value="ZMW">ZMW ()</option>

                </select>
            </span>
                        <div class="flex__grow"></div>
                    </div>


                    <div class="flex__grow details__gutter"></div>

                    <div class="details__column flex__basis0 flex__grow flex flex--baseline invoice__submitContainer">
                        <input type="reset" id="invoice__cancelSubmit" class="invoice_submit_button button button--gray-inverted gray display--none m-r-md" value="Cancel">
                        <div class="flex__grow"></div>
                        <button  name="submit" value="draft"   class="button button--blue-inverted m-v-sm invoice_submit_button" type="submit" style="margin-right:10px;color:#5354CE">Save as Draft</button>
                        <button id="invoice__submit" class="button button--blue right invoice_submit_button"  name="submit" value="send" type="submit" style="background-color: #5354CE !important;">Send to Spacedive</button>
                    </div>


                </section>

                </div>
            </form>



            <div>
                <input type="checkbox" id="invoiceNumberChange_show" autocomplete="off" class="modalToggle">
                <label class="modalCloser" for="invoiceNumberChange_show"></label>
                <div class="modal">
                    <div class="modal__content">
                        <h2>Change Invoice Number</h2>

                        <form id="invoice_change_number" action="/invoices/104/number" method="post" onsubmit="disableSubmitters();" autocomplete="off">
                            <input type="hidden" name="csrf" value="7777d3f9-3d56-41ff-82b0-b6896fef5359">
                            <p>You may change the number of this invoice, but no two invoices may share the same number.</p>
                            <div>
                                <input type="number" step="1" inputmode="numeric" class="inputBorder p-sm" min="0" max="999999999" placeholder="Number" name="number" value="104">
                            </div>
                            <div class="m-t-md">
                                <button class="button button--blue" form="invoice_change_number">Change Number</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div>
                <input type="checkbox" id="sendModal_show" autocomplete="off" class="modalToggle">
                <label class="modalCloser" for="sendModal_show"></label>
                <div class="modal">
                    <div class="modal__content">
                        <h2>Send</h2>

                        <form id="invoice_send" action="/invoices/104/send" method="post" onsubmit="disableSubmitters();" autocomplete="off">
                            <input type="hidden" name="csrf" value="7777d3f9-3d56-41ff-82b0-b6896fef5359">
                            <div class="float-right"><a href="/clients/24215" class="underline blue">Edit / Add Contacts</a></div>
                            <p>Ahmed</p>
                            <div class="clear"></div>


                            <hr class="hr">
                            <a href="/clients/24215">
                                <div class="m-v-md center">
                                    <!--                            <img width="16" height="16" src="img/icon_warning.svg">-->
                                    <div class="red m-b-sm bold">Warning</div>
                                    <div class="red m-b-md">This invoice won't be sent to anyone unless some contacts are added first.</div>
                                </div>
                            </a>
                            <hr class="hr">

                        </form>

                        <div class="flex m-t-md m-t-lg--tablet">
                            <form class="display--none" id="invoice_markAsSent" action="/invoices/104/send?soft" method="post" onsubmit="disableSubmitters();" autocomplete="off">
                                <input type="hidden" name="csrf" value="7777d3f9-3d56-41ff-82b0-b6896fef5359">
                            </form>
                            <button class="button button--blue-inverted" form="invoice_markAsSent">Mark as Sent</button>
                            <span class="flex__grow"></span>
                            <button class="button button--blue" form="invoice_send" id="invoice_send_button" disabled>Send</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const b = document.getElementById('invoice_send_button');
                const checkboxes = document.querySelectorAll('.sendModal__checkbox');

                function determineChecked() {
                    let checked = 0;
                    checkboxes.forEach(function (el) {
                        if (el.checked) checked++;
                    });
                    if (checked > 0) {
                        b.disabled = false;
                    } else {
                        b.disabled = true;
                    }
                }

                checkboxes.forEach(function (el) {
                    el.addEventListener('change', determineChecked);
                })
            </script>


        </div>

    </div>
@endsection
@section('script')
    <script>
        $("#clients").change(function () {
            $("#name").val($(this).find(':selected').data('name'))
            $("#num").val($(this).find(':selected').data('num'))
            $("#address").val($(this).find(':selected').data('address'))
            $("#cname").val($(this).find(':selected').data('cname'))
            $("#email").val($(this).find(':selected').data('email'))
            $("#phone").val($(this).find(':selected').data('phone'))
        })


        $("#invoice__submit").click(function(e) {
            if(!confirm('Are you sure you want to send this invoice.')) {
                e.stopPropagation();
                return false;
            }
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
    </script>
@endsection
