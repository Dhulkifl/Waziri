<div class="modal fade" id="new-course-modal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- header -->
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1" id="staticBackdropLabel">{{ __('translations.newCourse') }}</h4>
                </div>
                <!-- tab headers -->

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
                                            <input type="hidden" name="course_save_type" value="new"
                                                id="course_save_type">

                                            <div class="col-sm-4 mb-3"><label
                                                    class="form-label">{{ __('translations.courseName') }}</label>
                                                <input class="form-control" name="course_name" id="course_name"
                                                    type="text" required=""
                                                    placeholder="{{ __('translations.courseName') }}" />
                                            </div>

                                            <div class="col-sm-4 mb-3"><label
                                                    class="form-label">{{ __('translations.subject') }}</label>
                                                <select class="form-select" required="" name="subject_id"
                                                    id="subject_id">
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->id }}">{{ $subject->subject_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-4 mb-3"><label
                                                    class="form-label">{{ __('translations.teacher') }}</label>
                                                <select class="form-select" required="" name="teacher_id"
                                                    id="teacher_id">
                                                    @foreach ($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}">{{ $teacher->first_name }}
                                                            {{ $teacher->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-4 mb-3"><label
                                                    class="form-label">{{ __('translations.time') }}</label>
                                                <input class="form-control" name="time" id="time" type="text"
                                                    required="" placeholder="{{ __('translations.time') }}" />
                                            </div>

                                            <div class="col-sm-4 mb-3"><label
                                                    class="form-label">{{ __('translations.startDate') }}</label>
                                                <input class="form-control date" name="start_date" id="start_date"
                                                    type="date" required=""
                                                    placeholder="{{ __('translations.startDate') }}" />
                                            </div>

                                            <div class="col-sm-4 mb-3"><label
                                                    class="form-label">{{ __('translations.endDate') }}</label>
                                                <input class="form-control date" name="end_date" id="end_date"
                                                    type="date" required=""
                                                    placeholder="{{ __('translations.endDate') }}" />
                                            </div>

                                            <div class="col-sm-4 mb-3"><label
                                                    class="form-label">{{ __('translations.fee') }}</label>
                                                <input class="form-control" name="fee" id="fee" type="number"
                                                    required="" placeholder="{{ __('translations.fee') }}" />
                                            </div>
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
</div>
</div>

<script>
    flatpickr(".date", {
        enableTime: false,
    });
</script>
