@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
  <a href="{{ route('tags.create') }}" class="btn btn-success">Add Tag</a>
</div>

<div class="card card-default">
  <div class="card-header">
    Tags
  </div>
  <div class="card-body">
  @if($tags->count() > 0)
    <table class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Post Count</th>
          <th scope="col"></th>
        </tr>              
      </thead>
      <tbody>
        @foreach($tags as $tag)
          <tr>
            <td>
              {{ $tag->name }}
            </td>
            <td>
              {{ $tag->posts->count() }}
            </td>
            <td class="text-right">
              <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-primary btn-sm">Edit</a>
              <button class="btn btn-danger btn-sm" onclick="handleDelete({{ $tag->id }})">Delete</button>
            </td>          
          </tr>     
        @endforeach
      </tbody>
    </table>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form id="deleteTagForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Delete Tag</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure you wish to delete this tag?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Yes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="text-center">
    No tags available
  </div>
  @endif
</div>
@endsection

@section('scripts')
  <script>
    function handleDelete(id){
      let form = document.getElementById('deleteTagForm');
      form.action = '/tags/' + id;
      $('#deleteModal').modal('show');
    }
  </script>
@endsection