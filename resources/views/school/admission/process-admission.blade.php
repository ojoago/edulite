@extends('layout.mainlayout')
@section('title','Promote Student')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Process Admission</h5>
            <p> <i class="bi bi-calendar-event-fill"> </i> {{activeSessionName() }} {{activeTermName()}}</p>
            <table class="table table-bordered border-primary cardTable" id="scoreTable">
                <thead>
                    <tr>
                        <th scope="col" width="5%">S/N</th>
                        <th scope="col">Application Number</th>
                        <th scope="col">Names</th>
                        <th scope="col">Class</th>
                        <th scope="col">Class Arm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr class="studentId" id="">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->admission_number}}</td>
                        <td>{{ $row->fullname }}</td>
                        <form method="post" action="">
                            @csrf
                            <input type="hidden" name="pid[]" value="{{$row->pid}}">
                            <td scope="col">
                                <select name="class[]" id="" class="form-control form-control-sm" required>
                                    <option disabled selected>Select Next Class</option>
                                    @foreach($class as $cls)
                                    <option value="{{$cls->pid}}" @php echo $cls->pid==$row->class_pid ? 'selected':'' @endphp >{{$cls->class}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td scope="col">
                                <select name="arm[]" id="" class="form-control form-control-sm" required>
                                    <option disabled selected>Select Class Arm</option>
                                    @foreach(loadClassArms($row->class_pid) as $arm)
                                    <option value="{{$arm->pid}}" @php echo $arm->pid==$row->arm_pid ? 'selected':'' @endphp >{{$arm->arm}}</option>
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
                            <button type="submit" class="btn btn-primary btn-sm">Confirm</button>
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