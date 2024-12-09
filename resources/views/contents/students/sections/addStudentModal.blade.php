<div class="modal fade" id="new-student-modal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
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
                    <h4 class="mb-1" id="staticBackdropLabel">{{ __('translations.newStudent') }}</h4>
                </div>
                <!-- tab headers -->
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="font-family: 'Calibri'">
                    <li class="nav-item"><a class="nav-link active" id="student-tab" data-bs-toggle="tab"
                            href="#tab-student" role="tab" aria-controls="tab-student"
                            aria-selected="true">{{ __('translations.student') }}</a></li>
                    <li class="nav-item"><a class="nav-link" id="course-tab" data-bs-toggle="tab" href="#tab-course"
                            role="tab" aria-controls="tab-course"
                            aria-selected="false">{{ __('translations.course') }}</a></li>
                </ul>
                <form id="student-form" action="{{ route('newStudent') }}" method="POST" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    @csrf
                    <div class="tab-content border-x border-bottom p-3" id="myTabContent">
                        <!-- student details -->
                        <div class="tab-pane fade show active" id="tab-student" role="tabpanel"
                            aria-labelledby="student-tab">
                            <div class="row g-0">
                                <div class="col-lg-12 pe-lg-2">
                                    <div class="card mb-3">
                                        <div class="card-body bg-light">
                                            <div class="row gx-2">
                                                <!-- Resident details here -->
                                                <input type="hidden" name="student_save_type" value="new"
                                                    id="student_save_type">

                                                <div class="col-sm-4 mb-3"><label
                                                        class="form-label">{{ __('translations.firstName') }}</label>
                                                    <input class="form-control" name="name" id="name"
                                                        type="text" required=""
                                                        placeholder="{{ __('translations.firstName') }}" />
                                                </div>

                                                <div class="col-sm-4 mb-3"><label
                                                        class="form-label">{{ __('translations.fatherName') }}</label>
                                                    <input class="form-control" name="father_name" id="father_name"
                                                        required="" type="text"
                                                        placeholder="{{ __('translations.fatherName') }}" />
                                                </div>

                                                <div class="col-sm-4 mb-3"><label
                                                        class="form-label">{{ __('translations.lastName') }}</label>
                                                    <input class="form-control" name="last_name" id="last_name"
                                                        type="text"
                                                        placeholder="{{ __('translations.lastName') }}" />
                                                </div>

                                                <div class="col-sm-5 mb-3"><label
                                                        class="form-label">{{ __('translations.phone') }}</label>
                                                    <input class="form-control" name="phone" id="phone"
                                                        type="text" placeholder="{{ __('translations.phone') }}" />
                                                </div>

                                                <div class="col-sm-7 mb-3"><label
                                                        class="form-label">{{ __('translations.address') }}</label>
                                                    <input class="form-control" name="address" id="address"
                                                        type="text"
                                                        placeholder="{{ __('translations.address') }}" />
                                                </div>

                                                <div class="col-sm-3 mb-3">
                                                    <label
                                                        for="organizerSingle">{{ __('translations.status') }}</label>
                                                    <select class="form-select" required="" name="status"
                                                        id="status">
                                                        <option value="Active" selected>
                                                            {{ __('translations.Active') }}
                                                        </option>
                                                        <option value="Inactive">{{ __('translations.Inactive') }}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-sm-9  mb-3"><label class="form-label"
                                                        for="contract_date">{{ __('translations.photo') }}</label>
                                                    <input type="file" class="form-control" id="photo"
                                                        name="photo" />
                                                </div>
                                            </div>

                                            <div class="col-sm-12 mb-3">
                                                <div class="float-end gap-2 pt-4">
                                                    <button class="btn btn-primary" id="next-student"
                                                        type="button">{{ __('translations.next') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- course details -->
                        <div class="tab-pane fade" id="tab-course" role="tabpanel" aria-labelledby="course-tab">
                            <div class="row g-0">
                                <div class="col-lg-12 pe-lg-2">
                                    <div class="card mb-3">
                                        <div class="card-body bg-light">
                                            <div class="row gx-2">
                                                <!-- Course details here -->
                                                <div class="col-sm-6 mb-3">
                                                    <label class="form-label">{{ __('translations.course') }}</label>
                                                    <select class="form-select" required="" name="course_id"
                                                        id="course_id">
                                                        <option value="">{{ __('translations.selectCourse') }}
                                                        </option>
                                                        @foreach ($courses as $course)
                                                            <option value="{{ $course->id }}">
                                                                {{ $course->course_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-sm-3 mb-3">
                                                    <label class="form-label">{{ __('translations.time') }}</label>
                                                    <input class="form-control" name="time" id="time"
                                                        type="text" placeholder="{{ __('translations.time') }}"
                                                        readonly required />
                                                </div>

                                                <div class="col-sm-3 mb-3">
                                                    <label
                                                        class="form-label">{{ __('translations.startDate') }}</label>
                                                    <input class="form-control" name="start_date" id="start_date"
                                                        type="text"
                                                        placeholder="{{ __('translations.startDate') }}" readonly
                                                        required />
                                                </div>

                                                <div class="col-sm-3 mb-3">
                                                    <label class="form-label">{{ __('translations.endDate') }}</label>
                                                    <input class="form-control" name="end_date" id="end_date"
                                                        type="text" placeholder="{{ __('translations.endDate') }}"
                                                        readonly required />
                                                </div>

                                                <div class="col-sm-3 mb-3">
                                                    <label class="form-label">{{ __('translations.fee') }}</label>
                                                    <input class="form-control" name="tuition_fee" id="tuition_fee"
                                                        type="text" placeholder="{{ __('translations.fee') }}"
                                                        readonly required />
                                                </div>
                                                <div class="col-sm-3 mb-3">
                                                    <label for="month">{{ __('translations.month') }}</label>
                                                    <select class="form-select" name="month" id="month"
                                                        required>
                                                        <option value="01">01 - حمل</option>
                                                        <option value="02">02 - ثور</option>
                                                        <option value="03">03 - جوزا</option>
                                                        <option value="04">04 - سرطان</option>
                                                        <option value="05">05 - اسد</option>
                                                        <option value="06">06 - سنبله</option>
                                                        <option value="07">07 - میزان</option>
                                                        <option value="08">08 - عقرب</option>
                                                        <option value="09">09 - قوس</option>
                                                        <option value="10">10 - جدی</option>
                                                        <option value="11">11 - دلو</option>
                                                        <option value="12">12 - حوت</option>
                                                    </select>

                                                    <input type="hidden" name="year" id="year"
                                                        value="">
                                                </div>


                                                <div class="col-sm-3 mb-3">
                                                    <label
                                                        class="form-label">{{ __('translations.discount') }}</label>
                                                    <input class="form-control" name="discount" id="discount"
                                                        type="number"
                                                        placeholder="{{ __('translations.discount') }}" required />
                                                </div>

                                                <div class="col-sm-3 mb-3">
                                                    <label class="form-label">{{ __('translations.paid') }}</label>
                                                    <input class="form-control" name="paid" id="paid"
                                                        type="number" placeholder="{{ __('translations.paid') }}"
                                                        required />
                                                </div>
                                                <div class="col-sm-3 mb-3">
                                                    <label class="form-label">{{ __('translations.balance') }}</label>
                                                    <input class="form-control" name="balance" id="balance"
                                                        type="number" placeholder="{{ __('translations.balance') }}"
                                                        readonly required />
                                                </div>

                                                <div class="col-sm-3 mb-3" id="book_fee_amount_div">
                                                    <label class="form-label">{{ __('translations.bookFee') }}</label>
                                                    <input class="form-control" id="book_fee" name="book_fee"
                                                        type="number"
                                                        placeholder="{{ __('translations.bookFee') }}" />
                                                </div>

                                                <div class="col-sm-3 mb-3">
                                                    <label
                                                        class="form-label">{{ __('translations.enrollmentDate') }}</label>
                                                    <input class="form-control date" name="enrollment_date"
                                                        id="enrollment_date"
                                                        placeholder="{{ __('translations.enrollmentDate') }}"
                                                        type="date" required="" value="" />
                                                </div>

                                                <div class="col-sm-12 mb-3">
                                                    <div class="float-end gap-2 pt-4">
                                                        <button class="btn btn-primary" id="prev-course"
                                                            type="button">{{ __('translations.previous') }}</button>
                                                        <button class="btn btn-primary" id="save-course"
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
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        function validateTab(tabId) {
            const inputs = $(tabId).find(':input[required]');
            let isValid = true;
            inputs.each(function() {
                if (!this.checkValidity()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return isValid;
        }


        $('#next-student').click(function() {
            if (validateTab('#tab-student')) {
                $('#student-tab').removeClass('active');
                $('#tab-student').removeClass('show active');
                $('#course-tab').addClass('active');
                $('#tab-course').addClass('show active');
            } else {
                $('#tab-student').addClass('was-validated');
            }
        });

        $('#prev-course').click(function() {
            $('#course-tab').removeClass('active');
            $('#tab-course').removeClass('show active');
            $('#student-tab').addClass('active');
            $('#tab-student').addClass('show active');
        });



        $('#save-course').click(function() {
            if (!validateStudentTab()) {
                $('#student-tab').tab('show');
                return false;
            }
        });

        function validateStudentTab() {
            var isValid = true;
            $('#tab-student :input[required]').each(function() {
                if ($(this).val() === '') {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return isValid;
        }

        /*
        function saveStudent() {
            var student_save_type = $('#student_save_type').val();
            var name = $('#name').val();
            var father_name = $('#father_name').val();
            var last_name = $('#last_name').val();
            var phone = $('#phone').val();
            var address = $('#address').val();
            var status = $('#status').val();
            var photo = $('#photo')[0];

            $.ajax({
                type: 'GET',
                url: '/newStudent',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    student_save_type: student_save_type,
                    name: name,
                    father_name: father_name,
                    last_name: last_name,
                    phone: phone,
                    address: address,
                    status: status,
                    photo: photo,

                },

                success: function(response) {
                    alert("Student Details Saved Successfully, ID is: " + response.student.id);
                    $('#new-student-modal').modal('hide');
                    $('#new-student-modal').on('hidden.bs.modal', function() {
                        $('#student-form')[0].reset();
                    });
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
        */
    });
</script>

<script>
    flatpickr(".date", {
        enableTime: false,
    });

    $(document).ready(function() {

        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
        const day = String(today.getDate()).padStart(2, '0');

        const formattedDate = `${year.toString()}-${month}-${day}`;

        $('#enrollment_date').val(formattedDate);
        $('#year').val(year);

        // Get the current month (1-based index) and convert it to a two-digit format
        const currentMonth = new Date().getMonth() + 1; // JavaScript months are 0-based
        const formattedMonth = currentMonth.toString().padStart(2, '0'); // Format as "01", "02", etc.

        // Loop through the <option> elements in the #month select
        $('#month option').each(function() {
            if ($(this).val() === formattedMonth) {
                // Select the current month
                $(this).prop('selected', true);
                // Enable the current month
                //$(this).prop('disabled', false);
            } else {
                // Disable other months
                //$(this).prop('disabled', true);
            }
        });


        $('#course_id').change(function() {
            var courseId = $(this).val();
            $.ajax({
                type: 'GET',
                url: '/getCourseDetails',
                data: {
                    course_id: courseId
                },
                success: function(data) {
                    $('#time').val(data.time);
                    $('#start_date').val(data.start_date);
                    $('#end_date').val(data.end_date);
                    $('#tuition_fee').val(data.fee);
                    $('#balance').val(data.fee);
                    $('#discount').val('0');
                    $('#book_fee').val('0');
                }
            });
        });

        $(document).ready(function() {
            $('#discount, #paid').on('input', function() {
                var fee = parseFloat($('#tuition_fee').val());
                var discount = parseFloat($('#discount').val());
                var paid = parseFloat($('#paid').val());

                if (isNaN(discount)) {
                    discount = 0;
                }

                if (isNaN(paid)) {
                    paid = 0;
                }

                var balance = fee - discount - paid;

                $('#balance').val(balance);
            });
        });
    });
</script>
