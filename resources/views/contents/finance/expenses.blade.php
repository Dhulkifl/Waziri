<x-app-layout>
    <div class="contents">
      <div class="row g-3 mb-3">
        <div class="col-lg-8">
          <div class="card h-100">
            <div class="card-header">
              <h5 class="mb-0">{{__('translations.expenses')}}</h5>
            </div>
            <div class="card-body bg-light">
              <!-- Project selection -->
              <div class="row gx-2 mb-3">
                <div class="col-sm-6 mb-3">
                  <label for="project_id" class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1">{{__('translations.plaza')}}</label>
                  <select class="form-select " size="1" name="project_id" id="project_id" required >
                    <option disabled selected>__{{__('translations.selectPlaza')}}__</option>
                    @foreach($projects as $project)
                      <option value="{{$project->id}}">__{{$project->project_name}}__</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback">{{__('translations.selectPlaza')}}</div>
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="project_id" class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1">{{__('translations.account')}}</label>
                  <select class="form-select " size="1" name="account_id" id="account_id" required >
                    <option disabled selected>__{{__('translations.selectAccount')}}__</option>
                    @foreach($expenses as $expense)
                        <option value="{{$expense->id}}">__{{$expense->account_name}}__</option>
                    @endforeach
                  </select>
                  <div class="invalid-feedback"></div>
                </div>
                
                <div class="col-6 col-sm-6 mb-3">
                    <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="">{{__('translations.amount')}}</label>
                    <div class="row gx-1">
                        <div class="col-sm-7">
                            <input class="form-control" id="expense_amount" name="expense_amount" placeholder="{{__('translations.amount')}}" type="text" value="" required />
                        </div>
                        <div class="col-sm-5">
                            <select class="form-select" name="expense_currency" id="expense_currency" name="currencies">
                                <option value="AFN">AFN</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 mb-3">
                    <label class="form-label" for="descrition">{{__('translations.description')}}</label>
                    <textarea class="form-control" id="expense_descrtiption" name="expense_desctiption" rows="3" placeholder="{{__('translations.description')}}"></textarea>
                </div>

              </div>
    
              
              <div class="row gx-3" id="fee-inputs"></div>
                <div class="float-end">
                  <button class="btn btn-primary me-1 mb-1" id="save_payment" type="button">{{__('translations.save')}}</button>
                </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card h-100">
            <div class="card-header">
              <h5 class="mb-0">Account Balance</h5>
            </div>
            <div class="card-body bg-light" id="balances">
              <button class="btn btn-primary d-block w-100" type="button" >
                <span class=" me-2"></span>View Balance
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <script>
        $(document).on('click', '#save_payment', function() {
            var projectId = $('#project_id').val();
            var accountId = $('#account_id').val();
            var amount = $('#expense_amount').val();
            var currency = $('#expense_currency').val();
            var description = $('#expense_descrtiption').val();

            $.ajax({
                url: '/saveExpense', // Adjust this URL to your route
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token
                    project_id: projectId,
                    account_id: accountId,
                    amount: amount,
                    currency: currency,
                    description: description
                },
                success: function(response) {
                    alert('Transaction saved successfully!');
                },
                error: function() {
                    alert('Error saving transaction.');
                }
            });
        });
    </script>
  </x-app-layout>