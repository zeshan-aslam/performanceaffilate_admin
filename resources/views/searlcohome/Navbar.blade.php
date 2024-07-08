
    @extends('layouts.masterClone')
    @section('title', 'Searlco Network')
    @section('content')
    <div class="row-fluid">
        <div class='sapn12'>
            <div class="widget">
                <div class="widget-title">
                    <h4> Menu Section Content </h4>
                </div>
                <div class="widget-body">
                    <form action="{{ route('searlco.MenuStore') }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                        @csrf
                        <div class="control-group">
                            <label class="control-label">Menu Name</label>
                            <div class="controls">
                                <input type="text" name="menu" placeholder="Enter Menu Name" class="span10">
                            </div>
                            <div class="controls">
                                @error('menu')
                                <div class="alert alert-danger span10" style="margin-top: 5px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"> Add Link </label>
                            <div class="controls">
                                <input type="text" name="Link" placeholder="https://www.dummy.com" class="span10">
                            </div>
                            <div class="controls">
                                @error('Link')
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
