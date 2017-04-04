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

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Projects list</h3>
                        <a href="{{route('my-projects.create')}}" class="btn btn-primary btn-flat btn-md pull-right">New</a>
                    </div>
                    <div class="box-body">
                        @if(!$projects->isEmpty())
                            <table class="table table-bordered table-hover">
                                <tbody><tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th width="140">Manage</th>
                                </tr>
                                @foreach($projects as $project)
                                    <tr>
                                        <td>{{$project->getKey()}}</td>
                                        <td>{{$project->name}}</td>
                                        <td>{{$project->description}}</td>
                                        <td>{{$project->created_at}}</td>
                                        <td>
                                            <a class="btn btn-default btn-flat btn-md" href="{{route('my-projects.edit', $project->getKey())}}">Edit</a>
                                            {!! Form::open(['route' => ['my-projects.destroy', $project->getKey()], 'method' => 'delete', 'class' => 'pull-right', 'onsubmit' => 'return confirm("Are you sure?")']) !!}
                                                {!! Form::submit('Delete',['class' => 'btn btn-default btn-flat btn-md']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            No projects
                        @endif
                    </div>
                    <div class="box-footer">
                        {{$projects->links()}}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
