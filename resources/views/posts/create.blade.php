@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="card card-default">
  <div class="card-header">
    {{ isset($post) ? 'Edit Post' : 'Create Post' }}
  </div>
  <div class="card-body">
    @include('partials.errors')
    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @if(isset($post))
        @method('PUT')
      @endif
      <div class="form-group">
        <label for="title">Title</label>
        <input id="title" class="form-control" type="text" name="title" value="{{ isset($post) ? $post->title : '' }}">        
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea rows="2" id="description" class="form-control" name="description">{{ isset($post) ? $post->description : '' }}</textarea>    
      </div>
      <div class="form-group">
        <label for="content">Content</label>
        <input id="content" type="hidden" name="content" value="{{ isset($post) ? $post->content : '' }}">
        <trix-editor input="content"></trix-editor>   
      </div>
      <div class="form-group">
        <label for="published_at">Published At</label>
        <input id="published_at" class="form-control" type="text" name="published_at" value="{{ isset($post) ? $post->published_at : '' }}">        
      </div>
      @if(isset($post))
      <div class="form-group">
        <img src="{{asset('storage/'.$post->image)}}" width="100%" height="500px">
      </div>
      @endif
      <div class="form-group">
        <label for="fileUpload">Image</label>
        <div class="custom-file" id="fileUpload">
          <input type="file" class="custom-file-input" name="image" id="imageUpload">
          <label class="custom-file-label" for="imageUpload">Choose image...</label>
        </div>
      </div> 
      <div class="form-group">
        <label for="selCategories">Category</label>
        <select id="selCategories" name="category" class="form-control">
          @foreach($categories as $category)
            <option value="{{$category->id}}"
            @if(isset($post))
              @if($category->id == $post->category_id)
                selected
              @endif
            @endif
            >{{$category->name}}</option>
          @endforeach
        </select>
      </div>    
      @if($tags->count() > 0)
      <div class="form-group">
        <label for="tags">Tags</label>
        <select id="tags" name="tags[]" class="form-control" multiple>
          @foreach($tags as $tag)
            <option value="{{$tag->id}}"
            @if(isset($post))
              @if($post->hasTag($tag->id))
                selected
              @endif
            @endif            
            >
              {{$tag->name}}
            </option>
          @endforeach
        </select>
      </div>
      @endif
      <div class="form-group">
        <button class="btn btn-primary">
          {{ isset($post) ? 'Save Changes' : 'Create Post' }}
        </button>
      </div>  
    </form>
  </div>
</div>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
  <script type="text/javascript">
    $("#published_at").flatpickr({
      enableTime: true
    });

    $("#tags").select2({
      tags: true,
      tokenSeparators: [',', ' ']
    });
  </script>
@endsection