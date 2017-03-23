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
						<h3 class="box-title">Statistic</h3>
					</div>
					<div class="box-body">
						<div class="chart">
							<!-- Sales Chart Canvas -->
							<canvas id="salesChart" style="height: 180px; width: 1038px;" height="180" width="1038"></canvas>
						</div>
					</div>
					<div class="box-footer">

					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
