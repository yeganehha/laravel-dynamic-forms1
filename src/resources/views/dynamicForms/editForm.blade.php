<div id="moreFields" >
    @if(old('moreField'))
        @for( $i =0; $i < count(old('moreField.'.$DynamicFormsId)); $i++)
        <div class="card mb-5 moreFieldsItem{{$DynamicFormsId}}_{{$i}}">
            <input type="hidden" name="moreField[{{$DynamicFormsId}}][{{ $i }}][id]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.id' , "") }}" class="form-control" >
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">Label </label>
                                <div class="col-md-12">
                                    <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $i }}][label]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.label' , "") }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label mt-2">Type of field: </label>
                                <div class="col-md-12">
                                    <select class="form-control"  name="moreField[{{$DynamicFormsId}}][{{ $i }}][type_variable]" data-size="7" data-style="btn btn-outline-info btn-round" title="Type">
                                        <option value="text" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.type_variable' , "") == 'text' ) selected @endif >Text box</option>
                                        @foreach($DynamicFormsFieldType[$DynamicFormsId] as $fieldType )
                                            @if ( $fieldType != null )
                                                <option value="{{$fieldType['name']}}" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.type_variable' , "") == $fieldType['name'] ) selected @endif>{{$fieldType['label'] ?? $fieldType['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">Description</label>
                                <div class="col-md-12">
                                    <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $i }}][description]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.description' , "") }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label mt-2">Status</label>
                                <div class="col-md-12">
                                    <select class="form-control"  name="moreField[{{$DynamicFormsId}}][{{ $i }}][status]" data-size="7" data-style="btn btn-outline-info btn-round" title="status">
                                        <option value="required" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.status' , "") == 'required' ) selected @endif>Visible & Required</option>
                                        <option value="show" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.status' , "") == 'show' ) selected @endif>Visible</option>
                                        <option value="hidden" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.status' , "") == 'hidden' ) selected @endif>Invisible</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row moreFieldsItemMoreConfig{{$DynamicFormsId}}_{{ $i }} border rounded pb-2 mt-2" style="display: none;">
                            <hr>
                            <div class="col-md-8">
                                <label class="col-md-12 col-form-label">Default value(for explode use `,`)</label>
                                <div class="col-md-12 border-bottom ">
                                    <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $i }}][values]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.values' , "") }}" class="form-control tagsinput" data-role="tagsinput" data-color="info"  placeholder="valueOfField">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-12 col-form-label">Order</label>
                                <div class="col-md-12">
                                    <input type="number" name="moreField[{{$DynamicFormsId}}][{{ $i }}][order_number]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.order_number' , "") }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="col-md-12 col-form-label"> Validation</label>
                                <div class="col-md-12 border-bottom  text-left">
                                    <input type="text"  name="moreField[{{$DynamicFormsId}}][{{ $i }}][validate]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.validate' , "") }}"  class="form-control tagsinput " dir="ltr" data-role="tagsinput" data-color="info" placeholder="Validation">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="btn btn-danger rounded" onclick="$('.moreFieldsItem{{$DynamicFormsId}}_{{ $i }}').remove();">
                                                                     <span class="btn-label">
                                                                        <i class="fa fa-trash"></i>
                                                                     </span>
                            Delete
                        </div>
                        <div class="btn btn-default mt-4 rounded pointer" onclick="$('.moreFieldsItemMoreConfig{{$DynamicFormsId}}_{{ $i }}').toggle();">
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
    <div class="card mb-5 moreFieldsItem{{$DynamicFormsId}}_{{ $key }}">
        <input type="hidden" name="moreField[{{$DynamicFormsId}}][{{ $key }}][id]" value="{{$field->id}}" class="form-control" >
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">Label </label>
                            <div class="col-md-12">
                                <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $key }}][label]" value="{{$field->label}}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label mt-2">Type of field</label>
                            <div class="col-md-12">
                                <select class="form-control"  name="moreField[{{$DynamicFormsId}}][{{ $key }}][type_variable]" data-size="7" data-style="btn btn-outline-info btn-round">
                                    <option value="text" @if($field->type_variable == "text" ) selected @endif >Text box</option>
                                    @foreach($DynamicFormsFieldType[$DynamicFormsId] as $fieldType )
                                        @if ( $fieldType != null )
                                            <option value="{{$fieldType['name']}}" @if ( $field->type_variable == $fieldType['name'] ) selected @endif>{{$fieldType['label'] ?? $fieldType['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">Description</label>
                            <div class="col-md-12">
                                <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $key }}][description]" value="{{$field->description}}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label mt-2">Status</label>
                            <div class="col-md-12">
                                <select class="form-control"  name="moreField[{{$DynamicFormsId}}][{{ $key }}][status]" data-size="7" data-style="btn btn-outline-info btn-round" >
                                    <option value="required" @if($field->status == "required" ) selected @endif >Visible & Required</option>
                                    <option value="show" @if($field->status == "show" ) selected @endif >Visible</option>
                                    <option value="hidden" @if($field->status == "hidden" ) selected @endif >Invisible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row moreFieldsItemMoreConfig{{$DynamicFormsId}}_{{ $key }} border rounded pb-2 mt-2" style="display: none;">
                        <hr>
                        <div class="col-md-8">
                            <label class="col-md-12 col-form-label">Default value(for explode use `,`)</label>
                            <div class="col-md-12 border-bottom ">
                                <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $key }}][values]" value="{{$field->values}}" class="form-control tagsinput" data-role="tagsinput" data-color="info"  placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12 col-form-label">Order</label>
                            <div class="col-md-12">
                                <input type="number" name="moreField[{{$DynamicFormsId}}][{{ $key }}][order_number]" value="{{$field->order_number}}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-12 col-form-label">Validation</label>
                            <div class="col-md-12 border-bottom  text-left">
                                <input type="text"  name="moreField[{{$DynamicFormsId}}][{{ $key }}][validate]" value="{{$field->validate}}"  class="form-control tagsinput " dir="ltr" data-role="tagsinput" data-color="info" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="btn btn-danger rounded" onclick="$('.moreFieldsItem{{$DynamicFormsId}}_{{ $key }}').remove();">
                                                                 <span class="btn-label">
                                                                    <i class="fa fa-trash"></i>
                                                                 </span>
                        Delete
                    </div>
                    <div class="btn btn-info mt-4 rounded pointer" onclick="$('.moreFieldsItemMoreConfig{{$DynamicFormsId}}_{{ $key }}').toggle();">
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
    <div class="card mb-5 moreFieldsItem{{$DynamicFormsId}}___IIDD__">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">Label</label>
                            <div class="col-md-12">
                                <input type="text" nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][label]"  value="" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label mt-2">Type of field</label>
                            <div class="col-md-12">
                                <select class="form-control"  nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][type_variable]" data-size="7" data-style="btn btn-outline-info btn-round" title="">
                                    <option value="text" selected>Text box</option>
                                    @foreach($DynamicFormsFieldType[$DynamicFormsId] as $fieldType )
                                        @if ( $fieldType != null )
                                            <option value="{{$fieldType['name']}}" >{{$fieldType['label'] ?? $fieldType['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">Description</label>
                            <div class="col-md-12">
                                <input type="text"  nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][description]" value="" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label mt-2">Status</label>
                            <div class="col-md-12">
                                <select class="form-control" nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][status]" data-size="7" data-style="btn btn-outline-info btn-round" title="">
                                    <option value="required">Visible & Required</option>
                                    <option value="show" selected>Visible</option>
                                    <option value="hidden">Invisible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row moreFieldsItemMoreConfig{{$DynamicFormsId}}___IIDD__ border rounded pb-2 mt-2" style="display: none;">
                        <hr>
                        <div class="col-md-8">
                            <label class="col-md-12 col-form-label">Default value(for explode use `,`) </label>
                            <div class="col-md-12 border-bottom ">
                                <input type="text"   nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][values]" value="" class="form-control tagsinputTemp"   placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12 col-form-label">Order</label>
                            <div class="col-md-12">
                                <input type="number" nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][order_number]" value="0" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-12 col-form-label">Validation</label>
                            <div class="col-md-12 border-bottom  text-left">
                                <input type="text"   nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][validate]" value="" class="form-control tagsinputTemp " dir="ltr" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="btn btn-danger rounded" onclick="$('.moreFieldsItem{{$DynamicFormsId}}___IIDD__').remove()">
                                                                 <span class="btn-label">
                                                                    <i class="fa fa-trash"></i>
                                                                 </span>
                        Delete
                    </div>
                    <div class="btn btn-default mt-4 rounded pointer" onclick="$('.moreFieldsItemMoreConfig{{$DynamicFormsId}}___IIDD__').toggle();">
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

