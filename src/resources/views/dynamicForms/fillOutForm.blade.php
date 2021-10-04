@foreach($moreField[$DynamicFormsId] as $key => $field)
    @if($field->type_variable == 'textarea')
        <div class="{{ $DynamicFormsStyle['Div'] }}">
        <label class="{{ $DynamicFormsStyle['Label'] }}" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
        <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
            <div class="form-check">
                <textarea rows="4" cols="50"  class="{{ $DynamicFormsStyle['Input'] }}" id="field_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{$field->id}}]" >{{ old("dynamicForms.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) }}</textarea>
            </div>
            @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
        </div>
    </div>
    @elseif($field->type_variable ==  'checkbox')
        <div class="{{ $DynamicFormsStyle['Div'] }}">
            <label class="{{ $DynamicFormsStyle['Label'] }}" style="display: none;" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
                @foreach($field->valuesDe as $keyValue => $value)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="{{$value}}" name="dynamicForms[{{$field->id}}][]" @if (old("dynamicForms.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) == $value ) checked @endif > {{$value}}
                        <span class="form-check-sign"><span class="check"></span></span>
                    </label>
                </div>
                @endforeach
                @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
            </div>
        </div>
    @elseif($field->type_variable ==  'radio')
        <div class="{{ $DynamicFormsStyle['Div'] }}">
            <label class="{{ $DynamicFormsStyle['Label'] }}" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
                @foreach($field->valuesDe as $keyValue => $value)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" value="{{$value}}" name="dynamicForms[{{$field->id}}]" @if (old("dynamicForms.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) == $value ) checked @endif  > {{$value}}
                        <span class="circle"><span class="check"></span></span>
                    </label>
                </div>
                @endforeach
                @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
            </div>
        </div>
    @elseif($field->type_variable ==  'select')
        <div class="{{ $DynamicFormsStyle['Div'] }}">
            <label class="{{ $DynamicFormsStyle['Label'] }}" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
                <select class="{{ $DynamicFormsStyle['Input'] }}" id="field_{{$field->id}}" name="dynamicForms[{{$field->id}}]" @if($field->status == 'required') required @endif>
                @foreach($field->valuesDe as $keyValue => $value)
                    <option value="{{$value}}" @if (old("dynamicForms.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) == $value ) selected @endif>{{$value}}</option>
                @endforeach
                </select>
                @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
            </div>
        </div>


    @else
        <div class="{{ $DynamicFormsStyle['Div'] }}">
            <label class="{{ $DynamicFormsStyle['Label'] }}" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
                <input type="{{ $field->type_variable }}"  id="field_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{$field->id}}]" value="{{ old("dynamicForms.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) }}" class="{{ $DynamicFormsStyle['Input'] }}">
                @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
            </div>
        </div>
    @endif
@endforeach

