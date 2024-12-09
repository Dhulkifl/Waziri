<x-app-layout>
    <div class="contents">
        <div class="modal-body p-0">
            <!-- header -->
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                <h4 class="mb-1" id="staticBackdropLabel">{{ __('translations.details') }}</h4>
            </div>

            <form id="student-form" action="{{ route('newStudent') }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf
                <div class="m-3" id="">
                    <div class="row g-0">
                        <div class="col-lg-12 pe-lg-2">
                            <div class="card mb-3">
                                <div class="card-body bg-light">
                                    <div class="row gx-2">
                                        <div class="col-md-3 row gx-1">
                                            <div class="ms-5 h-200">
                                                <img class="img-thumbnail rounded-circle mb-3 shadow-sm"
                                                    src="{{ asset('uploads/images/students') }}/{{ $student->photo }}"
                                                    alt="" width="200" height="200" />

                                            </div>
                                        </div>

                                        <div class="col-md-9 row gx-2">
                                            <!-- Resident details here -->
                                            <input type="hidden" name="student_save_type" value="update"
                                                id="student_save_type">
                                            <input type="hidden" name="student_id" value="{{ $student->id }}"
                                                id="">
                                            <div class="col-sm-3 mb-3"><label class="form-label">
                                                    {{ __('translations.firstName') }}</label>
                                                <input class="form-control" name="name" id="first_name"
                                                    value="{{ $student->name }}" type="text" required=""
                                                    placeholder="{{ __('translations.firstName') }}" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.fatherName') }}</label>
                                                <input class="form-control" name="father_name"
                                                    value="{{ $student->father_name }}" id="father_name" type="text"
                                                    required="" placeholder="{{ __('translations.fatherName') }}" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.lastName') }}</label>
                                                <input class="form-control" name="last_name"
                                                    value="{{ $student->last_name }}" id="last_name" type="text"
                                                    placeholder="{{ __('translations.lastName') }}" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.phone') }}</label>
                                                <input class="form-control" name="phone"
                                                    value="{{ $student->phone }}" id="phone" type="text"
                                                    placeholder="{{ __('translations.phone') }}" />
                                            </div>

                                            <div class="col-sm-4 mb-3"><label
                                                    class="form-label">{{ __('translations.address') }}</label>
                                                <input class="form-control" name="address"
                                                    value="{{ $student->address }}" id="address" type="text"
                                                    placeholder="{{ __('translations.address') }}" />
                                            </div>

                                            <div class="col-sm-2 mb-3">
                                                <label for="organizerSingle">{{ __('translations.status') }}</label>
                                                <select class="form-select" required="" name="status"
                                                    id="status">
                                                    <option value="Active"
                                                        @if ($student->status == 'Active') selected @endif>
                                                        {{ __('translations.Active') }}</option>
                                                    <option value="Inactive"
                                                        @if ($student->status == 'Inactive') selected @endif>
                                                        {{ __('translations.Inactive') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-6  mb-3"><label class="form-label"
                                                    for="contract_date">{{ __('translations.photo') }}</label>
                                                <input type="file" class="form-control" id="photo"
                                                    name="photo" />
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <div class="float-end gap-2 pt-4">
                                                    <button class="btn btn-primary"
                                                        type="submit">{{ __('translations.save') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="m-3" style="font-family: 'Calibri'">
                <div class="row g-0">
                    <div class="col-lg-12 pe-lg-2">
                        <div class="card mb-3">
                            <div class="card-body bg-light">
                                <h4>{{ __('translations.enrolledCourses') }}</h4>
                                @foreach ($enrolledCourses as $course)
                                    <div class="mb-3">
                                        <h5>{{ $course->course_name }}</h5>
                                        <p>
                                            {{ __('translations.time') }}: {{ $course->time }}<br>
                                            {{ __('translations.startDate') }}: {{ $course->start_date }}<br>
                                            {{ __('translations.endDate') }}: {{ $course->end_date }}<br>
                                            {{ __('translations.fee') }}: {{ $course->fee }}<br>
                                            {{ __('translations.enrollmentDate') }}: {{ $course->enrollment_date }}
                                        </p>
                                        <h4>{{ __('translations.payments') }}</h4>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('translations.feeType') }}</th>
                                                    <th>{{ __('translations.amount') }}</th>
                                                    <th>{{ __('translations.discount') }}</th>
                                                    <th>{{ __('translations.paid') }}</th>
                                                    <th>{{ __('translations.balance') }}</th>
                                                    <th class="month-cell">{{ __('translations.month') }}</th>
                                                    <th>{{ __('translations.year') }}</th>
                                                    <th>{{ __('translations.paymentDate') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($fees as $fee)
                                                    @if ($fee->course_id == $course->id)
                                                        <tr>
                                                            <td>{{ __('translations.' . $fee->fee_type) }}</td>
                                                            <td>{{ $fee->fee_amount }}</td>
                                                            <td>{{ $fee->discount }}</td>
                                                            <td>{{ $fee->paid }}</td>
                                                            <td>{{ $fee->fee_amount - ($fee->discount + $fee->paid) }}
                                                            </td>
                                                            <td>{{ $fee->month }}</td>
                                                            <td>{{ $fee->year }}</td>
                                                            <td>{{ $fee->payment_date }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        var months = [
            '',
            'حمل',
            'ثور',
            'جوزا',
            'سرطان',
            'اسد',
            'سنبله',
            'میزان',
            'عقرب',
            'قوس',
            'جدی',
            'دلو',
            'حوت',
        ];

        $('table tr td:nth-child(6)').each(function() {
            var monthIndex = parseInt($(this).text());
            $(this).text(months[monthIndex]);
        });
    });
</script>
