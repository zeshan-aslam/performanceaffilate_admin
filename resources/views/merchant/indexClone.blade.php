@extends('layouts.master')




@section('content')

<div class="row-fluid">

<div class='span4'>

<div class="widget orange">
                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i> All Merchants (0)</h4>
                                        <span class="tools">
                                        <a class="icon-chevron-down" href="javascript:;"></a>
                                        <a class="icon-remove" href="javascript:;"></a>
                                        </span>
                            </div>
                            <div class="widget-body">
                            <ul class="unstyled icons">
                            <li><i class="icon-refresh"></i>  Pending (0)</li>
                            <li><i class="icon-check-sign"></i>  Approved (0)</li>
                            <li><i class="icon-remove-circle"></i>  Not Paid (0)</li>
                            <li><i class="icon-spinner"></i>  Waiting (0)</li>
                            <li><i class="icon-meh"></i>  Money Empty (0)</li>
                            <li><i class="icon-ban-circle"></i>  Suspended (0)</li>
                            
                        </ul>
                            </div>
                        </div>

</div>


</div>    


@endsection