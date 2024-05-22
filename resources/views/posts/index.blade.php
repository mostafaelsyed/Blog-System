@extends('layouts.app')
@section('title')
index
@endsection


@section('content')


            <div class="text-center">
                <a href="{{route('posts.create')}}" class="btn btn-success">Create Posts</a>
            </div>
            <!--start table-->
<table class="table mt-4">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">title</th>
        <th scope="col">Posted by</th>
        <th scope="col">Created at</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>

        @foreach ($posts as $post)

        <tr>
            <td scope="row">{{$post->id}}</td>
            <td>{{$post->title}}</td>
            <td>{{$post->user ? $post->user->name : 'not found'}}</td>
            <td>{{$post->created_at->format('Y-m-d')}}</td>
            <td>
                <a href="{{route('posts.show',$post->id)}}" class="btn btn-info">View</a>
                <a href="{{route('posts.edit',$post->id)}}" class="btn btn-primary">Edit</a>
              <form style="display: inline" action="{{route('postes.destroy',$post->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button  type="submit" class="btn btn-danger">Delete</button>
            </form>
            </td>
          </tr>
        @endforeach



    </tbody>
  </table>
<!--end table-->
@endsection
