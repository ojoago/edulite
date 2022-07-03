<form action="" method="post">
    @csrf
    <input type="text" name="reg_number" id="" required>
    <select type="text" name="user_pid" placeholder="" required>
        <option disabled selected>Select State</option>
        @foreach($data as $row)
        <option value="{{$row->pid}}">{{$row->username}}</option>
        @endforeach
    </select><br>
    @error('user_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <select type="text" name="school_pid" placeholder="" required>
        <option disabled selected>Select User</option>
        @foreach($school as $row)
        <option value="{{$row->pid}}">{{$row->school_name}}</option>
        @endforeach
    </select><br>
    @error('school_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <select type="text" name="class_arm_pid" placeholder="" required>
        <option disabled selected>Select arm</option>
        @foreach($arm as $row)
        <option value="{{$row->pid}}">{{$row->arm}}</option>
        @endforeach
    </select><br>
    @error('class_arm_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror
   
    <!-- <input type="text" name="reg_number"><br> -->
    <button type="submit">Create</button>
</form>