<div id="moreFields" >
    @if(old('moreField'))
        @for( $i =0; $i < count(old('moreField')); $i++)
        <div class="card mb-5 moreFieldsItem{$key}">
            <input type="hidden" name="moreField[{{ $i }}][id]" value="{{ old('moreField.'.$i.'.id' , "") }}" class="form-control" >
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">Label </label>
                                <div class="col-md-12">
                                    <input type="text" name="moreField[{{ $i }}][label]" value="{{ old('moreField.'.$i.'.label' , "") }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label mt-2">Type of field: </label>
                                <div class="col-md-12">
                                    <select class="form-control"  name="moreField[{{ $i }}][type_variable]" data-size="7" data-style="btn btn-outline-info btn-round" title="Type">
                                        <option value="text" @if ( old('moreField.'.$i.'.type_variable' , "") == 'text' ) selected @endif >Text box</option>
                                        <option value="url" @if ( old('moreField.'.$i.'.type_variable' , "") == 'url' ) selected @endif>Url box</option>
                                        <option value="password" @if ( old('moreField.'.$i.'.type_variable' , "") == 'password' ) selected @endif>Password box</option>
                                        <option value="email" @if ( old('moreField.'.$i.'.type_variable' , "") == 'email' ) selected @endif>Email box</option>
                                        <option value="select" @if ( old('moreField.'.$i.'.type_variable' , "") == 'select' ) selected @endif>Select option</option>
                                        <option value="radio" @if ( old('moreField.'.$i.'.type_variable' , "") == 'radio' ) selected @endif>Select radio</option>
                                        <option value="checkbox" @if ( old('moreField.'.$i.'.type_variable' , "") == 'checkbox' ) selected @endif>Check box</option>
                                        <option value="textarea" @if ( old('moreField.'.$i.'.type_variable' , "") == 'textarea' ) selected @endif>Text area</option>
                                        <option value="date"  @if ( old('moreField.'.$i.'.type_variable' , "") == 'date' ) selected @endif>Date</option>
                                        <option value="time" @if ( old('moreField.'.$i.'.type_variable' , "") == 'time' ) selected @endif>Time</option>
                                        <option value="datetime-local" @if ( old('moreField.'.$i.'.type_variable' , "") == 'datetime-local' ) selected @endif>Date & Time</option>
                                        <option value="number" @if ( old('moreField.'.$i.'.type_variable' , "") == 'number' ) selected @endif>Number</option>
                                        <option value="file" @if ( old('moreField.'.$i.'.type_variable' , "") == 'file' ) selected @endif>File</option>
                                        @foreach($DynamicFormsFieldType[$DynamicFormsId] as $fieldType )
                                            @if ( $fieldType != null )
                                                <option value="{{$fieldType['name']}}" @if ( old('moreField.'.$i.'.type_variable' , "") == $fieldType['name'] ) selected @endif>{{$fieldType['label']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">Description</label>
                                <div class="col-md-12">
                                    <input type="text" name="moreField[{{ $i }}][description]" value="{{ old('moreField.'.$i.'.description' , "") }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label mt-2">Status</label>
                                <div class="col-md-12">
                                    <select class="form-control"  name="moreField[{{ $i }}][status]" data-size="7" data-style="btn btn-outline-info btn-round" title="status">
                                        <option value="required" @if ( old('moreField.'.$i.'.status' , "") == 'required' ) selected @endif>Visible & Required</option>
                                        <option value="show" @if ( old('moreField.'.$i.'.status' , "") == 'show' ) selected @endif>Visible</option>
                                        <option value="hidden" @if ( old('moreField.'.$i.'.status' , "") == 'hidden' ) selected @endif>Invisible</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row moreFieldsItemMoreConfig{{ $i }} border rounded pb-2 mt-2" style="display: none;">
                            <hr>
                            <div class="col-md-8">
                                <label class="col-md-12 col-form-label">Default value(for explode use `,`)</label>
                                <div class="col-md-12 border-bottom ">
                                    <input type="text" name="moreField[{{ $i }}][values]" value="{{ old('moreField.'.$i.'.values' , "") }}" class="form-control tagsinput" data-role="tagsinput" data-color="info"  placeholder="valueOfField">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-12 col-form-label">Order</label>
                                <div class="col-md-12">
                                    <input type="number" name="moreField[{{ $i }}][order_number]" value="{{ old('moreField.'.$i.'.order_number' , "") }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="col-md-12 col-form-label"> Validation</label>
                                <div class="col-md-12 border-bottom  text-left">
                                    <input type="text"  name="moreField[{{ $i }}][validate]" value="{{ old('moreField.'.$i.'.validate' , "") }}"  class="form-control tagsinput " dir="ltr" data-role="tagsinput" data-color="info" placeholder="Validation">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <<div class="btn btn-danger rounded" onclick="$('.moreFieldsItem{{ $i }}').remove();">
                                                                     <span class="btn-label">
                                                                        <i class="fa fa-trash"></i>
                                                                     </span>
                            Delete
                        </div>
                        <div class="btn btn-default mt-4 rounded pointer" onclick="$('.moreFieldsItemMoreConfig{{ $i }}').toggle();">
                                                                     <span class="btn-label">
                                                                        <i class="fa fa-dot-circle-o"></i>
                                                                     </span>
                            More
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    @else
            @foreach($DynamicFormsField[$DynamicFormsId] as $key => $field)
    <div class="card mb-5 moreFieldsItem{{ $key }}">
        <input type="hidden" name="moreField[{{ $key }}][id]" value="{{$field->id}}" class="form-control" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">Label </label>
                            <div class="col-md-12">
                                <input type="text" name="moreField[{{ $key }}][label]" value="{{$field->label}}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label mt-2">Type of field</label>
                            <div class="col-md-12">
                                <select class="form-control"  name="moreField[{{ $key }}][type_variable]" data-size="7" data-style="btn btn-outline-info btn-round">
                                    <option value="text" @if($field->type_variable == "text" ) selected @endif >Text box</option>
                                    <option value="url" @if($field->type_variable == "url" ) selected @endif >Url box</option>
                                    <option value="password" @if($field->type_variable == "password" ) selected @endif >Password box</option>
                                    <option value="email" @if($field->type_variable == "email" ) selected @endif >Email box</option>
                                    <option value="select" @if($field->type_variable == "select" ) selected @endif >Select option</option>
                                    <option value="radio" @if($field->type_variable == "radio" ) selected @endif >Select radio</option>
                                    <option value="checkbox" @if($field->type_variable == "checkbox" ) selected @endif >Check box</option>
                                    <option value="textarea" @if($field->type_variable == "textarea" ) selected @endif >Text area</option>
                                    <option value="date" @if($field->type_variable == "date" ) selected @endif >Date</option>
                                    <option value="time" @if($field->type_variable == "time" ) selected @endif>Time</option>
                                    <option value="datetime-local" @if($field->type_variable == "datetime-local" ) selected @endif>Date & Time</option>
                                    <option value="number" @if($field->type_variable == "number" ) selected @endif >Number</option>
                                    <option value="file" @if($field->type_variable == "file" ) selected @endif >File</option>
                                    @foreach($DynamicFormsFieldType[$DynamicFormsId] as $fieldType )
                                        @if ( $fieldType != null )
                                            <option value="{{$fieldType['name']}}" @if ( $field->type_variable == $fieldType['name'] ) selected @endif>{{$fieldType['label']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">Description</label>
                            <div class="col-md-12">
                                <input type="text" name="moreField[{{ $key }}][description]" value="{{$field->description}}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label mt-2">Status</label>
                            <div class="col-md-12">
                                <select class="form-control"  name="moreField[{{ $key }}][status]" data-size="7" data-style="btn btn-outline-info btn-round" >
                                    <option value="required" @if($field->status == "required" ) selected @endif >Visible & Required</option>
                                    <option value="show" @if($field->status == "show" ) selected @endif >Visible</option>
                                    <option value="hidden" @if($field->status == "hidden" ) selected @endif >Invisible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row moreFieldsItemMoreConfig{{ $key }} border rounded pb-2 mt-2" style="display: none;">
                        <hr>
                        <div class="col-md-8">
                            <label class="col-md-12 col-form-label">Default value(for explode use `,`)</label>
                            <div class="col-md-12 border-bottom ">
                                <input type="text" name="moreField[{{ $key }}][values]" value="{{$field->values}}" class="form-control tagsinput" data-role="tagsinput" data-color="info"  placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12 col-form-label">Order</label>
                            <div class="col-md-12">
                                <input type="number" name="moreField[{{ $key }}][order_number]" value="{{$field->order_number}}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-12 col-form-label">Validation</label>
                            <div class="col-md-12 border-bottom  text-left">
                                <input type="text"  name="moreField[{{ $key }}][validate]" value="{{$field->validate}}"  class="form-control tagsinput " dir="ltr" data-role="tagsinput" data-color="info" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="btn btn-danger rounded" onclick="$('.moreFieldsItem{{ $key }}').remove();">
                                                                 <span class="btn-label">
                                                                    <i class="fa fa-trash"></i>
                                                                 </span>
                        Delete
                    </div>
                    <div class="btn btn-info mt-4 rounded pointer" onclick="$('.moreFieldsItemMoreConfig{{ $key }}').toggle();">
                                                                 <span class="btn-label">
                                                                    <i class="fa fa-dot-circle-o"></i>
                                                                 </span>
                        More
                    </div>
                </div>
            </div>
        </div>
    </div>
            @endforeach

    @endif
</div>
<div id="moreFieldsDelete">
</div>
<div class="row">
    <div class="col-md-12">
        <div class="btn btn-success border pointer float-left" onclick="add();">
                                             <span class="btn-label">
                                                <i class="fa fa-plus"></i>
                                             </span>
            Add New Field
        </div>
    </div>
</div>
<div id="typeOfAddItem" style="display: none;">
    <div class="card mb-5 moreFieldsItem__IIDD__">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">Label</label>
                            <div class="col-md-12">
                                <input type="text" nameOFInputBox="moreField[__IIDD__][label]"  value="" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label mt-2">Type of field</label>
                            <div class="col-md-12">
                                <select class="form-control"  nameOFInputBox="moreField[__IIDD__][type_variable]" data-size="7" data-style="btn btn-outline-info btn-round" title="">
                                    <option value="text" selected>Text box</option>
                                    <option value="url">Url box</option>
                                    <option value="password">Password box</option>
                                    <option value="email">Email box</option>
                                    <option value="select">Select option</option>
                                    <option value="radio">Select radio</option>
                                    <option value="checkbox">Check box</option>
                                    <option value="textarea">Text area</option>
                                    <option value="date">Date</option>
                                    <option value="time">Time</option>
                                    <option value="datetime-local">Date & Time</option>
                                    <option value="number">Number</option>
                                    <option value="file">File</option>
                                    @foreach($DynamicFormsFieldType[$DynamicFormsId] as $fieldType )
                                        @if ( $fieldType != null )
                                            <option value="{{$fieldType['name']}}" >{{$fieldType['label']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">Description</label>
                            <div class="col-md-12">
                                <input type="text"  nameOFInputBox="moreField[__IIDD__][description]" value="" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label mt-2">Status</label>
                            <div class="col-md-12">
                                <select class="form-control" nameOFInputBox="moreField[__IIDD__][status]" data-size="7" data-style="btn btn-outline-info btn-round" title="">
                                    <option value="required">Visible & Required</option>
                                    <option value="show" selected>Visible</option>
                                    <option value="hidden">Invisible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row moreFieldsItemMoreConfig__IIDD__ border rounded pb-2 mt-2" style="display: none;">
                        <hr>
                        <div class="col-md-8">
                            <label class="col-md-12 col-form-label">Default value(for explode use `,`) </label>
                            <div class="col-md-12 border-bottom ">
                                <input type="text"   nameOFInputBox="moreField[__IIDD__][values]" value="" class="form-control tagsinputTemp"   placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12 col-form-label">Order</label>
                            <div class="col-md-12">
                                <input type="number" nameOFInputBox="moreField[__IIDD__][order_number]" value="0" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-12 col-form-label">Validation</label>
                            <div class="col-md-12 border-bottom  text-left">
                                <input type="text"   nameOFInputBox="moreField[__IIDD__][validate]" value="" class="form-control tagsinputTemp " dir="ltr" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="btn btn-danger rounded" onclick="$('.moreFieldsItem__IIDD__').remove()">
                                                                 <span class="btn-label">
                                                                    <i class="fa fa-trash"></i>
                                                                 </span>
                        Delete
                    </div>
                    <div class="btn btn-default mt-4 rounded pointer" onclick="$('.moreFieldsItemMoreConfig__IIDD__').toggle();">
                                                                 <span class="btn-label">
                                                                    <i class="fa fa-dot-circle-o"></i>
                                                                 </span>
                        More
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var numberOfElement = @if(old('moreField')) {{ count(old('moreField')) }} @else {{ count($DynamicFormsField[$DynamicFormsId]) }} @endif;
    function add() {
        var string = $('#typeOfAddItem').html();
        string = string.replace(new RegExp('__IIDD__', 'g'), numberOfElement);
        string = string.replace(new RegExp('nameofinputbox', 'g'), 'name');
        string = string.replace(new RegExp('selectpickerTemp', 'g'), 'selectpicker');
        string = string.replace(new RegExp('tagsinputTemp', 'g'), 'tagsinput');
        string = string.replace(new RegExp('tagsinputDataTemp', 'g'), 'data-role="tagsinput" data-color="info"');
        $('#moreFields').append(string);
        numberOfElement++;
        // $('.selectpicker').selectpicker('refresh');
        $('.tagsinput').tagsinput('refresh').tagClass('info');
    }
</script>

