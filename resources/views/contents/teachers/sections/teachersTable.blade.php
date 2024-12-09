<div class="col-xxl-9 col-md-12">
    <div class="card z-index-1" id="recentPurchaseTable"
        data-list='{"valueNames":["#","id","first_name","last_name","father_name","address","phone","status"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex gap-2 align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 fs-rtl fw-semi-bold py-xl-0"> {{ __('translations.teachers') }}
                    </h5>
                    <div class="search-box" data-list='{"valueNames":["title"]}'>
                        <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input
                                class="form-control search-input fuzzy-search" type="search" placeholder="Search..."
                                aria-label="Search" />
                            <span class="fas fa-search search-box-icon"></span>
                        </form>
                        <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none"
                            data-bs-dismiss="search">
                            <div class="btn-close-falcon" aria-label="Close"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm mx-2" type="button" data-bs-toggle="modal"
                            data-bs-target="#new-apartment-modal">
                            <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                            <span
                                class="d-none d-sm-inline-block fs-rtl fw-semi-bold ms-1">{{ __('translations.new') }}</span>
                        </button>
                        <button class="btn btn-falcon-default btn-sm dropdown-toggle" type="button" id="dropdown0"
                            data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"
                            data-bs-reference="parent">
                            <span class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span>
                            <span
                                class="d-none d-sm-inline-block fs-rtl fw-semi-bold ms-1">{{ __('translations.export') }}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown0">
                            <a class="dropdown-item" href="#!">{{ __('translations.pdf') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#!">{{ __('translations.msexcel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 py-0">
            <div class="table-responsive scrollbar">
                <table class="table table-sm fs-0 fw-semi-bold mb-0 overflow-hidden" style="font-family: 'Calibri';">
                    <thead class="bg-200 text-900">
                        <tr>
                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="#">#</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="id">ID</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="first_name">
                                {{ __('translations.firstName') }}</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="father_name">
                                {{ __('translations.fatherName') }}</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="last_name">
                                {{ __('translations.lastName') }}</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="phone">
                                {{ __('translations.phone') }}
                            </th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="address">
                                {{ __('translations.address') }}</th>

                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">
                                {{ __('translations.status') }}
                            </th>
                            <th class="no-sort pe-1 align-middle data-table-row-action"></th>
                        </tr>

                    </thead>
                    <tbody class="list" id="table-purchase-body">
                        @foreach ($teachers as $teacher)
                            <tr class="btn-reveal-trigger">
                                <th class="align-middle white-space-nowrap id">{{ $count++ }}</th>
                                <th class="align-middle white-space-nowrap text-center id">{{ $teacher->id }}</th>
                                <td class="align-middle white-space-nowrap text-center first_name">
                                    {{ $teacher->first_name }}</td>
                                <td class="align-middle white-space-nowrap text-center father_name">
                                    {{ $teacher->father_name }}</td>
                                <td class="align-middle white-space-nowrap text-center last_name">
                                    {{ $teacher->last_name }}</td>
                                <td class="align-middle white-space-nowrap text-center phone">{{ $teacher->phone }}
                                </td>
                                <td class="align-middle white-space-nowrap text-center address">{{ $teacher->address }}
                                </td>
                                <td class="align-middle white-space-nowrap text-center status">
                                    <span
                                        class="badge badge fs-rtl rounded-pill px-3 @if ($teacher->status == 'Active') badge-soft-success @else badge-soft-warning @endif">
                                        {{ __('translations.' . $teacher->status) }}
                                    </span>
                                </td>
                                <td class="align-middle white-space-nowrap text-end">
                                    <a href="{{ route('teacherDetails', $teacher->id) }}">
                                        <button class="btn btn-falcon-warning btn-sm " type="button"
                                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            <span class="far fa-newspaper fs-2"
                                                data-fa-transform="shrink-3 down-2"></span>
                                            <span class="d-none d-sm-inline-block ms-1">View</span>
                                        </button>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="row align-items-center">
                <div class="pagination d-none"></div>
                <div class="col">
                    <p class="mb-0 fs--1"><span class="d-none d-sm-inline-block me-2" data-list-info="data-list-info">
                        </span></p>
                </div>
                <div class="col-auto d-flex">
                    <button class="btn btn-sm btn-primary" type="button"
                        data-list-pagination="prev"><span>{{ __('translations.previous') }}</span></button>
                    <button class="btn btn-sm btn-primary px-4 ms-2" type="button"
                        data-list-pagination="next"><span>{{ __('translations.next') }}</span></button>
                </div>
            </div>
        </div>
    </div>
</div>
