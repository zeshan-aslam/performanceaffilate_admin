
@extends('layouts.masterClone')

@section('title', 'Options')


@section('content')


<div class="row-fluid">
    <div class="span2"></div>
    <div class="span8" id="">
        <!-- BEGIN GENERAL PORTLET-->
        <div class="widget blue">
            <div class="widget-title">
                <h4 style="tetxt-align:center"><i class=" icon-trophy"></i>

                     Privileges </h4>
            </div>
            <div class="widget-body">

                <h3 style="text-align: center; font-family:cambria;">Privileges for the user :<strong style="color:red; font-family:cambria"> {{ $admin->adminusers_login }}</strong></h3>


                <div class="row-fluid">
                    <div class="form-horizontal">

                        <div class="control-group ">
                            <form action="" method="post">
                                <input name="_token" id="token" value="{{ csrf_token() }}" type="hidden">
                            <table  class="table hover">
                                <thead>
                                    <tr class="well">
                                        <th class="text-error">Links</th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-error">Privileges</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                    $count= 0;
                                @endphp
                                    @foreach ($privils as $privil)
                                    @if( $privil->adminlinks_parentid==0)
                                    @php
                                        $count++;

                                    @endphp
                                    <tr>

                                        <td colspan="3" class="">
                                            <b>{{$privil->adminlinks_title }}</b>
                                        </td>
                                        <td><input type="checkbox" name="checked[]" multiple  id="{{ $privil->adminlinks_id}}" onclick="updatePriviliges(this)"
                                            @php
                                            if($admin->adminusers_id==$privil->adminlinks_userid){
                                                echo "checked='checked'";

                                            }
                                            else {
                                                echo "";
                                            }
                                        @endphp></td>
                                    </tr>

                                    @endif
                                    @foreach ($privils as $row)
                                       @if($row->adminlinks_parentid==$count)
                                    <tr>

                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;»» {{$row->adminlinks_title }}

                                        </td>

                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td>
                                            <input type="hidden" name="userId" value="{{ $admin->adminusers_id}}">
                                            <input type="checkbox" name="uprivil"  id="{{ $row->adminlinks_id }}" onchange="updatePriviliges(this)" 
                                            @php
                                                if($admin->adminusers_id==$row->adminlinks_userid){
                                                    echo "checked='checked'";

                                                }
                                                else {
                                                    echo "";
                                                }
                                            @endphp>
                                            
                                        </td>

                                    </tr>
                                    @endif

                                    @endforeach
                                    @endforeach

                                   </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </form>
                        </div>

                    </div>
                </div>
            </div>


            {{-- <center>
                 <button type="button" name='adminUpdateBtn' class="btn btn-success"><i class="icon-check"></i> Update </button><br><br>
            </center> --}}

                </div>


            </div>
        </div>
    </div>
</div>




@endsection
@section('script')
<script>
var insertAdminuserURL = "{{ url('Options/insertAdminuser') }}";
var UserAdmintableURL = "{{ url('Options/UserAdmintable') }}";
var updateAdminURL = "{{ url('Options/updateAdmin') }}";
var checkboxPrivilegesURL = "{{ url('Options/checkboxPrivileges') }}";
var ShowAdminURL = "{{ url('Options/ShowAdmin') }}";
var DeleteAdminURL = "{{ url('Options/DeleteAdmin') }}";
var privilegesURL = "{{ url('Options/privileges') }}";
</script>
@endsection

@section('scripts')
    <script src="{{ asset('js/options/adminuser.js') }}"></script>

@endsection
