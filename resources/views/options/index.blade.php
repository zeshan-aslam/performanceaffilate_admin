@extends('layouts.masterClone')

@section('title', 'Options')


@section('content')
    <h1 class="page-title">Options</h1>

    <div class="row-fluid">
        <input name="_token" id="token" value="{{ csrf_token() }}" type="hidden">
        <div class="card">

            <div class="tabbable custom-tab tabs-left">
                <ul class="nav nav-tabs tabs-left" id="myTab">
                    <li><a data-toggle="tab" href="#profile">Admin Settings</a></li>
                    <li><a data-toggle="tab" href="#GateWay">GateWay</a></li>
                    <li><a data-toggle="tab" href="#SetPayment">Set Payment</a></li>
                    <li><a data-toggle="tab" href="#AffiliatesGeneric">Affiliates T&C</a></li>
                    <li><a data-toggle="tab" href="#MerchantGeneric">Merchant T&C</a></li>
                    <li><a data-toggle="tab" href="#AddorRemove">Categories</a></li>
                    <li><a data-toggle="tab" href="#EmailSetup">Email Setup</a></li>
                    <li><a data-toggle="tab" href="#AdminMail">Admin Mail</a></li>
                    <li><a data-toggle="tab" href="#BulkMail">Bulk Mail</a></li>
                    <li><a data-toggle="tab" href="#EventsEnabled">Events </a></li>


                    <li><a data-toggle="tab" href="#Languages">Languages</a></li>
                    <li><a data-toggle="tab" href="#Currencies">Currencies</a></li>
                    <li><a data-toggle="tab" href="#IPCountry">IP-Country DB</a></li>
                    <li><a data-toggle="tab" href="#Backup">Back Up</a></li>
                    <li><a data-toggle="tab" href="#FraudSettings">Fraud Settings</a></li>
                    <li><a data-toggle="tab" href="#AdminUsers">Admin Users</a></li>
                    <li><a data-toggle="tab" href="#AffiliateGroupMang">Groups</a></li>
                    <li><a data-toggle="tab" href="#wizardServiceSetting">wizardServiceSetting</a></li>


                </ul>
                <div class="tab-content ml-5" id="myTabContent">

                    <div id="profile" class="tab-pane fade active in">
                        @include('options.optionAdmin')
                    </div>

                    <div id="GateWay" class="tab-pane fade">
                        @include('options.gateway')
                    </div>

                    <div id="SetPayment" class="tab-pane fade">
                        @include('options.setpayment')
                    </div>

                    <div id="AffiliatesGeneric" class="tab-pane fade">
                        @include('options.AffiliateGeneric')
                    </div>

                    <div id="MerchantGeneric" class="tab-pane fade">
                        @include('options.MerchantGeneric')
                    </div>
                    <div id="AddorRemove" class="tab-pane fade">
                        @include('options.catagory')
                    </div>
                    <div id="EmailSetup" class="tab-pane fade">
                        @include('options.EmailSetup')
                    </div>
                    <div id="EventsEnabled" class="tab-pane fade">
                        @include('options.EventEnabled')
                    </div>
                    <div id="AdminMail" class="tab-pane fade">
                        @include('options.AdminMail')
                    </div>
                    <div id="BulkMail" class="tab-pane fade">
                        @include('options.BulkMail')
                    </div>
                    <div id="Languages" class="tab-pane fade">
                        @include('options.language')
                    </div>
                    <div id="Currencies" class="tab-pane fade">
                        @include('options.Currencies')
                    </div>
                    <div id="IPCountry" class="tab-pane fade">
                        @include('options.IPCountry')
                    </div>
                    <div id="Backup" class="tab-pane fade">
                        @include('options.backup')
                    </div>
                    <div id="FraudSettings" class="tab-pane fade">
                        @include('options.FraudSettings')
                    </div>
                    <div id="AdminUsers" class="tab-pane fade">
                        @include('options.AdminUsers')
                    </div>
                    <div id="AffiliateGroupMang" class="tab-pane fade">
                        @include('options.AffiliateGroupMang')
                    </div>
                    <div id="wizardServiceSetting" class="tab-pane fade">
                        @include('options.wizardServiceSetting')
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
@section('script')
    <script>
        var successSound = new Audio("{{ asset('audio/success.mp3') }}");
        var errorSound = new Audio("{{ asset('audio/error.mp3') }}");
        var warningSound = new Audio("{{ asset('audio/warning.wav') }}");
        // option File URLs
        var updateEmailURL = "{{ url('Options/UpdateUserEmail') }}";
        var updateUserNameURL = "{{ url('Options/UpdateUserName') }}";
        var updateUserPasswordURL = "{{ url('Options/UpdateUserPassword') }}";
        var updateSiteInfoURL = "{{ url('Options/UpdateSiteInfo') }}";
        var updateSiteErrorURL = "{{ url('Options/UpdateSiteError') }}";
        // Getways File URLs
        var getPaymentGatewaysURL = "{{ url('Options/GetPaymentGateways') }}";
        var updateGatewayURL = "{{ url('Options/UpdateGateway') }}";
        // affiliateTerms File URLs
        var UpdateAffiliateTermsURL = "{{ url('Options/UpdateAffiliateTerms') }}";
        // merchantTerms File URLs
        var UpdateMerchantTermsURL = "{{ url('Options/UpdateMerchantTerms') }}";
        // adminMail File URLs
        var GetAdminMailOptionsURL = "{{ url('Options/GetAdminMailOptions') }}";
        var UpdateAdminMailOptionsURL = "{{ url('Options/UpdateAdminMailOptions') }}";
        var UpdateAdminAmountURL = "{{ url('Options/UpdateAdminAmount') }}";
        // catagory File URLs
        var GetcatagoriesURL = "{{ url('Options/Getcatagories') }}";
        var InsertCatagoryURL = "{{ url('Options/InsertCatagory') }}";
        var DeleteCatagoryURL = "{{ url('Options/DeleteCatagory') }}";
        // merchantEvents File URLs
        var GetMerchantEventsURL = "{{ url('Options/GetMerchantEvents') }}";
        // setPayments File URLs
        var UpdatePaymentsURL = "{{ url('Options/UpdatePayments') }}";
        // languages File URLs
        var GetSiteLanguagesURL = "{{ url('Options/GetSiteLanguages') }}";
        var EditLanguageURL = "{{ url('Options/EditLanguage') }}";
        var AddLanguageURL = "{{ url('Options/AddLanguage') }}";
        var UpdateLanguageURL = "{{ url('Options/UpdateLanguage') }}";
        var DeleteLanguageURL = "{{ url('Options/DeleteLanguage') }}";
        // currency File URLs
        var GetCurrenciesURL = "{{ url('Options/GetCurrencies') }}";
        var AddCurrencyURL = "{{ url('Options/AddCurrency') }}";
        var UpdateCurrencyURL = "{{ url('Options/UpdateCurrency') }}";
        var DeleteCurrencyURL = "{{ url('Options/DeleteCurrency') }}";
        var ChangeCurrencyURL = "{{ url('Options/ChangeCurrency') }}";
        // fraudSetting File URLs
        var UpdateFraudSettingURL = "{{ url('Options/UpdateFraudSetting') }}";
        // emailSetup File URLs
        var UpdateMailSetupURL = "{{ url('Options/UpdateMailSetup') }}";
        var GetMailSetupURL = "{{ url('Options/GetMailSetup') }}";
        var FillEventsMailSetupURL = "{{ url('Options/FillEventsMailSetup') }}";
        var SendBulkMailURL = "{{ url('Options/SendBulkMail') }}";
        // bulkMail File URLs
        var GetMailListURL = "{{ url('Options/GetMailList') }}";
        // adminuser File URLs
        var insertAdminuserURL = "{{ url('Options/insertAdminuser') }}";
        var UserAdmintableURL = "{{ url('Options/UserAdmintable') }}";
        var updateAdminURL = "{{ url('Options/updateAdmin') }}";
        var checkboxPrivilegesURL = "{{ url('Options/checkboxPrivileges') }}";
        var ShowAdminURL = "{{ url('Options/ShowAdmin') }}";
        var DeleteAdminURL = "{{ url('Options/DeleteAdmin') }}";
        // Priviliges File URLs
        var privilegesURL = "{{ url('Options/privileges') }}";
        // affiliategroupMang File URLs
        var affiliategroupURL = "{{ url('Options/affiliategroup') }}";
        var getAffgroupURL = "{{ url('Options/getAffgroup') }}";
        var updateAffgroupURL = "{{ url('Options/updateAffgroup') }}";
        var ShowAffgroupURL = "{{ url('Options/ShowAffgroup') }}";
        var OptionsURL = "{{ url('Options/') }}";
        var getGroupDetailsURL = "{{ url('Options/getGroupDetails') }}";
        // IPCountry File URLs
        var IPcountryURL = "{{ url('Options/IPcountry') }}";
        var EditIPgetURL = "{{ url('Options/EditIPget') }}";
        var EditIPURL = "{{ url('Options/EditIP') }}";
        var ShowAffgroupURL = "{{ url('Options/ShowAffgroup') }}";
        var ShowIPURL = "{{ url('Options/ShowIP') }}";
        var DeleteIPURL = "{{ url('Options/DeleteIP') }}";
        var BackupURL = "{{ url('Backup') }}";
        // Wizard Service Content URLs By RANA
        var UpdateWizardServiceContentURL = "{{ url('Options/UpdateWizardServiceContent') }}";
        var GETWizardAccountTypeURL = "{{ url('Options/GETWizardAccountType') }}";
        var ADDWizardAccountTypeURL = "{{ url('Options/ADDWizardAccountType') }}";
    </script>
