@extends('master')
@section('container')


<div class="panel panel-primary">
<div class="panel-heading">
	<strong><a href="{{ url('aslab_pratikum') }}">
	<i style="color:white;" class="fa text-default fa-chevron-left"></i></a>
	Tambah Data Dosen Matakuliah</strong>
	</div>
		{!! Form::open(['url'=>'aslab_pratikum/simpan','class'=>'form-horizontal']) !!}
		@include('aslab_pratikum.form')
		<div style="width: 100%;text-align: right;">
				<button class="btn btn-primary"><i class="fa fa-save"></i>Simpan</button>
				
</div>
{!! Form::close() !!}
</div>

@stop

