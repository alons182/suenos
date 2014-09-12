@extends('layouts.layout')

@section('content')
<h1>{{ $currentUser->username }} | <small>{{ $currentUser->profiles->present()->fullname }}</small></h1>
<small>{{ $currentUser->present()->accountAge }} </small>

<h2>Tu red de usuarios</h2>

<!--{{ matriz_table( $currentUser->descendants()->get()->toArray(), $currentUser->descendants()->count() ) }}-->
@for ($i = 1; $i <= 15 ; $i++)
    @foreach ($currentUser->descendants()->get() as $child)
        @if ($child->depth == $i )
            <li class="nivel-{{ $i }}">{{ get_depth($child->depth)}}  {{ $child->username }} - <small>{{ $child->children->count() }}</small>  </li>
        @endif

    @endforeach
    <div class="division-{{ $i }}"><br/></div>

@endfor



<p>
    @if ($currentUser->isCurrent())
    {{ link_to_route('profile.edit', 'Edit your Profile', $currentUser->username) }}
    @endif
</p>

@stop