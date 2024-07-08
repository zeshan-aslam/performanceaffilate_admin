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
                <form action="{{ route('searlco.contactStore') }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                    @csrf
                    <div class="control-group">
                        <label class="control-label">Heading</label>
                        <div class="controls">
                            <input class="span10" placeholder="Enter Heading" name="heading" type="text"/>
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
                            <textarea class="span10" placeholder="Enter Description"  name="description" rows="3"></textarea>
                        </div>
                        <div class="controls">
                            @error('description')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Address heading</label>
                        <div class="controls">
                            <input class="span10" placeholder="Enter Address Heading" name="address_heading" type="text"/>
                        </div>
                        <div class="controls">
                            @error('address_heading')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Address</label>
                        <div class="controls">
                            <input class="span10" placeholder="Enter Address" name="address" type="text"/>
                        </div>
                        <div class="controls">
                            @error('address')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Call Heading</label>
                        <div class="controls">
                            <input class="span10" placeholder="Enter Call Heading" name="call_heading" type="text"/>
                        </div>
                        <div class="controls">
                            @error('call_heading')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Call Number</label>
                        <div class="controls">
                            <input class="span10" placeholder="Call Number" name="call_number" type="text"/>
                        </div>
                        <div class="controls">
                            @error('call_number')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email Heading</label>
                        <div class="controls">
                            <input class="span10" placeholder="Enter Email Heading" name="email_heading" type="text"/>
                        </div>
                        <div class="controls">
                            @error('email_heading')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email Address</label>
                        <div class="controls">
                            <input class="span10" placeholder="Enter Email Address" name="email_address" type="text"/>
                        </div>
                        <div class="controls">
                            @error('email_address')
                            <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="control-group">
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
                    </div> --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Save</button>
                        <a href="{{ route('searlco.contactView') }}" type="button" class="btn "><i class=" icon-remove"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
