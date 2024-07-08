@extends('layouts.masterClone')

@section('title', 'Searlco Network')
@section('content')
<div class="row-fluid">
    <div class='sapn12'>
        <div class="widget">
            <div class="widget-title">
                <h4> Searlco Network </h4>
            </div>
            <div class="widget-body">
                <form action='' class='form-horizontal'>
                    <div class="control-group">
                        <label class="control-label">Heading</label>
                        <div class="controls">
                            <input type="text" placeholder=".input-xlarge" class="input-xlarge">
                            <span class="help-inline">Some hint here</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <textarea class="input-xlarge" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Select Image</label>
                        <div class="controls">
                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                <div style="width: 200px; height: 150px;" class="fileupload-new thumbnail">
                                    <img alt="" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
                                </div>
                                <div style="max-width: 200px; max-height: 150px; line-height: 20px;" class="fileupload-preview fileupload-exists thumbnail"></div>
                                <div>
                                   <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                   <span class="fileupload-exists">Change</span>
                                   <input type="file" class="default"></span>
                                    <a data-dismiss="fileupload" class="btn fileupload-exists" href="#">Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Save</button>
                        <a href="{{ route('searlco.footerView') }}" type="button" class="btn "><i class=" icon-remove"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
