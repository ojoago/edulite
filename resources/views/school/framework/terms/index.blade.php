<form action="" method="post">
    @csrf
    <input type="text" name="term" placeholder="school term" required><br>
    @error('term')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <!-- <input type="text" name="reg_number"><br> -->
    <button type="submit">Create</button>
</form>
<p></p>
<br>
<form action="{{route('school.term.active')}}" method="post">
    @csrf
    <select name="term_pid" id="">
        <option disabled selected>Select Session</option>
        @foreach($data as $row)
        <option value="{{$row->pid}}">{{$row->term}}</option>
        @endforeach
    </select><br>
    <input type="date" name="begin" id=""><br>
    <input type="date" name="end" id=""><br>
    <input type="text" name="note" id=""><br>
    @error('active_session')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <!-- <input type="text" name="reg_number"><br> -->
    <button type="submit">Create</button>
</form>
<!-- <h1>education is light hence EduLite</h1> -->