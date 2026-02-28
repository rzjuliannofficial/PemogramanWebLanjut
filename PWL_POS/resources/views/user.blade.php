<!DOCTYPE html>
<html>
<head>
    <title>Daftar User</title>
</head>
<body>
    <h1>Daftar User</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>User ID</th>
            <th>Level ID</th>
            <th>Username</th>
            <th>Nama</th>
        </tr>
        @foreach($data as $user)
        <tr>
            <td>{{ $user->user_id }}</td>
            <td>{{ $user->level_id }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->nama }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
