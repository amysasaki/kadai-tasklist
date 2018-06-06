@extends('layouts.app')

@section('content')
    @if (Auth::check())
       <?php $user = Auth::user(); ?>
       {{$user->name}}
            <div class="col-xs-8">
                @if (count($tasklists) > 0)
                    @include('tasklists.tasklists', ['tasklists' => $tasklists])
                @endif
            </div>
        </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Tasklists</h1>
                {!! link_to_route('signup.get', 'Sign up now!', null, ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection