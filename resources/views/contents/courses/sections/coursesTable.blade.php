<div class="col-xxl-9 col-md-12">
    <div class="card z-index-1" id="recentPurchaseTable"
        data-list='{"valueNames":["#","id","course_name","subject_id","teacher_id","time","start_date","end_date","fee"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex gap-2 align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 fs-rtl fw-semi-bold py-xl-0"> {{ __('paths.courses') }}
                    </h5>
                    <div class="search-box" data-list='{"valueNames":["title"]}'>
                        <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input
                                class="form-control search-input fuzzy-search" type="search"
                                placeholder="{{ __('translations.search') }}..." aria-label="Search" />
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
                            data-bs-target="#new-course-modal">
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
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="id">
                                {{ __('translations.id') }}</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="course_name">
                                {{ __('translations.courseName') }}</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="subject_id">
                                {{ __('translations.subject') }}</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="teacher_id">
                                {{ __('translations.teacher') }}</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="time">
                                {{ __('translations.time') }}</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="start_date">
                                {{ __('translations.startDate') }}</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="end_date">
                                {{ __('translations.endDate') }}</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="fee">
                                {{ __('translations.fee') }}</th>
                            <th class="no-sort pe-1 align-middle data-table-row-action"></th>
                        </tr>

                    </thead>
                    <tbody class="list" id="table-purchase-body">
                        @foreach ($courses as $course)
                            <tr class="btn-reveal-trigger">
                                <th class="align-middle white-space-nowrap id">{{ $count++ }}</th>
                                <th class="align-middle white-space-nowrap text-center id">{{ $course->id }}</th>
                                <td class="align-middle white-space-nowrap text-center course_name">
                                    {{ $course->course_name }}</td>
                                <td class="align-middle white-space-nowrap text-center subject_id">
                                    {{ $course->subject->subject_name }}</td>
                                <td class="align-middle white-space-nowrap text-center teacher_id">
                                    {{ $course->teacher->first_name }} {{ $course->teacher->last_name }}</td>
                                <td class="align-middle white-space-nowrap text-center time">{{ $course->time }}
                                </td>
                                <td class="align-middle white-space-nowrap text-center start_date">
                                    {{ $course->start_date }}</td>
                                <td class="align-middle white-space-nowrap text-center end_date">
                                    {{ $course->end_date }}
                                </td>
                                <td class="align-middle white-space-nowrap text-center fee">{{ $course->fee }}
                                </td>
                                <td class="align-middle white-space-nowrap text-end">
                                    <a href="{{ route('courseDetails', $course->id) }}">
                                        <button class="btn btn-falcon-warning btn-sm " type="button"
                                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            <span class="far fa-newspaper fs-2"
                                                data-fa-transform="shrink-3 down-2"></span>
                                            <span
                                                class="d-none d-sm-inline-block ms-1">{{ __('translations.view') }}</span>
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