@endsection
@section('scripts')
    <script src="{{ asset('js/options/options.js') }}"></script>
    <script src="{{ asset('js/options/gateways.js') }}"></script>
    <script src="{{ asset('js/options/affiliateTerms.js') }}"></script>
    <script src="{{ asset('js/options/merchantTerms.js') }}"></script>
    <script src="{{ asset('js/options/adminMail.js') }}"></script>
    <script src="{{ asset('js/options/catagory.js') }}"></script>
    <script src="{{ asset('js/options/merchantEvents.js') }}"></script>
    <script src="{{ asset('js/options/setPayments.js') }}"></script>
    <script src="{{ asset('js/options/languages.js') }}"></script>
    <script src="{{ asset('js/options/currency.js') }}"></script>
    <script src="{{ asset('js/options/fraudSetting.js') }}"></script>
    <script src="{{ asset('js/options/emailSetup.js') }}"></script>
    <script src="{{ asset('js/options/bulkMail.js') }}"></script>
    <script src="{{ asset('js/options/adminuser.js') }}"></script>
    <script src="{{ asset('js/options/affiliategroupMang.js') }}"></script>
    <script src="{{ asset('js/options/IPCountry.js') }}"></script>
    {{-- Wizard Service JS files By RANA --}}
    <script>
        // CKEDITOR.replace('wizardContentHeader');
        // CKEDITOR.instances.editor.updateElement();
        CKEDITOR.replace('wizardContentBody');
        // CKEDITOR.replace('wizardContentFooter');
    </script>
    <script src="{{ asset('js/options/wizardServiceSetting.js') }}"></script>

@endsection
