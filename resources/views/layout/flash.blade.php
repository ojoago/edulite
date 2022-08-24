@if($mesaage = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>{{$mesaage}}!</strong>
</div>
@endif
@if($mesaage = Session::get('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>{{$mesaage}}!</strong>
</div>
@endif
@if($mesaage = Session::get('info'))
<div class="alert alert-info alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>{{$mesaage}}!</strong>
</div>
@endif
@if($mesaage = Session::get('warning'))
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>{{$mesaage}}!</strong>
</div>
@endif

{{--@if($mesaage = Session::get('primary'))
<div class="alert alert-primary alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>{{$mesaage}}!</strong>
</div>
@endif --}}