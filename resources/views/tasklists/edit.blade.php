@extends('layouts.app')

@section('content')

    <h1>id: {{ $tasklist->id }} のタスク編集ページ</h1>

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    
    <div class="row">
        <div class="col-xs-12">
        <div class="col-offset-2 col-sm-8">
        <div class="col-offset-3 col-md-6">
    </div>
            {!! Form::model($tasklist, ['route' => ['tasklists.update', $tasklist->id], 'method' => 'put']) !!}
                <div class="form-group">
                    {!! Form::label('status', 'ステータス:') !!}
                    {!! Form::text('status') !!}
                </div>
        
                <div class="form-group">
                    {!! Form::label('content', 'タスク:') !!}
                    {!! Form::text('content') !!}
                </div>
        
                {!! Form::submit('更新', ['class' => 'btn btn-default']) !!}

            {!! Form::close() !!}
        </div>
    </div>
    
@endsection