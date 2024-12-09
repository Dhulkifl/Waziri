<x-app-layout>
    <div class="contents">
        <div class="modal-body p-0">
            <!-- header -->
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                <h4 class="mb-1" id="staticBackdropLabel">{{ __('translations.courseDetails') }}</h4>
            </div>

            <form id="course-form" action="{{ route('saveCourse') }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf
                <div class="m-3" id="">
                    <div class="row g-0">
                        <div class="col-lg-12 pe-lg-2">
                            <div class="card mb-3">
                                <div class="card-body bg-light">
                                    <div class="row gx-2">
                                        <!-- Course details here -->
                                        <input type="hidden" name="course_save_type" value="update"
                                            id="course_save_type">
                                        <input type="hidden" name="course_id" value="{{ $course->id }}"
                                            id="course_id">
                                        <div class="col-sm-3 mb-3"><label
                                                class="form-label fs-rtl">{{ __('translations.courseName') }}</label>
                                            <input class="form-control" name="course_name" id="course_name"
                                                value="{{ $course->course_name }}" type="text" required=""
                                                placeholder="{{ __('translations.courseName') }}" />
                                        </div>

                                        <div class="col-sm-3 mb-3"><label
                                                class="form-label fs-rtl">{{ __('translations.subject') }}</label>
                                            <select class="form-select" required="" name="subject_id"
                                                id="subject_id">
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}"
                                                        @if ($course->subject_id == $subject->id) selected @endif>
                                                        {{ $subject->subject_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-3 mb-3"><label
                                                class="form-label fs-rtl">{{ __('translations.teacher') }}</label>
                                            <select class="form-select" required="" name="teacher_id"
                                                id="teacher_id">
                                                @foreach ($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}"
                                                        @if ($course->teacher_id == $teacher->id) selected @endif>
                                                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-3 mb-3"><label
                                                class="form-label fs-rtl">{{ __('translations.time') }}</label>
                                            <input class="form-control" name="time" value="{{ $course->time }}"
                                                id="time" type="text" required=""
                                                placeholder="{{ __('translations.time') }}" />
                                        </div>

                                        <div class="col-sm-3 mb-3"><label
                                                class="form-label fs-rtl">{{ __('translations.startDate') }}</label>
                                            <input class="form-control date" name="start_date"
                                                value="{{ $course->start_date }}" id="start_date" type="date"
                                                required placeholder="{{ __('translations.startDate') }}" />
                                        </div>

                                        <div class="col-sm-3 mb-3"><label
                                                class="form-label fs-rtl">{{ __('translations.endDate') }}</label>
                                            <input class="form-control date" name="end_date"
                                                value="{{ $course->end_date }}" id="end_date" type="date"
                                                placeholder="{{ __('translations.endDate') }}" required />
                                        </div>

                                        <div class="col-sm-3 mb-3"><label
                                                class="form-label fs-rtl">{{ __('translations.fee') }}</label>
                                            <input class="form-control" name="fee" value="{{ $course->fee }}"
                                                id="fee" type="number" required=""
                                                placeholder="{{ __('translations.fee') }}" />
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
            </form>
        </div>
    </div>
    <script>
        flatpickr(".date", {
            enableTime: false,
        });
    </script>
</x-app-layout>
