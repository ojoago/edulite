@extends('layout.mainlayout')
@section('title','lite')
@section('content')
@foreach($data as $row)
<a href="{{route('login.school',[base64Encode($row->pid)])}}">{{$row->school_name}}</a><br>
<a href="{{route('school.staff',[base64Encode($row->pid)])}}">Staff</a><br>
@endforeach
<a href="{{route('school.class')}}">Class</a><br>
<a href="{{route('school.session')}}">Session</a><br>
<a href="{{route('school.term')}}">Term</a><br>
<a href="{{route('school.subject.type')}}">SType</a><br>
<a href="{{route('school.assessment.title')}}">Asses</a><br>
<a href="{{route('school.grade.key')}}">Gray</a><br>
<a href="{{route('school.attendance')}}">Atend</a><br>
<a href="{{route('school.registration')}}">reg</a><br>
<a href="{{route('school.users')}}">school Users</a>
{{flashMessage()}}
<form action="" method="post">
    @csrf
    <select type="text" name="state_id" placeholder="" required>
        <option disabled selected>Select State</option>
        <option value="1">Kogi</option>
    </select><br>
    @error('state_id')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <select type="text" name="lga_id" placeholder="" required>
        <option disabled selected>Select State</option>
        <option value="1">Ankpa</option>
    </select><br>
    @error('lga_id')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="school_name" placeholder="name of school" required><br>
    @error('names')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="school_contact" placeholder="phone number" required><br>
    @error('school_contact')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="school_address" placeholder="address" required><br>
    @error('school_address')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="school_moto" placeholder="school moto" required><br>
    @error('school_moto')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="school_handle" placeholder="Schoo handle" required><br>
    @error('school_handle')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <!-- <input type="text" name="reg_number"><br> -->
    <button type="submit">Create</button>
</form>
@endsection


<!-- school_logo
school_website -->

<!-- <h1>education is light hence EduLite</h1> -->