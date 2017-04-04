@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.projects') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.projects') }}
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('errors'))
                    <div class="callout callout-danger">
                        <h4>Errors</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ trans($error) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create new project</h3>
                    </div>
                    {!! Form::open(['route' => 'my-projects.store']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter project name']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('description', 'Description') !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter project description']) !!}
                            </div>
                        </div>
                        <div class="box-footer">
                            {!! Form::submit('Save',['class' => 'btn btn-primary btn-flat btn-md']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
