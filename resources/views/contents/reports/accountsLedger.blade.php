<x-app-layout>
    <div class="contents">
        <div class="row g-3 mb-3">
            <div class="col-lg-8">
              <div class="card ">
                <div class="card-header">
                  <h5 class="mb-0">{{__('translations.accountsReport')}}</h5>
                </div>
                <div class="card-body bg-light">
                    <form id="account_ledger" class="needs-validation" novalidate>
                        <!-- input fields-->
                        <div class="card-body bg-light">
                            <div class="row gx-2">
                                
                                <div class="col-sm-6 ">
                                    <label for="project_id">{{__('translations.plaza')}}</label>
                                    <select class="form-select " name="project_id" id="project_id" required>
                                        <option selected disabled>__{{__('translations.selectPlaza')}}__ </option>
                                        <option value="all">__All/همه__ </option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}">__{{$project->project_name}}__ </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{__('translations.selectPlaza')}}</div>
                                </div>
                                <div class="col-sm-6 ">
                                    <div class="row gx-1">
                                        <div class="col-sm-12">
                                            <label for="account_id" class="">{{__('translations.account')}}</label>
                                            <select class="form-select " size="1" name="account_id" id="account_id" required >
                                                @foreach($accounts as $account)
                                                <option value="{{$account->id}}">__{{$account->account_name}}__</option>
                                                @endforeach
                                                <option selected disabled>__{{__('translations.selectAccount')}}__ </option>
                                            </select>
                                        </div>
                                        <!--
                                        <div class="col-sm-5">
                                            <label for="crrency" class="">{{__('translations.currency')}}</label>
                                            <select class="form-select js-choice" id="account_currency" name="account_currency">
                                                <option value="AFN">__AFN__</option>
                                                <option value="USD">__USD__</option>
                                                <option value="all">__Both/هردو__ </option>
                                            </select>
                                        </div>
                                    -->
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row gx-3">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="start_date">{{__('translations.startDate')}}</label>
                                    <input class="form-control "  type="text" name="from_date" id="from_date" placeholder="{{__('translations.startDate')}}" data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
                                </div>
                                <div class="col-sm-6 mb-3 ">
                                    <label class="form-label" for="end_date">{{__('translations.endDate')}}</label>
                                    <input class="form-control " name="to_date" id="to_date"  type="text" placeholder="{{__('translations.endDate')}}" data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
                                </div>
                                <div class="col-sm-4 mb-3">
                                    
                                </div>
                                
                            </div>
                            <div class="float-end mt-5">
                                <button class="btn btn-primary me-1 mb-1" id="summary_report" type="button">{{__('translations.summaryReport')}}</button>
                                <button class="btn btn-primary me-1 mb-1" id="details_report" type="button">{{__('translations.detailsReport')}}</button>
                            </div>
                            <!-- 
                            <div class="float-end mt-5">
                                <button class="btn btn-primary me-1 mb-1" id="printInvoices" type="button">Print</button>
                            </div> -->
                        </div>
                    </form>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Info</h5>
                  </div>
                  <div class="card-body bg-light">
                    
                    <!-- Container for unpaid fees -->
                    <div id="total"></div>
                  </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3" >
            <div class="col-xxl-9 col-md-12">
                <div class="card z-index-1" id="runningProjectTable" data-list='{"valueNames":["#","project","description","cashIn","cashOut","currency","date"],}'>
                  <div class="card-header">
                    <div class="row flex-between-center">
                      
                      <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            
                            <button class="btn btn-falcon-default btn-sm dropdown-toggle" type="button" id="dropdown0" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                <span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span>
                                <span class="d-none d-sm-inline-block ms-1">{{__('translations.export')}}</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown0">
                                <p class="dropdown-item" id="export_to_pdf" >{{__('translations.pdf')}}</p>
                                <p class="dropdown-item" id="summary_report_pdf" >{{__('translations.summary')}}</p>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#!">{{__('translations.msexcel')}}</a>                    
                            </div>
                            </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body px-0 py-0">
                    <div class="table-responsive scrollbar" id="reports-table">
                        
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        flatpickr("#from_date", {
            enableTime: false,
        });
        flatpickr("#to_date", {
            enableTime: false,
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#details_report').click(function() {
                var formData = {
                    project_id: $('#project_id').val(),
                    account_id: $('#account_id').val(),
                    account_currency: $('#account_currency').val(),
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val(),
                    _token: '{{ csrf_token() }}'
                };
    
                $.ajax({
                    url: '{{ route("getAccountLedger") }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        generateTable(response.data, response.totals);
                        new List('runningProjectTable', {
                            valueNames: ['#', 'project', 'description', 'cashIn', 'cashOut', 'currency', 'date']
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            });
    
            function generateTable(data, totals) {
                var totalAmountAFN = totals.AFN.cash_in - totals.AFN.cash_out;
                var totalAmountUSD = totals.USD.cash_in - totals.USD.cash_out;
                
                var table = '<table class="table table-sm fs--1 mb-0 overflow-hidden table-running-project">'
                table +=            '<thead class="bg-200 text-900">'
                table +=                '<tr>'
                table +=                    '<th class="sort" data-sort="#">#</th>'
                table +=                        '<th class="sort text-center" data-sort="project">Project Name</th>'
                table +=                        '<th class="sort text-center" data-sort="description">Description</th>'
                table +=                        '<th class="sort text-center" data-sort="cashIn">Cash In</th>'
                table +=                        '<th class="sort text-center" data-sort="cashOut">Cash Out</th>'
                table +=                        '<th class="sort text-center" data-sort="currency">Currency</th>'
                table +=                        '<th class="sort text-center" data-sort="date">Date</th>'
                table +=                    '</tr>'
                table +=                '</thead>'
                table += '<tbody class="list">'
                            ;
    
                $.each(data, function(index, item) {
                        
                        table += '<tr>'
                        table +=    '<td class="#">' + (index + 1) + '</td>'
                        table +=    '<td class="text-center project">' + item.project_name + '</td>'
                        table +=    '<td class="text-center description">' + item.description + '</td>'
                        table +=    '<td class="text-center cashIn">' + item.cash_in + '</td>'
                        table +=    '<td class="text-center cashOut">' + item.cash_out + '</td>'
                        table +=    '<td class="text-center currency">' + item.currency + '</td>'
                        table +=    '<td class="text-center date">' + item.date + '</td>'
                        table +='</tr>';
                });
    
                table += '</tbody><tfoot>';
                table += '<tr><td colspan="3"></td><td class="text-center">Total Cash In AFN: ' + totals.AFN.cash_in + '</td><td class="text-center">Total Cash Out AFN: ' + totals.AFN.cash_out + '</td><td></td><td></td></tr>';
                table += '<tr><td colspan="3"></td><td class="text-center">Total Cash In USD: ' + totals.USD.cash_in + '</td><td class="text-center">Total Cash Out USD: ' + totals.USD.cash_out + '</td><td></td><td></td></tr>';
                table += '<tr><td colspan="3"></td><td class="text-center">Total Amount AFN: ' + totalAmountAFN + '</td><td class="text-center">Total Amount USD: ' + totalAmountUSD + '</td><td></td><td></td></tr>';
                table += '</tfoot></table>';
    
                $('#reports-table').html(table);
            }

            $('#export_to_pdf').click(function() {
                var formData = {
                    project_id: $('#project_id').val(),
                    account_id: $('#account_id').val(),
                    account_currency: $('#account_currency').val(),
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val(),
                    export_to_pdf : 'true',
                    _token: '{{ csrf_token() }}'
                };
    
                $.ajax({
                    url: '{{ route("getAccountLedger") }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        generateTable(response.data, response.totals);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#summary_report').click(function() {
                var formData = {
                    project_id: $('#project_id').val(),
                    account_id: $('#account_id').val(),
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: '{{ route("getAccountSummary") }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        generateSummaryTable(response.data);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            });

            function generateSummaryTable(data) {
                var table = '<table class="table table-sm fs--1 mb-0 overflow-hidden table-running-project">'
                table +=            '<thead class="bg-200 text-900">'
                table +=                '<tr>'
                table +=                    '<th class="sort" data-sort="#">#</th>'
                table +=                        '<th class="sort text-center" data-sort="account_name">Account Name</th>'
                table +=                        '<th class="sort text-center" data-sort="currency">Currency</th>'
                table +=                        '<th class="sort text-center" data-sort="opening_balance">Opening Balance</th>'
                table +=                        '<th class="sort text-center" data-sort="cash_in">Cash In</th>'
                table +=                        '<th class="sort text-center" data-sort="cash_out">Cash Out</th>'
                table +=                        '<th class="sort text-center" data-sort="closing_balance">Closing Balance</th>'
                table +=                    '</tr>'
                table +=                '</thead>'
                table += '<tbody class="list">'
                            ;

                $.each(data, function(index, item) {
                    $.each(item.balances, function(currency, balance) {
                        table += '<tr>'
                        table +=    '<td class="#">' + (index + 1) + '</td>'
                        table +=    '<td class="text-center account_name">' + item.account_name + '</td>'
                        table +=    '<td class="text-center currency">' + currency + '</td>'
                        table +=    '<td class="text-center opening_balance">' + balance.opening_balance + '</td>'
                        table +=    '<td class="text-center cash_in">' + balance.cash_in + '</td>'
                        table +=    '<td class="text-center cash_out">' + balance.cash_out + '</td>'
                        table +=    '<td class="text-center closing_balance">' + balance.closing_balance + '</td>'
                        table +='</tr>';
                    });
                });

                table += '</tbody></table>';

                $('#reports-table').html(table);
            }

            $('#summary_report_pdf').click(function() {
                var formData = {
                    project_id: $('#project_id').val(),
                    account_id: $('#account_id').val(),
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: '{{ route("getAccountSummaryPDF") }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        // Handle the response
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            });
        });

        
    </script>

</x-app-layout>