@foreach($data as $row)
<a href="{{route('update.organisation',[base64Encode($row->pid)])}}">{{$row->names}}</a><br>
@endforeach
<a href="{{route('organisation.users')}}">Org Users</a>
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
    <input type="text" name="names" placeholder="name of Organisation" required><br>
    @error('names')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <input type="text" name="reg_number" placeholder="Registration Number" required><br>
    @error('reg_number')
    <p class="text-danger">{{$message}}</p>
    @enderror
    <!-- <input type="text" name="reg_number"><br> -->
    <button type="submit">Create</button>
</form>