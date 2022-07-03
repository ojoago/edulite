<form action="{{route('school.category')}}" method="post">
    @csrf
    <input type="text" name="category" placeholder="school category" required><br>
    @error('names')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="description" placeholder="description" required><br>
    @error('school_contact')
    <p class="text-danger">{{$message}}</p>
    @enderror
    
    <!-- <input type="text" name="reg_number"><br> -->
    <button type="submit">Create</button>
</form>
<p></p>
<br>
<form action="" method="post">
    @csrf
    <select name="category_pid" id="">
        <option disabled selected>Select School Category</option>
        @foreach($data as $row)
            <option value="{{$row->pid}}">{{$row->category}}</option>
        @endforeach
    </select><br>
    <input type="text" name="class" placeholder="class" required><br>
    @error('class')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <button type="submit">Create</button>
</form>
<p></p>
<br>
<form action="{{route('school.arm')}}" method="post">
    @csrf
    <select name="class_pid" id="">
        <option disabled selected>Select School class</option>
        @foreach($class as $row)
            <option value="{{$row->pid}}">{{$row->class}}</option>
        @endforeach
    </select><br>
    <input type="text" name="arm" placeholder="class arm" required><br>
    @error('class')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <button type="submit">Create</button>
</form>


<h1>education is light hence EduLite</h1>