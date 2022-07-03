<form action="" method="post">
    @csrf
    <input type="text" name="title" placeholder="title" required><br>
    <input type="text" name="description" placeholder="descritpion" required><br>
    <button type="submit">Create</button>
</form>


<form action="{{route('school.class.attendance')}}" method="post">
    @csrf
    @csrf
    <select type="text" name="attendance_pid" placeholder="" required>
        <option disabled selected>Select title</option>
        @foreach($data as $row)
        <option value="{{$row->pid}}">{{$row->title}}</option>
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
    <select type="text" name="category_pid" placeholder="" required>
        <option disabled selected>Select Category</option>
        @foreach($cat as $row)
        <option value="{{$row->pid}}">{{$row->category}}</option>
        @endforeach
    </select><br>
    @error('category_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror


    <button type="submit">Create</button>
</form>