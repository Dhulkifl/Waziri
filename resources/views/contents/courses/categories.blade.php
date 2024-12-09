<!-- View to display categories -->
<x-app-layout>
    <div class="contents">
        <main class="main" id="top">
            <div class="container-fluid">
                <div class="row min-vh-50 ">
                    <div class="col-7 order-xxl-3">
                        <div class="card" id="runningCategoryTable" data-list='{"valueNames":["#","category_name"]}'>
                            <div class="card-header">
                                <h6 class="mb-0">{{ __('paths.categories') }}</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="scrollbar">
                                    <table
                                        class="table mb-0 table-borderless fs--2 border-200 overflow-hidden table-running-project">
                                        <thead class="bg-light">
                                            <tr class="text-800">
                                                <th class="sort" data-sort="#">#</th>
                                                <th class="sort" data-sort="category_name">
                                                    {{ __('translations.category') }}
                                                </th>
                                                <th class="sort text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyCategories" class="list">
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td class="align-middle">
                                                        <p class="fs--1 mb-0 fw-semi-bold #">{{ $count++ }}</p>
                                                    </td>

                                                    <td class="align-middle"
                                                        category_name="{{ $category->category_name }}">
                                                        <span
                                                            class="fs--1 mb-0  fw-semi-bold text-900 category_name">{{ $category->category_name }}</span>
                                                    </td>

                                                    <td class="align-middle text-center"
                                                        category_id="{{ $category->id }}">
                                                        <span
                                                            class="fs--1 mb-0 fw-semi-bold  far fa-edit fs-2 text-warning edit_category"></span>
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
                                            class="font-sans-serif fw-bolder fs-4 z-index-1 position-relative link-light light">{{ __('translations.newCategory') }}</a>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="needs-validation" novalidate>
                                            <input type="hidden" name="category_id" id="category_id" value="">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="split-name">{{ __('translations.category') }}</label>
                                                <input class="form-control" id="category_name" type="text"
                                                    name="category_name" placeholder="{{ __('translations.category') }}"
                                                    autocomplete="on" required />
                                            </div>

                                            <input type="hidden" id="save_type" value="new">

                                            <div class="mb-3">
                                                <button class="btn btn-primary d-block w-100 mt-3" id="submit"
                                                    type="button">{{ __('translations.save') }}</button>
                                            </div>
                                            <div class="mb-3">
                                                <a class="btn btn-primary d-block w-100 mt-3"
                                                    href="{{ route('categories') }}">{{ __('translations.new') }}
                                                </a>
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

            if ($("#category_name").val() == "") {

            } else {
                saveCategory();
            }
        });

        function saveCategory() {
            var category_id = $('#category_id').val();
            var category_name = $('#category_name').val();
            var save_type = $('#save_type').val();
            $.post(
                '{{ url('saveCategories') }}', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    category_id: category_id,
                    category_name: category_name,
                    save_type: save_type
                },
                function(data) {
                    table_post_categories(data);
                });
        }
        // table row with ajax
        function table_post_categories(res) {
            let htmlView = '';
            for (let i = 0; i < res.categories.length; i++) {
                htmlView +=
                    `
                    <tr>
                        <td class="align-middle  ">
                            <p class="fs--1 mb-0 fw-semi-bold">` + (i + 1) + `</p>
                        </td>
                        <td class="align-middle" category_name="` + res.categories[i].category_name + `">
                            <span class="fs--1 mb-0  fw-semi-bold text-900" >` + res.categories[i].category_name + `</span></h6>
                        </td>
                        <td class="align-middle text-center" category_id="` + res.categories[i].id + `">
                            <p class="fs--1 mb-0 fw-semi-bold  far fa-edit fs-2 text-warning edit_category"></p>
                        </td>
                    </tr>
                `;
            }
            $('#bodyCategories').html(htmlView);
            $("#category_name").val('');
            $('#save_type').val('new');
            $('#category_id').val('');
        }
        $(document).on('click', '.edit_category', function() {

            const row = $(event.target).closest('tr');
            category_name = row.find('td:eq(1)').attr('category_name');
            category_id = row.find('td:eq(2)').attr('category_id');

            $('#category_name').val(category_name);
            $('#category_id').val(category_id);
            $('#save_type').val('update');
        });
    });
</script>
