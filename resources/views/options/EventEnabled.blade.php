@php
    $events=DB::table('partners_event')->get();
@endphp



<div class="span12">
<div class="card p-4">
    <div class="card-header text-dark">
        Enable Mail Settings To Merchants
    </div>
    <div class="card-body"><br><br><br>
        @if (session()->has('eventSuccess'))
        <div class="alert alert-success"><strong> Success !</strong>
            {{ session()->get('eventSuccess') }} <i class=" icon-ok"></i> <button data-dismiss="alert" class="close" type="button">×</button>
        </div>
    @endif
    @if (session()->has('eventDanger'))
        <div class="alert alert-danger"><strong> Error !</strong>
            {{ session()->get('eventDanger') }} <i class=" icon-warning-sign"></i> <button data-dismiss="alert" class="close" type="button">×</button>
        </div>
    @endif
    <form action="{{route('Options.updateMerchantEvents')}}" method="POST">
        @csrf
        <table id='merchantEventsTable' class=" table table-striped table-hover table-bordered" onloadeddata="javascript:$(this).Datatable();">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @php
                $i=0;
            @endphp
                @foreach ($events as $row)

               <tr> <input type="hidden" name="id[{{$row->id}}]" value="{{$row->id}}"   >
                   <td class="text-dark">{{$row->event_name}}</td>
                   <td>

                    <div class="control-group">
                        @if($row->event_status=='no')
                        <div class="controls">

                            <label class="radio">

                           <input type="radio" name="event[{{$row->id}}]" value="yes"  >
                                Enable
                            </label>
                            <label class="radio">
                                <input type="radio" name="event[{{$row->id}}]" value="no" checked='checked'>

                                Disable
                            </label>

                        </div>
                        @else
                        <div class="controls">

                            <label class="radio">
                           <input type="radio" name="event[{{$row->id}}]" value="yes" checked='checked'>
                                Enable
                            </label>
                            <label class="radio">
                                <input type="radio" name="event[{{$row->id}}]" value="no" >

                                Disable
                            </label>

                        </div>
                        @endif

                    </div>
                   </td>
               </tr>
               @php
               $i++;
                @endphp
                @endforeach

            </tbody>
            <tfoot>
                <tr>

                    <th>Event Name</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        <br><br>

        <center><button class="btn btn-success" type="submit"> <i class="icon-refresh icon-white"></i> Update</button></center>
    </form>
</div>
</div>
</div>


