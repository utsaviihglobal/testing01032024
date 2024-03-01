@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-2">
                <a href="/create-sub-user"><button type="submit" class="btn btn-primary">Create the user</button></a>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Sub User List ') }}</div>


                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Profile photo</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i =1; @endphp
                            @foreach($subuser as $user)
                            <tr>
                                <th scope="row">{{$i}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    <img width="150px" src="{{ asset('profile_photo/' . $user->profile_photo) }}">
                                </td>
                                <td>
                                    <a type="button" class="btn btn-primary mb-4" href="/edit/{{$user->id}}">Edit</a>
                                    <a type="button" class="btn btn-danger" onclick="deleteSubuser({{$user->id}})">Delete</a>
                                </td>
                            </tr>

                            @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function deleteSubuser(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: '/delete/' + id,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    }
</script>
@endsection