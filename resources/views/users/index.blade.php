@extends('layouts.app')

@section('content')
<div class="card card-default">
  <div class="card-header">
    Users
  </div>
  <div class="card-body">
    @if($users->count() > 0)
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Avatar</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th colspan="2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td class="align-middle">
              <img src="{{ Gravatar::src($user->email) }}" height="40px" width="40px" alt="Avatar">
            </td>
            <td class="align-middle">{{$user->name}}</td>
            <td class="align-middle">{{$user->email}}</td>           
            <td class="align-middle text-right">
              @if(!$user->isAdmin())
                <form action="{{ route('users.make-admin', $user->id) }}" method="POST">
                  {{-- Cross Site Request Forgery Token --}}
                  @csrf
                  <button type="submit" class="btn btn-primary btn-sm">Make Admin</button>
                </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <div class="text-center">
      No users available
    </div>
    @endif
  </div>
</div>
@endsection