@extends('layout.mainlayout')
@section('title','Promote Student')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Promote Student</h5>
            <p> <i class="bi bi-calendar-event-fill"></i> {{sessionName(session('session')) }} {{termName(session('term'))}}</p>
            <table class="table table-bordered border-primary cardTable" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Reg-Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Next Class</th>
                        <th scope="col">Class Arm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student as $row)
                    <tr class="studentId" id="">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->reg_number}}</td>
                        <td>{{ $row->fullname }}</td>
                        <form method="post" action="{{route('promote.student')}}">
                            @csrf
                            <td scope="col">
                                <select name="" id="" class="form-control form-control-sm" required>
                                    <option disabled selected>Select Next Class</option>
                                    @foreach($nextClass as $row)
                                    <option value="{{$row->pid}}" @php echo $row->class_number==$currentClassNumber+1 ? 'selected':'' @endphp >{{$row->class}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td scope="col">
                                <select name="next_class[]" id="" class="form-control form-control-sm" required>
                                    <option disabled selected>Select Class Arm</option>
                                    @foreach($nextArm as $row)
                                    <option value="{{$row->pid}}" @php echo $row->arm_number==$armNumber ? 'selected':'' @endphp>{{$row->arm}}</option>
                                    @endforeach
                                </select>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
                <tbody>
                    <tr>
                        <td colspan="3">
                        </td>
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </td>
                    </tr>
                </tbody>
                </form>
            </table>
            <!-- End Primary Color Bordered Table -->

        </div>
    </div>
</div>

<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {

    });
</script>
@endsection