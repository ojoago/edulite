@extends('layout.mainlayout')
@section('title','Promote Student')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Swap Student</h5>
            <p> <i class="bi bi-calendar-event-fill"></i> {{$data[0]->arm}}</p>
            <table class="table table-bordered border-primary cardTable" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col" width="5%">S/N</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr class="studentId" id="{{$row->pid}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->reg_number}}</td>
                        <td>{{ $row->fullname }}</td>
                        <td scope="col" width="5%" align="center">
                            <button class="btn btn-sm btn-info swapStudent" pid="{{$row->pid}}"><i class="bi bi-subtract pointer" title="Swap Student" data-bs-toggle="tooltip"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Primary Color Bordered Table -->

        </div>
    </div>
</div>

<!-- hire me  -->
<div class="modal fade" id="swapStudentModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase text-info">Swap Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="swapStudentForm">
                    @csrf
                    <div class="col-12">
                        <label for="category" class="form-label">Category</label>
                        <select type="text" name="category" class="form-control" id="formCategorySelect2" required>
                        </select>
                        <p class="text-danger category_error"></p>
                        <input type="hidden" name="pid" id="studentPid">
                    </div>
                    <div class="col-12">
                        <label for="class" class="form-label">Class</label>
                        <select type="text" name="class" class="form-control" id="formClassSelect2">
                        </select>
                        <p class="text-danger class_error"></p>
                    </div>
                    <div class="col-12">
                        <label for="arm" class="form-label">Class Arm</label>
                        <select type="text" name="arm" class="form-control" id="formArmSelect2">
                        </select>
                        <p class="text-danger arm_error"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button class="btn btn-primary btn-sm" type="button" id="swapStudentBtn">Submit</button>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.swapStudent').click(function() {
            let pid = $(this).attr('pid');
            $('#studentPid').val(pid);
            $('#swapStudentModal').modal('show');
        })

        multiSelect2('#formCategorySelect2', 'swapStudentModal', 'category', 'Select Category');
        $('#formCategorySelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#formClassSelect2', 'swapStudentModal', 'class', id, 'Select Class');
        });
        $('#formClassSelect2').on('change', function(e) {
            var id = $(this).val();
            multiSelect2Post('#formArmSelect2', 'swapStudentModal', 'class-arm', id, 'Select Class Arm');
        });

        // swap student
        $('#swapStudentBtn').click(async function() {
            data = await submitFormAjax('swapStudentForm', 'swapStudentBtn', "{{route('swap.student')}}");
            if (data.status === 1) {
                var pid = $('#studentPid').val();
                $('table#scoreTable tr#' + pid).remove();
            }
        });

    });
</script>
@endsection