<x-app-layout>

    <div class="content">
        <div class="row g-3">
            <div class="col-xxl-9">
                <div class="card rounded-3 overflow-hidden h-100">
                    <div class="card-body bg-line-chart-gradient d-flex flex-column justify-content-between">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class="text-white mb-0">Today $764.39</h4>
                            <p class="fs--1 fw-semi-bold text-white">Yesterday <span class="opacity-50">$684.87</span></p>
                        </div>
                        <div class="col-auto d-none d-sm-block"><select class="form-select form-select-sm mb-3" id="dashboard-chart-select">
                            <option value="all">All Payments</option>
                            <option value="successful" selected="selected">Successful Payments</option>
                            <option value="failed">Failed Payments</option>
                        </select></div>
                    </div><!-- Find the JS file for the following calendar at: src/js/charts/echarts/line-payment.js-->
                    <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                    <div class="echart-line-payment" style="height:200px" data-echart-responsive="true"></div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="row g-2">
                    <div class="col-md-4 col-xxl-12">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-2.png);"></div>

                            <div class="card-body">
                                <div class="row flex-between-center g-0">
                                    <div class="col-6 d-lg-block flex-between-center">
                                        <h6 class="mb-2 text-900 fs-0">{{__('translations.balance')}} ({{__('translations.afn')}})</h6>
                                        <h6 class="fs-3 fw-normal text-primary mb-0" data-countup='{"endValue":{{$assetsAFN}},"decimalPlaces":0,"suffix":" AFN","prefix":""}'>{{$assetsAFN}} AFN</h6>
                                    </div>
                                    <div class="col-6 d-lg-block flex-between-center">
                                        <h6 class="mb-2 text-900 fs-0">{{__('translations.balance')}} ({{__('translations.usd')}})</h6>
                                        <h6 class="fs-3 fw-normal text-primary mb-0" data-countup='{"endValue":{{$assetsUSD}},"decimalPlaces":0,"suffix":" USD","prefix":""}'>{{$assetsUSD}} USD</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-xxl-12">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);"></div>

                            <div class="card-body">
                                <div class="row flex-between-center">
                                    <div class="col-6 d-lg-block flex-between-center">
                                        <h6 class="mb-2 text-900 fs-0">{{__('translations.expense')}} ({{__('translations.afn')}})</h6>
                                        <h6 class="fs-3 fw-normal text-danger mb-0" data-countup='{"endValue":{{$expenseDebitAFN}},"decimalPlaces":0,"suffix":" AFN","prefix":""}'>{{$expenseDebitAFN}} AFN</h6>
                                    </div>
                                    <div class="col-6 d-lg-block flex-between-center">
                                        <h6 class="mb-2 text-900 fs-0">{{__('translations.expense')}} ({{__('translations.usd')}})</h6>
                                        <h6 class="fs-3 fw-normal text-danger mb-0" data-countup='{"endValue":{{$expenseDebitUSD}},"decimalPlaces":0,"suffix":" USD","prefix":""}'>{{$expenseDebitUSD}} USD</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xxl-12">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-4.png);"></div>

                            <div class="card-body">
                                <div class="row flex-between-center">
                                    <div class="col-6 d-lg-block flex-between-center">
                                        <h6 class="mb-2 text-900 fs-0">{{__('translations.income')}} ({{__('translations.afn')}})</h6>
                                        <h6 class="fs-3 fw-normal text-success mb-0" data-countup='{"endValue":{{$incomeCreditAFN}},"decimalPlaces":0,"suffix":" AFN","prefix":""}'>{{$incomeCreditAFN}} AFN</h6>
                                    </div>
                                    <div class="col-6 d-lg-block flex-between-center">
                                        <h6 class="mb-2 text-900 fs-0">{{__('translations.income')}} ({{__('translations.usd')}})</h6>
                                        <h6 class="fs-3 fw-normal text-success mb-0" data-countup='{"endValue":{{$incomeCreditUSD}},"decimalPlaces":0,"suffix":" USD","prefix":""}'>{{$incomeCreditUSD}} USD</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-xxl-9">
            <div class="card bg-light">
                
            </div>
            <div class="row gx-2 ">
                
                <div class="col-sm-12 col-md-12 row gx-2 gy-1">
                    
                    <div class="col-sm-6 col-md-3">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6 class="fs-0">{{__('translations.totalInvoices')}} ({{__('translations.afn')}})<span class="badge badge-soft-warning rounded-pill ms-2 fs--2">{{__('translations.currentMonth')}}</span></h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                                    data-countup='{"endValue":{{$totalInvoicesAFN}},"decimalPlaces":0,"suffix":" AFN"}'>
                                    {{$totalInvoicesAFN}} AFN
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6 class="fs-0"> {{__('translations.paid')}} ({{__('translations.afn')}})<span class="badge badge-soft-success rounded-pill ms-1 fs--2">{{__('translations.currentMonth')}}</span></h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-success" 
                                    data-countup='{"endValue":{{$totalPaidAmountAFN}},"decimalPlaces":0,"suffix":" AFN"}'>
                                    {{$totalPaidAmountAFN}} AFN
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6 class="fs-0">{{__('translations.discount')}} ({{__('translations.afn')}})<span class="badge badge-soft-warning rounded-pill ms-2 fs--2">{{__('translations.currentMonth')}}</span></h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                                    data-countup='{"endValue":{{$totalDiscountAFN}},"decimalPlaces":0,"suffix":" AFN"}'>
                                    {{$totalDiscountAFN}} AFN
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-2.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6 class="fs-0"> {{__('translations.balance')}} ({{__('translations.afn')}})<span class="badge badge-soft-info rounded-pill ms-2 fs--2">{{__('translations.currentMonth')}}</span></h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" 
                                    data-countup='{"endValue":{{$totalBalanceAFN}},"decimalPlaces":0,"suffix":" AFN"}'>
                                    {{$totalBalanceAFN}} AFN
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-3">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6 class="fs-0">{{__('translations.totalInvoices')}} ({{__('translations.usd')}})<span class="badge badge-soft-warning rounded-pill ms-2 fs--2">{{__('translations.currentMonth')}}</span></h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                                    data-countup='{"endValue":{{$totalInvoicesUSD}},"decimalPlaces":0,"suffix":" USD"}'>
                                    {{$totalInvoicesUSD}} USD
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6 class="fs-0"> {{__('translations.paid')}} ({{__('translations.usd')}}) <span class="badge badge-soft-success rounded-pill ms-2 fs--2">{{__('translations.currentMonth')}}</span></h6>

                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-success" 
                                    data-countup='{"endValue":{{$totalPaidAmountUSD}},"decimalPlaces":0,"suffix":" USD"}'>
                                    {{$totalPaidAmountUSD}} USD
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6 class="fs-0">{{__('translations.discount')}} ({{__('translations.usd')}})<span class="badge badge-soft-warning rounded-pill ms-2 fs--2">{{__('translations.currentMonth')}}</span></h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" 
                                    data-countup='{"endValue":{{$totalDiscountUSD}},"decimalPlaces":0,"suffix":" USD"}'>
                                    {{$totalDiscountUSD}} USD
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-2.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6 class="fs-0"> {{__('translations.balance')}} (USD)<span class="badge badge-soft-info rounded-pill ms-2 fs--2">{{__('translations.currentMonth')}}</span></h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" 
                                    data-countup='{"endValue":{{$totalBalanceUSD}},"decimalPlaces":0,"suffix":" USD"}'>
                                    {{$totalBalanceUSD}} USD
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-4 row gx-2 my-1 gy-1">

                        <div class="col-sm-6 col-md-6">
                            <div class="card overflow-hidden" style="min-width: 8rem">
                                <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-2.png);"></div>
                                <!--/.bg-holder-->
                                <div class="card-body position-relative">
                                    <h6 class="fs-0">{{__('translations.total')}} {{__('translations.apartments')}}</h6>
                                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" 
                                        data-countup='{"endValue":{{$totalApartments}},"decimalPlaces":0}'>
                                        {{$totalApartments}}
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-md-6">
                            <div class="card overflow-hidden" style="min-width: 8rem">
                                <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);"></div>
                                <!--/.bg-holder-->
                                <div class="card-body position-relative">
                                    <h6 class="fs-0">{{__('translations.total')}} {{__('paths.shops')}}</h6>
                                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-success" 
                                        data-countup='{"endValue":{{$totalShops}},"decimalPlaces":0}'>
                                        {{$totalShops}}
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>
            
            </div>
        </div>
    </div>
      <!-- ===============================================-->
      <!--    End of Main Content-->
      <!-- ===============================================-->
</x-app-layout>
