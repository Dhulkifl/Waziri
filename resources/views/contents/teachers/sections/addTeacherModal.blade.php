<div class="modal fade" id="new-apartment-modal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
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
                    <h4 class="mb-1" id="staticBackdropLabel">{{ __('translations.newTeacher') }}</h4>
                </div>
                <!-- tab headers -->

                <form id="apartment-form" action="{{ route('saveTeacher') }}" method="POST"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="m-3" id="">
                        <div class="row g-0">
                            <div class="col-lg-12 pe-lg-2">
                                <div class="card mb-3">
                                    <div class="card-body bg-light">
                                        <div class="row gx-2">
                                            <!-- Resident details here -->
                                            <input type="hidden" name="teacher_save_type" value="new"
                                                id="teacher_save_type">

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.firstName') }}</label>
                                                <input class="form-control" name="first_name" id="first_name"
                                                    type="text" required=""
                                                    placeholder="{{ __('translations.firstName') }}" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.fatherName') }}</label>
                                                <input class="form-control" name="father_name" id="father_name"
                                                    required="" type="text"
                                                    placeholder="{{ __('translations.fatherName') }}" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.lastName') }}</label>
                                                <input class="form-control" name="last_name" id="last_name"
                                                    required="" type="text"
                                                    placeholder="{{ __('translations.lastName') }}" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.phone') }}</label>
                                                <input class="form-control" name="phone" id="phone" type="text"
                                                    required="" placeholder="{{ __('translations.phone') }}" />
                                            </div>

                                            <div class="col-sm-6 mb-3"><label
                                                    class="form-label">{{ __('translations.address') }}</label>
                                                <input class="form-control " name="address" id="address"
                                                    type="text" required=""
                                                    placeholder="{{ __('translations.address') }}" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.contractStartDate') }}</label>
                                                <input class="form-control date" name="contract_start_date"
                                                    id="contract_start_date"
                                                    placeholder="{{ __('translations.contractStartDate') }}"
                                                    type="date" required="" />
                                            </div>

                                            <div class="col-sm-3 mb-3"><label
                                                    class="form-label">{{ __('translations.contractEndDate') }}</label>
                                                <input class="form-control date" name="contract_end_date"
                                                    id="contract_end_date"
                                                    placeholder="{{ __('translations.contractEndDate') }}"
                                                    type="date" required="" />
                                            </div>

                                            <div class="col-sm-3 mb-3">
                                                <label for="organizerSingle">{{ __('translations.status') }}</label>
                                                <select class="form-select" required="" name="status"
                                                    id="status">
                                                    <option value="Active" selected>{{ __('translations.Active') }}
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
<script>
    flatpickr(".date", {
        enableTime: false,
    });
</script>
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

        $('#save-teacher').click(function() {
            if (validateTab('#apartment-form')) {
                saveTeacher();
            } else {
                $('#apartment-form').addClass('was-validated');
            }
        });

        function saveTeacher() {
            var teacher_save_type = $('#teacher_save_type').val();
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var father_name = $('#father_name').val();
            var address = $('#address').val();
            var phone = $('#phone').val();
            var status = $('#status').val();
            var photo = $('#photo')[0];

            $.ajax({
                type: 'GET',
                url: '/saveTeachers',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    teacher_save_type: teacher_save_type,
                    first_name: first_name,
                    last_name: last_name,
                    father_name: father_name,
                    address: address,
                    phone: phone,
                    status: status,
                    photo: photo,

                },

                success: function(response) {
                    alert("Teacher Details Saved Successfully, ID is: " + response.teacher.id);
                    $('#new-apartment-modal').modal('hide');
                    $('#new-apartment-modal').on('hidden.bs.modal', function() {
                        $('#apartment-form')[0].reset();
                    });
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
    });
</script>
