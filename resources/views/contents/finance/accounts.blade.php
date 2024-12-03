<x-app-layout>
    <div class="contents">
        <main class="main" id="top">
            <div class="container-fluid">
              <div class="row min-vh-50 ">
                <div class="col-7 order-xxl-3">
                    <div class="card" id="runningProjectTable" data-list='{"valueNames":["#","accounts","types","openings","descriptions"]}'>
                      <div class="card-header">
                        <h6 class="mb-0">{{__('translations.accounts')}}</h6>
                      </div>
                      <div class="card-body p-0">
                        <div class="scrollbar">
                          <table class="table mb-0 table-borderless fs--2 border-200 overflow-hidden table-running-project">
                            <thead class="bg-light">
                              <tr class="text-800" >
                                <th class="sort" data-sort="#">#</th>
                                <th class="sort" data-sort="accounts">{{__('translations.account')}}</th>
                                <th class="sort" data-sort="types">{{__('translations.type')}}</th>
                                <th class="sort text-center" data-sort="openings">{{__('translations.openingBalance')}}</th>
                                <th class="sort text-center" data-sort="descriptions"> {{__('translations.description')}}</th>
                                <th class="sort text-center" ></th>
                              </tr>
                            </thead>
                            <tbody id="bodyAccounts" class="list">
                                @foreach($accounts as $account)
                                    @if($account->account_type != "Assets")
                                        <tr>
                                            <td class="align-middle">
                                                <p class="fs--1 mb-0 fw-semi-bold #">{{$count++}}</p>
                                            </td>

                                            <td class="align-middle" account_name="{{$account->account_name}}">
                                                <span class="fs--1 mb-0  fw-semi-bold text-900 accounts" >{{$account->account_name}}</span>
                                            </td>

                                            <td class="align-middle" account_type="{{$account->account_type}}">
                                                <span class="fs--1 mb-0  fw-semi-bold text-900 types" >
                                                    @if($account->account_type == "Expense/Salary")
                                                        {{((__('translations.expense')))}}/{{((__('translations.salary')))}}
                                                    @elseif($account->account_type == "Income/Fees")
                                                        {{((__('translations.incomeFees')))}}
                                                    @elseif($account->account_type == "Expense")
                                                        {{((__('translations.expense')))}}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="align-middle text-center" opening_balance="{{$account->opening_balance}}">
                                                <span class="fs--1 mb-0  fw-semi-bold text-900 openings" >{{$account->opening_balance}}</span>
                                            </td>

                                            <td class="align-middle text-center" description="{{$account->description}}">
                                                <span class="fs--1 mb-0 fw-semi-bold text-900 descriptions" >{{$account->description}}</span>
                                            </td>
                                            <td class="align-middle text-center" account_id="{{$account->id}}">
                                                <span class="fs--1 mb-0 fw-semi-bold  far fa-edit fs-2 text-warning edit_account" ></span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-5 px-sm-0 align-self-left mx-auto py-1">
                  <div class="row justify-content-center g-0">
                    <div class="col-lg-12 col-xl-9 col-xxl-6">
                      <div class="card">
                        <div class="card-header bg-circle-shape bg-shape text-center p-2"><a class="font-sans-serif fw-bolder fs-4 z-index-1 position-relative link-light light">{{__('translations.newAccount')}}</a></div>
                        <div class="card-body p-4">
                          <form class="needs-validation" novalidate>
                            <input type="hidden" name="account_id" id="account_id" value="">
                            <div class="mb-3">
                                <label class="form-label" for="split-name">{{__('translations.accountName')}}</label>
                                <input class="form-control" id="account_name" type="text" name="account_name" autocomplete="on"  required/>
                            </div>
                            
                            <div class=" mb-3">
                                <label for="statusSelect">{{__('translations.accountType')}}</label>
                                <select class="form-select" id="account_type" name="account_type" required>
                                    <option value="Income/Fees">{{__('translations.incomeFees')}}</option>
                                    <option value="Expense">{{__('translations.expense')}}</option>
                                    <option value="Expense/Salary">{{__('translations.expense')}}/{{__('translations.salary')}}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="split-name">{{__('translations.openingBalance')}} </label>
                                <input class="form-control" type="text" id="opening_balance" value="0" name="opening_balance" autocomplete="on"  />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="split-name">{{__('translations.description')}}</label>
                                <input class="form-control" type="text" id="description" value=" " name="description" autocomplete="on"  />
                            </div>
                            <input type="hidden" id="save_type" value="new">

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" id="submit" type="button">{{__('translations.save')}}</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </main>
    </div>
