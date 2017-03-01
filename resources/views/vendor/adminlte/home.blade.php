@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
	{{ trans('adminlte_lang::message.home') }}
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
						<table class="table table-bordered table-hover">
							<tbody><tr>
								<th>ID</th>
								<th>Name</th>
								<th>Extension</th>
								<th>Mime</th>
								<th>Size</th>
								<th>Uploaded</th>
							</tr>
							@foreach($files as $file)
								<tr>
									<td>{{$file->id}}</td>
									<td>{{$file->name}}</td>
									<td>{{$file->extension}}</td>
									<td>{{$file->mime_type}}</td>
									<td>{{$file->size}}</td>
									<td>{{$file->created_at}}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
					<div class="box-footer">
						{{$files->links()}}
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
