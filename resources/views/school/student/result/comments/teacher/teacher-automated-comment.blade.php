@extends('layout.mainlayout')
@section('title','Class teacher automated comment')
@section('content')

<section class="section d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Class Teacher Default Comments
                    <button class="btn btn-primary btn-sm " data-bs-toggle="modal" data-bs-target="#teacherAutomateComment">Add New</button>

                </h5>
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

<div class="modal fade" id="teacherAutomateComment" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Class Teacher Defined Comment</small></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="teacherCommentForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select type="text" name="category" class="form-control" id="formCategorySelect2" required>
                                </select>
                                <p class="text-danger category_error"></p>
                            </div>
                        <div class="col-md-6">
                                <label for="category" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control form-control-sm" id="automateCommentTitle" placeholder="enter a unique title " required>
                                <p class="text-danger title_error"></p>
                            </div>
                            <div class="col-md-6">
                                <label for="session" class="form-label">Minimum Score</label>
                                <input type="text" name="min" class="form-control form-control-sm" placeholder="e.g 20" id="minScore">
                                <p class="text-danger min_error"></p>
                            </div>
                            <div class="col-md-6">
                                <label for="class" class="form-label">Maximum Score</label>
                                <input type="text" name="max" class="form-control form-control-sm" placeholder="e.g 39.9" id="maxScore">
                                <p class="text-danger max_error"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="arm" class="form-label">Comment</label>
                                <textarea type="text" name="comment" class="form-control form-control-sm" id="comment"></textarea>
                                <p class="text-danger comment_error"></p>
                            </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="teacherCommentBtn">Submit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</section>
<script>
    $(document).ready(function() {

        // multiSelect2('#formCategorySelect2', 'category', 'Select Category');
        multiSelect2('#formCategorySelect2','teacherAutomateComment', 'category', 'Select Category');

        $('#teacherCommentBtn').click(async function() {
            let sts = await submitFormAjax('teacherCommentForm', 'teacherCommentBtn', "{{route('teacher.automated.comments')}}");
            if(sts && sts.status == 1){
               loadteacherComments()
           }
        });

        loadteacherComments()
        // teacherCommentTable
        function loadteacherComments() {
            $('#teacherCommentTable').DataTable({
                "processing": true,
                "serverSide": true,
               
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