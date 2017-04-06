@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.files') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.files') }}
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Files list</h3>
                    </div>
                    <div class="box-body">
                        @if(!$files->isEmpty())
                            <table class="table table-bordered table-hover">
                                <tbody><tr>
                                    <th>ID</th>
                                    <th>Mime</th>
                                    <th>Size (bytes)</th>
                                    <th>Project</th>
                                    <th>Uploaded</th>
                                </tr>
                                @foreach($files as $file)
                                    <tr>
                                        <td><a href="{{route('files.show', $file->getKey())}}" target="_blank">{{$file->getKey()}}</a></td>
                                        <td>{{$file->mime_type}}</td>
                                        <td>{{$file->size}}</td>
                                        <td>{{($file->project) ? $file->project->name : null}}</td>
                                        <td>{{$file->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            No files
                        @endif
                    </div>
                    <div class="box-footer">
                        {{$files->links()}}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
