@extends('layouts.masterClone')
@section('title', 'User Activity')
@section('content')
<div class='container-fluid'>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class='card'>
                <div class='card-header bg-info text-white'><b>User Activity</b></div>
                <div class="card-body">
                    <table id='activityTable' class="table table-hover table-stripped">
                        <thead>
                            <th>Description</th>
                            <th>Country</th>
                            <th>IP</th>
                            <th>URL</th>
                            <th>Type</th>
                            <th>By</th>
                            <th>Date</th>
                           
                        </thead>
                        <tbody>
                            @php
                                $data=\App\Activity::all();
                            @endphp
                            @foreach ($data as $row)
                          <tr>
                              <td>{{$row->description}}</td>
                              <td>{{$row->country}}</td>
                              <td>{{$row->ip}}</td>
                              <td>{{$row->url}}</td>
                              <td>{{$row->type}}</td>
                              <td>{{$row->user->username}}</td>
                              <td>{{$row->created_at}}</td>

                          </tr>
       
                            @endforeach
                        </tbody>

                        <tfoot>
                            <th>Description</th>
                            <th>Country</th>
                            <th>IP</th>
                            <th>URL</th>
                            <th>Type</th>
                            <th>By</th>
                            <th>Date</th>
                           
                        </tfoot>

                    </table>
 

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#activityTable').DataTable({
            "order": [
                        [6, 'desc']
                    ],
        });

    });
</script>
@endsection