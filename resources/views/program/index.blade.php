@extends('layouts.masterClone')

@section('title', 'Programs')

@section('content')

<div class='row'>

    <div class='col-lg-12'>
    <h1 class="page-title">Programs</h1>
<div class="widget p-3 blue">
    <div class="widget-title ">
    <h4>Programs</h4>
    </div>

    <div class="widget-body">
   
        <table class="table table-stripped table-hover">
            <thead class="text-dark">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $program)
     <tr>
         <td class="text-dark"><b>{{$program->program_url}}</b></td>
         <td>{{$program->program_description}}</td>
         <td>{{$program->program_status}}</td>
         <td>{{$program->program_date}}</td>
         <td><a href="{{route('Program.getProgramDetails',$program->program_id)}}" class="btn btn-primary">View</a></td>
     </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
       $('table').DataTable();
    });
</script>
@endsection

