<form action="" method="post">
    @csrf
    <input type="text" name="org_pid" id="" value="16712560J5U0026N927523U1SN67"><br>
    <input type="text" name="user_pid" id="" value="{{getUserPid()}}"><br>
    <button type="submit">Submit</button>
</form>
<form action="{{route('organisation.user.access')}}" method="post">
    @csrf
    <input type="text" name="org_user_pid" id="" value=""><br>
    <input type="text" name="access" id="" value=""><br>
    <button type="submit">Submit</button>
</form>
{{dd($data)}}