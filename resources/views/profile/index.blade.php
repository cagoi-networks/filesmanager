@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Profile Settings
@endsection

@section('contentheader_title')
    Profile Settings
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profile settings</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('API Token') !!}
                            <div class="input-group">
                                {!! Form::text('text', Auth::user()->api_token, ['class' => 'form-control']) !!}
                                <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
