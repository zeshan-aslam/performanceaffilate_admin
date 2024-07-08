@extends('layouts.masterClone')

@section('title', 'Awin')


@section('content')
<h1 class="page-title">AWIN / Accounts</h1>

<div class='row-fluid'>
    <div class="span12">
        <!-- BEGIN GRID SAMPLE PORTLET-->
        <div class="widget blue">
            <div class="widget-title">
                <h4> Accounts</h4>
                <span class="tools">

                </span>
            </div>
            <div class="widget-body">
                <table class="table table-hover table-stripped table-hover">
                    <thead>
                        <th>Account Name</th>
                        <th>Account Type </th>
                        <th>User Role</th>
                        <th>Notifications</th>
                        <th>Actions</th>
                     
                    </thead>
                    <tbody>
                        @foreach ($data->accounts as $row)
                        <tr>
                            <td>{{$row->accountName}}</td>
                            <td>{{$row->accountType}}</td>
                            <td>{{$row->userRole}}</td>
                            <td><a href="{{route('awin.notifications',$row->accountId)}}" class="btn btn-danger">Notifications</a></td>

                            <td><a href="{{route('awin.publisher',$row->accountId)}}" class="btn btn-primary">View</a></td>
                          
                        </tr>
                            
                        @endforeach
                    </tbody>
                </table>
           
            </div>
        </div>

        <!-- END GRID PORTLET-->
    </div>
@endsection