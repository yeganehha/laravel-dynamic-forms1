<div id="moreFields{{$DynamicFormsId}}" >
    @if(old('moreField'))
        @for( $i =0; $i < count(old('moreField.'.$DynamicFormsId)); $i++)
        <div class="card mb-5 moreFieldsItem{{$DynamicFormsId}}_{{$i}}">
            <input type="hidden" name="moreField[{{$DynamicFormsId}}][{{ $i }}][id]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.id' , "") }}" class="form-control" >
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.label') }} </label>
                                <div class="col-md-12">
                                    <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $i }}][label]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.label' , "") }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.type') }} </label>
                                <div class="col-md-12">
                                    <select class="form-control"  name="moreField[{{$DynamicFormsId}}][{{ $i }}][type_variable]" data-size="7" data-style="btn btn-outline-info btn-round" title="Type">
                                        <option value="text" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.type_variable' , "") == 'text' ) selected @endif >{{ __('dynamicForm::form.text') }}</option>
                                        @foreach($DynamicFormsFieldType[$DynamicFormsId] as $fieldType )
                                            @if ( $fieldType != null )
                                                <option value="{{$fieldType['name']}}" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.type_variable' , "") == $fieldType['name'] ) selected @endif>{{$fieldType['label'] ?? $fieldType['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.description') }}</label>
                                <div class="col-md-12">
                                    <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $i }}][description]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.description' , "") }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.status') }}</label>
                                <div class="col-md-12">
                                    <select class="form-control"  name="moreField[{{$DynamicFormsId}}][{{ $i }}][status]" data-size="7" data-style="btn btn-outline-info btn-round" title="status">
                                        <option value="required" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.status' , "") == 'required' ) selected @endif>{{ __('dynamicForm::form.required') }}</option>
                                        <option value="show" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.status' , "") == 'show' ) selected @endif>{{ __('dynamicForm::form.visible') }}</option>
                                        <option value="hidden" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.status' , "") == 'hidden' ) selected @endif>{{ __('dynamicForm::form.invisible') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row moreFieldsItemMoreConfig{{$DynamicFormsId}}_{{ $i }} border rounded pb-2 mt-2" style="display: none;">
                            <div class="col-md-8">
                                <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.defaultValue') }}</label>
                                <div class="col-md-12">
                                    <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $i }}][values]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.values' , "") }}" class="form-control"  placeholder="{{ __('dynamicForm::form.defaultValue') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.order') }}</label>
                                <div class="col-md-12">
                                    <input type="number" name="moreField[{{$DynamicFormsId}}][{{ $i }}][order_number]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.order_number' , "") }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.validation') }}</label>
                                <div class="col-md-12 text-left">
                                    <input type="text"  name="moreField[{{$DynamicFormsId}}][{{ $i }}][validate]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.validate' , "") }}"  class="form-control " dir="ltr"  placeholder="{{ __('dynamicForm::form.validation') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.blade_template') }}</label>
                                <div class="col-md-12">
                                    <select class="form-control"  name="moreField[{{$DynamicFormsId}}][{{ $i }}][blade_template]" data-size="7" data-style="btn btn-outline-info btn-round" title="Type">
                                        @foreach($DynamicFormsTemplate[$DynamicFormsId] as $bladeFile => $bladeLabel )
                                            <option value="{{$bladeFile}}" @if ( old('moreField.'.$DynamicFormsId.'.'.$i.'.blade_template' , "") == $fieldType['name'] ) selected @endif>{{$bladeLabel}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.font_icon') }}</label>
                                <div class="col-md-12 text-left">
                                    <input type="text"  name="moreField[{{$DynamicFormsId}}][{{ $i }}][font_icon]" value="{{ old('moreField.'.$DynamicFormsId.'.'.$i.'.font_icon' , "") }}"  class="form-control " dir="ltr"  placeholder="{{ __('dynamicForm::form.font_icon') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="btn btn-danger rounded" onclick="$('.moreFieldsItem{{$DynamicFormsId}}_{{ $i }}').remove();">
                                                                     <span class="btn-label">
                                                                        <i class="fa fa-trash"></i>
                                                                     </span>
                            {{ __('dynamicForm::form.delete') }}
                        </div>
                        <div class="btn btn-info mt-4 rounded pointer" onclick="$('.moreFieldsItemMoreConfig{{$DynamicFormsId}}_{{ $i }}').toggle();">
                                                                     <span class="btn-label">
                                                                        <i class="fa fa-dot-circle-o"></i>
                                                                     </span>
                            {{ __('dynamicForm::form.more') }}
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
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.label') }} </label>
                            <div class="col-md-12">
                                <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $key }}][label]" value="{{$field->label}}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.type') }}</label>
                            <div class="col-md-12">
                                <select class="form-control"  name="moreField[{{$DynamicFormsId}}][{{ $key }}][type_variable]" data-size="7" data-style="btn btn-outline-info btn-round">
                                    <option value="text" @if($field->type_variable == "text" ) selected @endif >{{ __('dynamicForm::form.text') }}</option>
                                    @foreach($DynamicFormsFieldType[$DynamicFormsId] as $fieldType )
                                        @if ( $fieldType != null )
                                            <option value="{{$fieldType['name']}}" @if ( $field->type_variable == $fieldType['name'] ) selected @endif>{{$fieldType['label'] ?? $fieldType['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.description') }}</label>
                            <div class="col-md-12">
                                <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $key }}][description]" value="{{$field->description}}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.status') }}</label>
                            <div class="col-md-12">
                                <select class="form-control"  name="moreField[{{$DynamicFormsId}}][{{ $key }}][status]" data-size="7" data-style="btn btn-outline-info btn-round" >
                                    <option value="required" @if($field->status == "required" ) selected @endif >{{ __('dynamicForm::form.required') }}</option>
                                    <option value="show" @if($field->status == "show" ) selected @endif >{{ __('dynamicForm::form.visible') }}</option>
                                    <option value="hidden" @if($field->status == "hidden" ) selected @endif >{{ __('dynamicForm::form.invisible') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row moreFieldsItemMoreConfig{{$DynamicFormsId}}_{{ $key }} border rounded pb-2 mt-2" style="display: none;">
                        <div class="col-md-8">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.defaultValue') }}</label>
                            <div class="col-md-12">
                                <input type="text" name="moreField[{{$DynamicFormsId}}][{{ $key }}][values]" value="{{$field->values}}" class="form-control"  placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.order') }}</label>
                            <div class="col-md-12">
                                <input type="number" name="moreField[{{$DynamicFormsId}}][{{ $key }}][order_number]" value="{{$field->order_number}}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.validation') }}</label>
                            <div class="col-md-12 text-left">
                                <input type="text"  name="moreField[{{$DynamicFormsId}}][{{ $key }}][validate]" value="{{$field->validate}}"  class="form-control " dir="ltr" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.blade_template') }}</label>
                            <div class="col-md-12">
                                <select class="form-control"  name="moreField[{{$DynamicFormsId}}][{{ $key }}][blade_template]" data-size="7" data-style="btn btn-outline-info btn-round" title="Type">
                                    @foreach($DynamicFormsTemplate[$DynamicFormsId] as $bladeFile => $bladeLabel )
                                        <option value="{{$bladeFile}}" @if ( $field->blade_template == $fieldType['name'] ) selected @endif>{{$bladeLabel}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.font_icon') }}</label>
                            <div class="col-md-12 text-left">
                                <input type="text"  name="moreField[{{$DynamicFormsId}}][{{ $key }}][font_icon]" value="{{$field->font_icon}}"  class="form-control " dir="ltr" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="btn btn-danger rounded" onclick="$('.moreFieldsItem{{$DynamicFormsId}}_{{ $key }}').remove();">
                                                                 <span class="btn-label">
                                                                    <i class="fa fa-trash"></i>
                                                                 </span>
                        {{ __('dynamicForm::form.delete') }}
                    </div>
                    <div class="btn btn-info mt-4 rounded pointer" onclick="$('.moreFieldsItemMoreConfig{{$DynamicFormsId}}_{{ $key }}').toggle();">
                                                                 <span class="btn-label">
                                                                    <i class="fa fa-dot-circle-o"></i>
                                                                 </span>
                        {{ __('dynamicForm::form.more') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
            @endforeach

    @endif
</div>
<div class="row">
    <div class="col-md-12">
        <div class="btn btn-success border pointer float-left" onclick="add{{$DynamicFormsId}}();">
                                             <span class="btn-label">
                                                <i class="fa fa-plus"></i>
                                             </span>
            {{ __('dynamicForm::form.add') }}
        </div>
    </div>
</div>
<div id="typeOfAddItem{{$DynamicFormsId}}" style="display: none;">
    <div class="card mb-5 moreFieldsItem{{$DynamicFormsId}}___IIDD__">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.label') }}</label>
                            <div class="col-md-12">
                                <input type="text" nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][label]"  value="" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.type') }}</label>
                            <div class="col-md-12">
                                <select class="form-control"  nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][type_variable]" data-size="7" data-style="btn btn-outline-info btn-round" title="">
                                    <option value="text" selected>{{ __('dynamicForm::form.text') }}</option>
                                    @foreach($DynamicFormsFieldType[$DynamicFormsId] as $fieldType )
                                        @if ( $fieldType != null )
                                            <option value="{{$fieldType['name']}}" >{{$fieldType['label'] ?? $fieldType['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.description') }}</label>
                            <div class="col-md-12">
                                <input type="text"  nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][description]" value="" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.status') }}</label>
                            <div class="col-md-12">
                                <select class="form-control" nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][status]" data-size="7" data-style="btn btn-outline-info btn-round" title="">
                                    <option value="required">{{ __('dynamicForm::form.required') }}</option>
                                    <option value="show" selected>{{ __('dynamicForm::form.visible') }}</option>
                                    <option value="hidden">{{ __('dynamicForm::form.invisible') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row moreFieldsItemMoreConfig{{$DynamicFormsId}}___IIDD__ border rounded pb-2 mt-2" style="display: none;">
                        <div class="col-md-8">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.defaultValue') }}</label>
                            <div class="col-md-12">
                                <input type="text"   nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][values]" value="" class="form-control"   placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.order') }}</label>
                            <div class="col-md-12">
                                <input type="number" nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][order_number]" value="0" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.validation') }}</label>
                            <div class="col-md-12 text-left">
                                <input type="text"   nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][validate]" value="" class="form-control " dir="ltr" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.blade_template') }}</label>
                            <div class="col-md-12 text-left">
                                <select class="form-control"  nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][blade_template]" data-size="7" data-style="btn btn-outline-info btn-round" title="Type">
                                    @foreach($DynamicFormsTemplate[$DynamicFormsId] as $bladeFile => $bladeLabel )
                                        <option value="{{$bladeFile}}">{{$bladeLabel}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12 col-form-label">{{ __('dynamicForm::form.font_icon') }}</label>
                            <div class="col-md-12 text-left">
                                <input type="text"   nameOFInputBox="moreField[{{$DynamicFormsId}}][__IIDD__][font_icon]" value="" class="form-control " dir="ltr" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="btn btn-danger rounded" onclick="$('.moreFieldsItem{{$DynamicFormsId}}___IIDD__').remove()">
                                                                 <span class="btn-label">
                                                                    <i class="fa fa-trash"></i>
                                                                 </span>
                        {{ __('dynamicForm::form.delete') }}
                    </div>
                    <div class="btn btn-info mt-4 rounded pointer" onclick="$('.moreFieldsItemMoreConfig{{$DynamicFormsId}}___IIDD__').toggle();">
                                                                 <span class="btn-label">
                                                                    <i class="fa fa-dot-circle-o"></i>
                                                                 </span>
                        {{ __('dynamicForm::form.more') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var numberOfElement{{$DynamicFormsId}} = @if(old('moreField.'.$DynamicFormsId)) {{ count(old('moreField.'.$DynamicFormsId)) }} @else {{ count($DynamicFormsField[$DynamicFormsId]) }} @endif;
    function add{{$DynamicFormsId}}() {
        var string = $('#typeOfAddItem{{$DynamicFormsId}}').html();
        string = string.replace(new RegExp('__IIDD__', 'g'), numberOfElement{{$DynamicFormsId}});
        string = string.replace(new RegExp('nameofinputbox', 'g'), 'name');
        $('#moreFields{{$DynamicFormsId}}').append(string);
        numberOfElement{{$DynamicFormsId}}++;
    }
</script>

