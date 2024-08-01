@extends('layout.mainlayout')
@section('title','School Result Details')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">School Result Details</h5>
            <p>{{$data->session}} {{$data->term}}  </p>

                <table class="table table-hover table-striped table-bordered cardTable" width="100%" id="resultDataTable">
                    <thead>
                        <tr>

                            <th width="5%">S/N</th>
                            
                            <th>Class Arm</th>
                            <th>Students</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->classes as $row)
                            <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->arm}}</td>
                            <td>{{$row->students}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
    </div>
</div>

<script>
    $(document).ready(function() {
    

    });
</script>


@endsection