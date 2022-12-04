@extends('layout.mainlayout')
@section('title','Class teacher automated comment')
@section('content')

<section class="section d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-3 d-flex flex-column align-items-center justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <p class="text-center small">class teacher Default Comment</p>
                        </div>
                        <form class="row g-3" id="teacherCommentForm">
                            @csrf
                            <div class="col-12">
                                <label for="category" class="form-label">Category</label>
                                <select type="text" name="category" class="form-control" id="formCategorySelect2" required>
                                </select>
                                <p class="text-danger category_error"></p>
                            </div>
                            <div class="col-12">
                                <label for="session" class="form-label">Minimum Score</label>
                                <input type="text" name="min" class="form-control form-control-sm" placeholder="e.g 20" id="minScore">
                                <p class="text-danger min_error"></p>
                            </div>
                            <div class="col-12">
                                <label for="class" class="form-label">Maximum Score</label>
                                <input type="text" name="max" class="form-control form-control-sm" placeholder="e.g 39.9" id="maxScore">
                                <p class="text-danger max_error"></p>
                            </div>
                            <div class="col-12">
                                <label for="arm" class="form-label">Comment</label>
                                <textarea type="text" name="comment" class="form-control form-control-sm" id="comment"></textarea>
                                <p class="text-danger comment_error"></p>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="button" id="teacherCommentBtn">Subject</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Class Teacher Default Comments</h5>
                        <table class="table display nowrap table-bordered table-striped table-hover mt-3 cardTable" width="100%" id="teacherCommentTable">
                            <thead>
                                <tr>
                                    <th width="5%">S/N</th>
                                    <th>Minimum</th>
                                    <th>Maximum</th>
                                    <th>Comment</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Teacher</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {

        FormMultiSelect2('#formCategorySelect2', 'category', 'Select Category');
        $('#teacherCommentBtn').click(function() {
            submitFormAjax('teacherCommentForm', 'teacherCommentBtn', "{{route('teacher.automated.comments')}}");
            loadteacherComments()
        });

        loadteacherComments()
        // teacherCommentTable
        function loadteacherComments() {
            $('#teacherCommentTable').DataTable({
                "processing": true,
                "serverSide": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                destroy: true,
                type: "GET",
                "ajax": "{{route('load.teacher.automated.comments')}}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        "data": "min"
                    },
                    {
                        "data": "max"
                    },
                    {
                        "data": "comment"
                    },
                    {
                        "data": "category"
                    },
                    {
                        "data": "date"
                    },
                    {
                        "data": "fullname"
                    },
                    // {
                    //     "data": "action",
                    // },
                ],
            });
        }

    });
</script>
@endsection