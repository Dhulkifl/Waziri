<x-app-layout>
    <div class="contents">
        <div class="modal-body p-0">
            <!-- header -->
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                <h4 class="mb-1" id="staticBackdropLabel">{{ __('translations.teacherDetails') }}</h4>
            </div>

            <form id="teacher-form" action="{{ route('saveTeacher') }}" method="POST" enctype="multipart/form-data"
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
                                                    src="{{ asset('uploads/images/teachers') }}/{{ $teacher->photo }}"
                                                    alt="" width="200" height="200" />

                                            </div>
                                        </div>

                                        <div class="col-md-9 row gx-2">
                                            <!-- Resident details here -->
                                            <input type="hidden" name="teacher_save_type" value="update"
                                                id="teacher_save_type">
                                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}"
                                                id="">
                                            <div class="col-sm-3 mb-3"><label class="form-label">
                                                    {{ __('translations.firstName') }}</label>
                                                <input class="form-control" name="first_name" id="first_name"
                                                    value="{{ $teacher->first_name }}" type="text" required=""
                                                    placeholder="{{ __('translations.firstName') }}" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.fatherName') }}</label>
                                                <input class="form-control" name="father_name"
                                                    value="{{ $teacher->father_name }}" id="father_name" type="text"
                                                    required="" placeholder="{{ __('translations.fatherName') }}" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.lastName') }}</label>
                                                <input class="form-control" name="last_name"
                                                    value="{{ $teacher->last_name }}" id="last_name" type="text"
                                                    placeholder="{{ __('translations.lastName') }}" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.phone') }}</label>
                                                <input class="form-control" name="phone"
                                                    value="{{ $teacher->phone }}" id="phone" type="text"
                                                    placeholder="{{ __('translations.phone') }}" />
                                            </div>

                                            <div class="col-sm-4 mb-3"><label
                                                    class="form-label">{{ __('translations.address') }}</label>
                                                <input class="form-control" name="address"
                                                    value="{{ $teacher->address }}" id="address" type="text"
                                                    placeholder="{{ __('translations.address') }}" />
                                            </div>

                                            <div class="col-sm-2 mb-3">
                                                <label for="organizerSingle">{{ __('translations.status') }}</label>
                                                <select class="form-select" required="" name="status"
                                                    id="status">
                                                    <option value="Active"
                                                        @if ($teacher->status == 'Active') selected @endif>
                                                        {{ __('translations.Active') }}</option>
                                                    <option value="Inactive"
                                                        @if ($teacher->status == 'Inactive') selected @endif>
                                                        {{ __('translations.Inactive') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.contractStartDate') }}</label>
                                                <input class="form-control date" name="contract_start_date"
                                                    value="{{ $teacher->contract_start_date }}"
                                                    id="contract_start_date" type="date" required="" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.contractEndDate') }}</label>
                                                <input class="form-control date" name="contract_end_date"
                                                    value="{{ $teacher->contract_end_date }}" id="contract_end_date"
                                                    type="date" required="" />
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
                                <h4>{{ __('paths.courses') }}</h4>
                                @foreach ($courses as $course)
                                    <div class="mb-3">
                                        <h5>{{ $course->course_name }}</h5>
                                        <p>
                                            {{ __('translations.time') }}: {{ $course->time }}<br>
                                            {{ __('translations.startDate') }}: {{ $course->start_date }}<br>
                                            {{ __('translations.endDate') }}: {{ $course->end_date }}<br>
                                            {{ __('translations.fee') }}: {{ $course->fee }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        flatpickr(".date", {
            enableTime: false,
        });
    </script>
</x-app-layout>
