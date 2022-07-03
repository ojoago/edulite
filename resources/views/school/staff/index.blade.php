{{flashMessage()}}
<form action="" method="post">
    @csrf
    <select type="text" name="role_id" placeholder="" required>
        <option disabled selected>Select State</option>
        <option value="1">admin</option>
    </select><br>
    @error('state_id')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <input type="text" name="staff_id" placeholder="staff ID" required><br>
    <!-- <input type="text" name="staff_id" placeholder="staff_pid" required><br> -->
    @error('names')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <!-- <input type="text" name="reg_number"><br> -->
    <button type="submit">Create</button>
</form>
<br><br><br>

<form action="{{route('school.staff.class')}}" method="post">
    @csrf
    <select type="text" name="staff_pid" placeholder="" required>
        <option disabled selected>Select State</option>
        @foreach($data as $row)
        <option value="{{$row->pid}}">{{$row->staff_id}}</option>
        @endforeach
    </select><br>
    @error('staff_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <select type="text" name="arm_pid" placeholder="" required>
        <option disabled selected>Select Arm</option>
        @foreach($arm as $row)
        <option value="{{$row->pid}}">{{$row->arm}}</option>
        @endforeach
    </select><br>
    @error('class_arm_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <select type="text" name="session_pid" placeholder="" required>
        <option disabled selected>Select Session</option>
        @foreach($session as $row)
        <option value="{{$row->pid}}">{{$row->session}}</option>
        @endforeach
    </select><br>
    @error('session_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <select type="text" name="term_pid" placeholder="" required>
        <option disabled selected>Select Term</option>
        @foreach($term as $row)
        <option value="{{$row->pid}}">{{$row->term}}</option>
        @endforeach
    </select><br>
    @error('term_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <button type="submit">Create</button>
</form>

<br><br><br>

<form action="{{route('school.staff.subject')}}" method="post">
    @csrf
    @csrf
    <select type="text" name="staff_pid" placeholder="" required>
        <option disabled selected>Select State</option>
        @foreach($data as $row)
        <option value="{{$row->pid}}">{{$row->staff_id}}</option>
        @endforeach
    </select><br>
    @error('staff_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <select type="text" name="arm_pid" placeholder="" required>
        <option disabled selected>Select Arm</option>
        @foreach($arm as $row)
        <option value="{{$row->pid}}">{{$row->arm}}</option>
        @endforeach
    </select><br>
    @error('class_arm_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <select type="text" name="session_pid" placeholder="" required>
        <option disabled selected>Select Session</option>
        @foreach($session as $row)
        <option value="{{$row->pid}}">{{$row->session}}</option>
        @endforeach
    </select><br>
    @error('session_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror

    <select type="text" name="term_pid" placeholder="" required>
        <option disabled selected>Select Term</option>
        @foreach($term as $row)
        <option value="{{$row->pid}}">{{$row->term}}</option>
        @endforeach
    </select><br>
    @error('term_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <select type="text" name="subject_pid" placeholder="" required>
        <option disabled selected>Select Subject</option>
        @foreach($sbj as $row)
        <option value="{{$row->pid}}">{{$row->subject}}</option>
        @endforeach
    </select><br>
    @error('class_arm_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror


    <button type="submit">Create</button>
</form>

<br><br><br>