@extends('layouts.masterClone')

@section('title', 'Searlco Network')
@section('content')
<div class="row-fluid">
    <div class='sapn12'>
        <div class="widget">
            <div class="widget-title">
                <h4> Header Section Content </h4>
            </div>
            <div class="widget-body">
                <form action="{{ route('searlco.NavbarStore') }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                    @csrf
                    <div class="control-group">
                        <label class="control-label">Select Logo</label>
                        <div class="controls">
                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                <div style="width: 200px; height: 150px;" class="fileupload-new thumbnail">
                                    <img alt="" src="">
                                </div>
                                <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"></div>
                                <div>
                                    <input type="file" id="img" name="img" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="controls">
                            @error('img')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Login Content</label>
                        <div class="controls">
                            <textarea rows="3" name="login" class="span10"></textarea>
                        </div>
                        <div class="controls">
                            @error('login')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Sign Up Content</label>
                        <div class="controls">
                            <textarea class="span10" name="signup" rows="3"></textarea>
                        </div>
                        <div class="controls">
                            @error('signup')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Save</button>
                        <a href="{{ route('searlco.headerView') }}" type="button" class="btn "><i class=" icon-remove"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
     $('#img').change(function(event){
        var x =URL.createObjectURL(event.target.files[0]);
        console.log(event);
        console.log(x);
        $('form img').attr('src', x);
    });
    });

    </script>
@endsection
