@extends('dashboard',['a' => 'View Invoice'])
@section('body')
    <div class="row">
        <div class="app">

            <div class="flex flex--wrap flex--justify-space-between m-v-md m-v-lg--tablet m-v-xl--desktop" id="invoice__buttons">


                <a href="javascript:window.print()" >
                    <div class="button button--blue-inverted m-v-sm">
                        <!--                <img src="img/icon_file_sm.svg" width="10" height="10" alt="file" class="m-r-sm">-->
                        <span>Print</span>
                    </div>
                </a>


                <div style="flex: 1 0 10px;"></div>
                @if(!$invoice->final)

                <button form="invoice__delete" class="invoice__deleteImageFlip button button--blue-inverted button--red-inverted-hover m-v-sm">
                    <!--            <img src="img/icon_delete_sm_blue.svg" width="10" height="10" alt="x" class="m-r-sm">-->
                    <!--            <img src="img/icon_delete_sm_red.svg" width="10" height="10" alt="x" class="m-r-sm display&#45;&#45;none">-->
                    <span>Delete</span>
                </button>
                <form class="display--none" id="invoice__delete" action="/delete_invoice_{{$invoice->id}}" method="post" onsubmit="invoiceDeletePrompt(event);" autocomplete="off">
                    {{csrf_field()}}
                    <input type="hidden" name="csrf" value="7777d3f9-3d56-41ff-82b0-b6896fef5359">
                </form>
                @endif
            </div>

            <div id="invoice" method="post" class="card bg-white display--block m-t-md m-t-lg--tablet m-t-xl--desktop m-b-md m-b-lg--tablet" onsubmit="disableSubmitters();">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$invoice->id}}">
                <div class="invoice__titles m-v-md m-v-lg--tablet">
{{--
                    <div class="row">
                        @if($invoice->logo)
                            <div class="col-lg-6">
                                <img src="{{url('/images/user/'.$invoice->logo)}}" alt="Image placeholder" class="card-img-top">
                            </div>
                        @endif
                    </div>
--}}
                    <div class="m-v-md m-v-lg--tablet">
                        <input type="text" name="invoice_num" placeholder="" value="{{$invoice->data->invoice_num}}" class="font-size--header blue ">
                    </div>

                    <div>
                        <input id="invoice__description" class="invoice__description invoice__description--input inputBorder p-sm ellipsis" type="text" name="description" value="{{$invoice->data->description}}" placeholder="Project / Description" maxlength="255" autocomplete="off"
                               onkeypress="disableEnterSubmit(event);">
                    </div>

                </div>

                <div class="invoice__dates m-v-lg">
                    <div class="m-v-md">

                        <div class="gray m-r-sm display--inline--tablet">Issued</div>
                        <input id="invoice__dateIssued" class="inputBorder p-sm" name="date_issued" type="date" placeholder="yyyy-mm-dd" value="{{$invoice->data->date_issued ? $invoice->data->date_issued : date('Y-m-d')}}" autocomplete="off" required onkeypress="disableEnterSubmit(event);"
                               class="display--block display--inline--tablet">

                    </div>


                    <div class="m-v-md">
                        <div class="gray m-r-sm display--inline--tablet">Due</div>
                        <input id="invoice__dateDue" class="inputBorder p-sm" name="date_due" value="{{$invoice->data->date_due ? $invoice->data->date_due : date('Y-m-d')}}" type="date" placeholder="yyyy-mm-dd" autocomplete="off" onkeypress="disableEnterSubmit(event);">
                    </div>

                </div>

                <div class="clear"></div>


                <div class="flex flex--start">

                    <div class="m-v-md m-v-lg--tablet">
{{--                        <label for="">Company Name</label>--}}
                        <input type="text" id="name"  name="client" placeholder="Company Name" value="{{$invoice->data->client}}" class="">
                    </div>
                </div>
                <div class="flex flex--start">

                    <div class="m-v-md m-v-lg--tablet">
{{--                        <label for="">Registration Number</label>--}}

                        <input type="text"  id="num" name="reg_num" placeholder="Registration Number" value="{{$invoice->data->reg_num}}" class="">
                    </div>
                </div>
                <div class="flex flex--start">

                    <div class="m-v-md m-v-lg--tablet">
{{--                        <label for="">Billing Address</label>--}}

                        <input type="text" id="address"  name="address" placeholder="Billing Address" value="{{$invoice->data->address}}" class="">
                    </div>
                </div>
                <div class="flex flex--start">

                    <div class="m-v-md m-v-lg--tablet">
{{--                        <label for="">Contact Name</label>--}}

                        <input type="text" id="cname"  name="contact" placeholder="Contact Name" value="{{$invoice->data->contact}}" class="">
                    </div>
                </div>
                <div class="flex flex--start">

                    <div class="m-v-md m-v-lg--tablet">
{{--                        <label for="">Company Email</label>--}}

                        <input type="text"  id="email" name="email" placeholder="Email" value="{{$invoice->data->email}}" class="">
                    </div>
                </div>
                <div class="flex flex--start">

                    <div class="m-v-md m-v-lg--tablet">
{{--                        <label for="">Company Phone</label>--}}

                        <input type="text"  id="phone" name="phone" placeholder="Phone"  value="{{$invoice->data->phone}}" class="">
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
                <div>
                    <?php
                    ?>
                    <script>  expenseData = [
                        ];
                         </script>
                    @if(isset($invoice->data->tax1percent) )
                        <script>
                            tax1Data = {
                                percent: "{{$invoice->data->tax1percent }}",
                                description: "{{$invoice->data->tax1description}}",
                            };</script>
                    @endif
                    @foreach($invoice->data->exp_desc as $desc)
                        <script>
                            expenseData.push({
                                description: "{{$desc}}",
                                quantity: "{{$invoice->data->exp_quan[$loop->index]}}",
                                value: "{{$invoice->data->exp_val[$loop->index]}}"
                                },
                            )
                        </script>
                    @endforeach

                </div>

                <div id="expenses">

                </div>

                <div class="clear"></div>

                <div class="m-v-md m-v-lg--tablet">

                    <textarea id="invoice__notes" name="notes"  class="textarea--v p-sm borderBox fullWidth" placeholder="Notes..." autocomplete="off" maxlength="2000" oninput="autosizeTextarea.bind(this, event)();">{{$invoice->data->notes}}</textarea>

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


                    <div class="flex__grow details__gutter" style="display: none">

                        <div class="details__column flex__basis0 flex__grow flex flex--baseline invoice__submitContainer">
                            <input type="reset" id="invoice__cancelSubmit" class="button button--gray-inverted gray display--none m-r-md invoice_submit_button" value="Cancel">
                            <div class="flex__grow"></div>
                            <button id="invoice_ubmit" class="button button--blue right invoice_submit_button" name="submit" value="draft" form="invoice" type="submit">Save as draft</button>
                            <button id="invoice__submit" class="button button--blue right invoice_submit_button"  name="submit" value="send" form="invoice" type="submit">Send to Spacedive</button>
                        </div>

                    </div>


                </section>

            </div>

            <section id="invoice__details" class="flex flex--wrap flex--justify-space-between">
                <div class="details__column flex__grow flex__basis0 m-b-lg">
                    <div class="details__sendArea p-md m-b-lg">
                        <div class="flex flex--center">

                <span class="flex__grow">
                    <span>Draft</span>
                    <!--                    <img class="crisp m-l-sm" src="img/icon_lock.svg">-->
                </span>
                            {{--                        <label class="button button--blue m-l-md" for="sendModal_show">Send</label>--}}

                        </div>


                    </div>
                </div>

                <div class="details__gutter"></div>
                {{--<div class="details__column flex__grow flex__basis0 m-b-lg bg-almost-white">
                    <label for="payment_showCreateForm" class="pointer">
                        <div class="flex m-b-sm">
                            <span class="flex__grow gray">Payments</span>
                            <img src="img/icon_add.svg" class="crisp">
                        </div>
                    </label>
                    <hr/>
                    <ul class="payments__list position--relative">
                        <input type="checkbox" id="payment_showCreateForm" class="display--none" autocomplete="off">

                        <li class="payment payment--form p-v-sm">
                            <form method="post" action="/invoices/104/payments" class="flex" onsubmit="disableSubmitters(); handlePaymentSubmit(event);" autocomplete="off">
                                <input type="hidden" name="csrf" value="7777d3f9-3d56-41ff-82b0-b6896fef5359">
                                <input id="payment__input" type="number" min="0" max="99999999" step="0.01" placeholder="Amount" class="font-mono flex__grow" name="value" autocomplete="off" inputmode="numeric">
                                <input type="date" name="date" autocomplete="off" placeholder="yyyy-mm-dd">
                                <button class="button button--blue">Add</button>
                            </form>
                        </li>

                    </ul>
                    <div class="flex m-v-md">

                        <span class="flex__grow right gray">No payments posted</span>

                    </div>
                </div>--}}
            </section>


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


        </div>
    </div>
@endsection
