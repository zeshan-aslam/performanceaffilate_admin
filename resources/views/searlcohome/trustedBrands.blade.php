@extends('layouts.masterClone')

@section('title', 'Trusted Brands')
@section('content')
<div class="row-fluid">
    <div class='sapn12'>
        <div class="widget">
            <div class="widget-title">
                <h4> Trusted Brands Section Content </h4>

            </div>
            <div class="widget-body">
                <form action="{{ route('searlco.trustedStore') }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                    @csrf
                    <div class="control-group">
                        <label class="control-label">Heading</label>
                        <div class="controls">
                            <input type="text" name="heading" placeholder="Enter Heading" class="span10">
                        </div>
                        <div class="controls">
                            @error('heading')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <textarea class="span10" placeholder="Enter Description" name="desc" rows="3"></textarea>
                        </div>
                        <div class="controls">
                            @error('desc')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Save</button>
                        <a href="{{ route('searlco.trustedBrandsView') }}" type="button" class="btn "><i class=" icon-remove"></i> Cancel</a>
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
        $('form img').attr('src', x);
    });
    });
    </script>
@endsection
