{{flashMessage()}}
<form action="" method="post">
    @csrf

    <input type="text" name="subject" placeholder="name of school" required><br>
    @error('subject')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="description" placeholder="phone number" required><br>
    @error('description')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <button type="submit">Create</button>
</form>
<p></p>
<br>
<form action="{{route('school.subject')}}" method="post">
    @csrf
    <select name="subject_type_pid" id="">
        <option disabled selected>Select Subject Type</option>
        @foreach($data as $row)
            <option value="{{$row->pid}}">{{$row->subject}}</option>
        @endforeach
    </select>
    <input type="text" name="subject" placeholder="name of school" required><br>
    @error('subject')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="description" placeholder="phone number" required><br>
    @error('description')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <button type="submit">Create</button>
</form>