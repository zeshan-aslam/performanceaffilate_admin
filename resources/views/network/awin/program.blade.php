@extends('layouts.masterClone')

@section('title', 'Awin')
@section('content')
<div class='row-fluid'>
    <div class="span12">
        <!-- BEGIN GRID SAMPLE PORTLET-->
        <div class="widget blue">
            <div class="widget-title">
                <h4> Programs </h4>
                <span class="tools">

                </span>
            </div>
            <div class="widget-body">
               
                @if (session()->has('error'))
                            <div class="alert alert-danger"><strong> Error !</strong>
                                {{ session()->get('error')}} <button data-dismiss="alert" class="close" type="button">×</button>
                            </div>
                        @else
        
                @if(count($data)<1)
                <div class="alert alert-danger">
                    Nothing Found

                </div>
                @else
                <table class="table table-hover table-stripped">
                    <thead>
                        <th>Program Name</th>
                        <th>displayUrl </th>
                        <th>clickThroughUrl</th>
                        <th>currencyCode</th>
                        <th>primaryRegion</th>
                        <th>logoUrl</th>
                        <th>Actions</th>
                        
                    
                       
                     
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td>{{$row->name}}</td>
                            <td>{{$row->displayUrl}}</td>
                            <td>{{$row->clickThroughUrl}}</td>
                            <td>{{$row->currencyCode}}</td>
                            <td>
                                @foreach ($primaryRegion as $region)
                                {{$region[0]->countryCode}}
                                @endforeach
                            </td>
                            <td>{{$row->logoUrl}}</td>
                            <td>{{$row->logoUrl}}</td>
                          
                        </tr>
                            
                        @endforeach
                    </tbody>
                </table>
                @endif
                @endif
           
            </div>
        </div>

        <!-- END GRID PORTLET-->
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
       $('table').DataTable();
    });
</script>
@endsection