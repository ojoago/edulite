<form action="" method="post">
    @csrf
    <input type="text" name="session" placeholder="school session" required><br>
    @error('session')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <!-- <input type="text" name="reg_number"><br> -->
    <button type="submit">Create</button>
</form>
<p></p>
<br>
<form action="{{route('school.session.active')}}" method="post">
    @csrf
    <select name="session_pid" id="">
        <option disabled selected>Select Session</option>
        @foreach($data as $row)
        <option value="{{$row->pid}}">{{$row->session}}</option>
        @endforeach
    </select>
    @error('active_session')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <!-- <input type="text" name="reg_number"><br> -->
    <button type="submit">Create</button>
</form>
<!-- <h1>education is light hence EduLite</h1> -->