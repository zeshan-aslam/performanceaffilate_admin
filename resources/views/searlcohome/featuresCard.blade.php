@extends('layouts.masterClone')

@section('title', 'Features')
@section('content')
<div class="row-fluid">
    <div class='sapn12'>
        <div class="widget">
            <div class="widget-title">
                <h4> Features Card Section Content</h4>
            </div>
            <div class="widget-body">
                <form action="{{ route('searlco.featuresCardStore') }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                    @csrf

                    <div class="control-group">
                        <label class="control-label">Card-Heading</label>
                        <div class="controls">
                            <input class="span10"  placeholder="Enter Card Heading" name="card_heading" type="text"/>
                        </div>
                        <div class="controls">
                            @error('card_heading')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                        <div class="control-group">
                            <label class="control-label">Card-Paragraph</label>
                            <div class="controls">
                                <textarea class="span10"  placeholder="Enter Card Paragraph" name="card_paragraph" class="span12" rows="3"></textarea>
                            </div>
                            <div class="controls">
                                @error('card_paragraph')
                                <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Save</button>
                        <a href="{{ route('searlco.featuresView') }}" type="button" class="btn "><i class=" icon-remove"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
