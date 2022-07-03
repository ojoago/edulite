<form action="" method="post">
    @csrf
    <input type="text" name="title" placeholder="ass title" required><br>
    @error('title')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="category" placeholder="ass cat" required><br>
    @error('category')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="description" placeholder="ass dsc" required><br>
    @error('description')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <button type="submit">Create</button>
</form>

<form action="{{route('school.score.settings')}}" method="post">

    @csrf
    <select type="text" name="assessment_type_pid" placeholder="" required>
        <option disabled selected>Select Title</option>
        @foreach($data as $row)
        <option value="{{$row->pid}}">{{$row->title}}</option>
        @endforeach
    </select><br>
    @error('assessment_type_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <select type="text" name="session_pid" placeholder="" required>
        <option disabled selected>Select Title</option>
        @foreach($session as $row)
        <option value="{{$row->pid}}">{{$row->session}}</option>
        @endforeach
    </select><br>
    @error('session_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <select type="text" name="class_arm_pid" placeholder="" required>
        <option disabled selected>Select Title</option>
        @foreach($arm as $row)
        <option value="{{$row->pid}}">{{$row->arm}}</option>
        @endforeach
    </select><br>
    @error('class_arm_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <select type="text" name="term_pid" placeholder="" required>
        <option disabled selected>Select Title</option>
        @foreach($term as $row)
        <option value="{{$row->pid}}">{{$row->term}}</option>
        @endforeach
    </select><br>
    @error('term_pid')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="score" required><br>
    <input type="text" name="type" required><br>
    <input type="text" name="order" required><br>
    <button type="submit">Submit</button>
</form>
score
type