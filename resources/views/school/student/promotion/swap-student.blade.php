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
                    <tr class="studentId" id="">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->reg_number}}</td>
                        <td>{{ $row->fullname }}</td>
                        <td scope="col" width="5%" align="center">
                            <i class="bi bi-subtract pointer" title="Swap Student" ></i>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
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