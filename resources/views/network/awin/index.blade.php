@extends('layouts.masterClone')

@section('title', 'Awin')


@section('content')
    <h1 class="page-title">Networks</h1>
    <div class='row-fluid'>
        <div class="span12">

            <div class="widget blue">
                <div class="widget-title">
                    <h4> Networks</h4>
                    <span class="tools">

                    </span>
                </div>
                <div class="widget-body">
                    <div class="clearfix">
                        <div class="btn-group">
                            <button id="editable-sample_new" class="btn btn-success">
                                Add New <i class="icon-plus"></i>
                            </button>
                        </div>

                    </div>
                    <div>

                        @foreach ($data as $row)
                            <div class="metro-nav-block nav-block-red">
                                <a data-original-title="" href="{{ route('awin.commissiongroup', $id) }}">
                                    <i class="icon-user"></i>
                                    <div class="info">

                                    </div>
                                    <div class="status">{{$row->name}}</div>
                                </a>
                            </div>
                        @endforeach
                    </div>


                </div>
            </div>

            <!-- END GRID PORTLET-->
        </div>
    @endsection
