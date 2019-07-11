@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
  <a href="{{ route('posts.create') }}" class="btn btn-success">Add Post</a>
</div>

<div class="card card-default">
  <div class="card-header">
    Posts
  </div>
  <div class="card-body">
    @if($posts->count() > 0)
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Image</th>
          <th scope="col">Title</th>
          <th scope="col">Category</th>
          <th colspan="2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($posts as $post)
          <tr>
            <td class="align-middle">
              <img src="{{asset('storage/'.$post->image)}}" width="60px" height="60px">
            </td>
            <td class="align-middle">{{$post->title}}</td>
            <td class="align-middle">
              <a href="{{ route('categories.edit', $post->category->id) }}">
                {{$post->category->name}}
              </a>             
            </td>           
            <td class="align-middle text-right">
            @if($post->trashed())
              <form action="{{ route('restore-post', $post->id) }}" class="d-inline" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-link"><i class="fas fa-redo"></i></button>
              </form>             
            @else
              <a href="{{route('posts.edit', $post->id)}}" class="text-info d-inline"><i class="fas fa-edit"></i></a>
            @endif             
              <form action="{{route('posts.destroy', $post->id)}}" class="d-inline" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link text-danger">
                  @if($post->trashed())
                    <i class="fas fa-minus-circle"></i>
                  @else
                    <i class="fas fa-trash-alt"></i>
                  @endif
                </button>
              </form>
            </td>
          </tr>
          @if($post->tags->count() > 0)
          <tr>
            <td colspan="4">
              @foreach($post->tags as $tag)
                <span class="badge badge-secondary">{{ $tag->name }}</span>
              @endforeach             
            </td>
          </tr>
          @endif
        @endforeach
      </tbody>
    </table>
    @else
    <div class="text-center">
      No posts available
    </div>
    @endif
  </div>
</div>
@endsection