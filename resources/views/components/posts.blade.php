
 <p>
    @foreach ($tags as $tag)
        <a href="#" class="badge badge-success badge-lg">{{ $tag->name }}</a>
    @endforeach
 </p>

<x-tags :tags="$post->tags" />

<p class ="text-muted">
Added {{$post->created_at->diffForHumans()}}
by {{$post->user->name}}
</p>