</x-app-layout>

<script>
    $(document).ready(function(){
        $(document).on('click', '#submit', function(){
            
            if ($("#account_name").val() == "") {
                
            }else{
                saveAccount();
            }
        });
        function saveAccount(){
            var account_id = $('#account_id').val();
            var account_name = $('#account_name').val();
            var account_type = $('#account_type').val();
            var opening_balance = $('#opening_balance').val();
            var description = $('#description').val();
            var save_type = $('#save_type').val();
            $.get('{{ url('saveAccounts') }}',
            {
                _token: $('meta[name="csrf-token"]').attr('content'),
                account_id:account_id,
                account_name:account_name,
                account_type:account_type,
                opening_balance:opening_balance,
                description:description,
                save_type:save_type
            },
            function(data){
                table_post_accounts(data);
            });
        }
        // table row with ajax
        function table_post_accounts(res){
            let htmlView = '';
            for(let i = 0; i < res.accounts.length; i++){
                if (res.accounts[i].account_type != 'Assets') {
                    htmlView +=
                    `
                        <tr>
                            <td class="align-middle  ">
                                <p class="fs--1 mb-0 fw-semi-bold">`+(i+1)+`</p>
                            </td>
                            <td class="align-middle" account_name="`+res.accounts[i].account_name+`">
                                <span class="fs--1 mb-0  fw-semi-bold text-900" >`+res.accounts[i].account_name+`</span></h6>
                            </td>
                            <td class="align-middle" account_type="`+res.accounts[i].account_type+`">
                                <p class="fs--1 mb-0  fw-semi-bold text-900" >`+res.accounts[i].account_type+`</p>
                            </td>
                            <td class="align-middle text-center" opening_balance="`+res.accounts[i].opening_balance+`">
                                <p class="fs--1 mb-0  fw-semi-bold text-900" >`+res.accounts[i].opening_balance+`</p>
                            </td>
                            <td class="align-middle text-center" description="`+res.accounts[i].description+`">
                                <p class="fs--1 mb-0  fw-semi-bold text-900" >`+res.accounts[i].description+`</p>
                            </td>
                            <td class="align-middle text-center" account_id="`+res.accounts[i].id+`">
                                <p class="fs--1 mb-0 fw-semi-bold  far fa-edit fs-2 text-warning edit_account"></p>
                            </td>
                        </tr>
                    `;
                }
            }
            $('#bodyAccounts').html(htmlView);
            $("#account_name").val('');
            $("#account_type").val('');
            $("#opening_balance").val('');
            $("#description").val('');
            $('#save_type').val('new');
            $('#account_id').val('');
        }
        $(document).on('click', '.edit_account', function(){

            const row = $(event.target).closest('tr');
            account_name = row.find('td:eq(1)').attr('account_name');
            account_type = row.find('td:eq(2)').attr('account_type');
            opening_balance = row.find('td:eq(3)').attr('opening_balance');
            description = row.find('td:eq(4)').attr('description');
            account_id = row.find('td:eq(5)').attr('account_id');

            $('#account_name').val(account_name);
            $('#account_type').val(account_type);
            $('#opening_balance').val(opening_balance);
            $('#description').val(description);
            $('#account_id').val(account_id);
            $('#save_type').val('update');
        });
    });
</script>