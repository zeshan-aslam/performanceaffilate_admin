@extends('layouts.masterClone')

@section('title', 'Searlco Dynamic Data Entery')
@section('content')
    <div class="row-fluid">
        <div class='sapn12'>
            <div class="widget">
                <div class="widget-title">
                    <h4> Slider Section Content</h4>
                </div>
                <div class="widget-body">
                    <form action="{{ route('searlco.sliderStore') }}" method="POST" enctype="multipart/form-data"
                        class='form-horizontal'>
                        @csrf
                        <div class="control-group">
                            <label class="control-label">Heading</label>
                            <div class="controls">
                                <input class="span10" placeholder="Enter Heading" type="text" name="heading" />
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
                                <textarea class="span10" placeholder="Enter Description" name="description" class="span12"
                                    rows="3"></textarea>
                            </div>
                            <div class="controls">
                                @error('description')
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
                        <div class="control-group">
                            <label class="control-label"> First Button Name</label>
                            <div class="controls">
                                <input type="text" name="button1" placeholder="Enter Button Name" class="span10">
                            </div>
                            <div class="controls">
                                @error('button1')
                                <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="control-group">
                            <label class="control-label"> First Button Link</label>
                            <div class="controls">
                                <input type="text" name="href1" placeholder="Enter Button link" class="span10">
                            </div>
                            <div class="controls">
                                @error('href1')
                                <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="control-group">
                            <label class="control-label">Second Button Name</label>
                            <div class="controls">
                                <input type="text" name="button2" placeholder="Enter Button Name" class="span10">
                            </div>
                            <div class="controls">
                                @error('button2')
                                <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"> Second Button Link</label>
                            <div class="controls">
                                <input type="text" name="href2" placeholder="Enter Button link" class="span10">
                            </div>
                            <div class="controls">
                                @error('href2')
                                <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Save</button>
                            <a href="{{ route('searlco.sliderView') }}" type="button" class="btn "><i class=" icon-remove"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#img').change(function(event) {
                var x = URL.createObjectURL(event.target.files[0]);
                console.log(event);
                $('form img').attr('src', x);
            });
        });
    </script>
@endsection
