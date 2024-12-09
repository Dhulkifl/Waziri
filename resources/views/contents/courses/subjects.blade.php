<x-app-layout>
    <div class="contents">
        <main class="main" id="top">
            <div class="container-fluid">
                <div class="row min-vh-50 ">
                    <div class="col-7 order-xxl-3">
                        <div class="card" id="runningSubjectTable" data-list='{"valueNames":["#","subject_name"]}'>
                            <div class="card-header">
                                <h6 class="mb-0">{{ __('paths.subjects') }}</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="scrollbar">
                                    <table
                                        class="table mb-0 table-borderless fs--2 border-200 overflow-hidden table-running-project">
                                        <thead class="bg-light">
                                            <tr class="text-800">
                                                <th class="sort" data-sort="#">#</th>
                                                <th class="sort" data-sort="subject_name">
                                                    {{ __('translations.subjectName') }}
                                                </th>
                                                <th class="sort" data-sort="category_name">
                                                    {{ __('translations.category') }}
                                                </th>
                                                <th class="sort text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodySubjects" class="list">
                                            @foreach ($subjects as $subject)
                                                <tr>
                                                    <td class="align-middle">
                                                        <p class="fs--1 mb-0 fw-semi-bold #">{{ $count++ }}</p>
                                                    </td>

                                                    <td class="align-middle"
                                                        subject_name="{{ $subject->subject_name }}">
                                                        <span
                                                            class="fs--1 mb-0  fw-semi-bold text-900 subject_name">{{ $subject->subject_name }}</span>
                                                    </td>

                                                    <td class="align-middle"
                                                        category_name="{{ $subject->category->category_name }}">
                                                        <span
                                                            class="fs--1 mb-0  fw-semi-bold text-900 category_name">{{ $subject->category->category_name }}</span>
                                                    </td>

                                                    <td class="align-middle text-center"
                                                        subject_id="{{ $subject->id }}">
                                                        <span
                                                            class="fs--1 mb-0 fw-semi-bold  far fa-edit fs-2 text-warning edit_subject"></span>
                                                    </td>
                                                </tr>
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
                                    <div class="card-header bg-circle-shape bg-shape text-center p-2"><a
                                            class="font-sans-serif fw-bolder fs-4 z-index-1 position-relative link-light light">{{ __('translations.newSubject') }}</a>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="needs-validation" novalidate>
                                            <input type="hidden" name="subject_id" id="subject_id" value="">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="split-name">{{ __('translations.subjectName') }}</label>
                                                <input class="form-control" id="subject_name" type="text"
                                                    name="subject_name"
                                                    placeholder="{{ __('translations.subjectName') }}"
                                                    autocomplete="on" required />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="split-name">{{ __('translations.category') }}</label>
                                                <select class="form-select" id="category_id" name="category_id"
                                                    required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <input type="hidden" id="save_type" value="new">

                                            <div class="mb-3">
                                                <button class="btn btn-primary d-block w-100 mt-3" id="submit"
                                                    type="button">{{ __('translations.save') }}</button>
                                            </div>
                                        </div>
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
    $(document).ready(function() {
        $(document).on('click', '#submit', function() {

            if ($("#subject_name").val() == "") {

            } else {
                saveSubject();
            }
        });

        function saveSubject() {
            var subject_id = $('#subject_id').val();
            var subject_name = $('#subject_name').val();
            var category_id = $('#category_id').val();
            var save_type = $('#save_type').val();
            $.get('{{ url('saveSubjects') }}', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    subject_id: subject_id,
                    subject_name: subject_name,
                    category_id: category_id,
                    save_type: save_type
                },
                function(data) {
                    table_post_subjects(data);
                });
        }
        // table row with ajax
        function table_post_subjects(res) {
            let htmlView = '';
            for (let i = 0; i < res.subjects.length; i++) {
                htmlView +=
                    `
                    <tr>
                        <td class="align-middle  ">
                            <p class="fs--1 mb-0 fw-semi-bold">` + (i + 1) + `</p>
                        </td>
                        <td class="align-middle" subject_name="` + res.subjects[i].subject_name + `">
                            <span class="fs--1 mb-0  fw-semi-bold text-900" >` + res.subjects[i].subject_name + `</span></h6>
                        </td>
                        <td class="align-middle" category_name="` + res.subjects[i].category.category_name + `">
                            <span class="fs--1 mb-0  fw-semi-bold text-900" >` + res.subjects[i].category
                    .category_name + `</span></h6>
                        </td>
                        <td class="align-middle text-center" subject_id="` + res.subjects[i].id + `">
                            <p class="fs--1 mb-0 fw-semi-bold  far fa-edit fs-2 text-warning edit_subject"></p>
                        </td>
                    </tr>
                `;
            }
            $('#bodySubjects').html(htmlView);
            $("#subject_name").val('');
            $('#save_type').val('new');
            $('#subject_id').val('');
            $('#category_id').val('');
        }
        $(document).on('click', '.edit_subject', function() {

            const row = $(event.target).closest('tr');
            subject_name = row.find('td:eq(1)').attr('subject_name');
            category_name = row.find('td:eq(2)').attr('category_name');
            subject_id = row.find('td:eq(3)').attr('subject_id');

            $('#subject_name').val(subject_name);
            // get category id from category name
            $.get('{{ url('getCategoryId') }}', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    category_name: category_name
                },
                function(data) {
                    $('#category_id').val(data.category_id);
                });
            $('#subject_id').val(subject_id);
            $('#save_type').val('update');
        });
    });
</script>
