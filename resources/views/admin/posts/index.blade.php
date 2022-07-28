@extends('admin.layouts.base')

@section('mainContent')
    @if (session('deleted'))
        <div class="alert alert-error">
            {{ session('deleted') }}
        </div>
    @endif
    <h1>Posts</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Slug</th>
                <th>Title</th>
                <th>Author</th>
                <th>Birth</th>
                <th>Category</th>
                <th>Tags</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr data-id="{{ $post->slug }}">
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->user->userDetails->birth }}</td>
                    <td>
                        <a href="{{ route('admin.categories.show', ['category' => $post->category]) }}">
                        {{ $post->category->name }}
                        </a>
                    </td>

                    {{-- <td>{{ $post->tags->pluck('name')->join(', ', ' and ') }}</td> --}}

                    <td>
                        @foreach($post->tags as $tag)
                            <a href="">{{ $tag->name }}</a>
                            @if(!$loop->last) , @endif
                        @endforeach
                    </td>

                    <td class="actions">
                        <a href="{{ route('admin.posts.show', ['post' => $post]) }}" class="btn btn-primary">View</a>

                        @if(Auth::id() == $post->user_id)
                            <a href="{{ route('admin.posts.edit', ['post' => $post]) }}" class="btn btn-warning">Edit</a>
                            <button class="btn btn-danger js-delete">Delete</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}

    <section class="overlay d-none">
        <form class="popup" data-action="{{ route('admin.posts.destroy', ['post' => '*****']) }}" method="post">
            @csrf
            @method('DELETE')

            <h1>Sei sicuro?</h1>
            <button type="submit" class="btn btn-warning js-yes">Yes</button>
            <button type="button" class="btn btn-danger js-no">No</button>
        </form>
    </section>
@endsection
