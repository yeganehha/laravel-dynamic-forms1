@foreach($DynamicFormsField[$DynamicFormsId] as $key => $field)
    @if($field->type_variable == 'textarea')
        <div class="{{ $DynamicFormsStyle['Div'] }}">
        <label class="{{ $DynamicFormsStyle['Label'] }}" for="field_{{$DynamicFormsId}}_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
        <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
            <div class="form-check">
                <textarea rows="4" cols="50"  class="{{ $DynamicFormsStyle['Input'] }} @error($field->label) is-invalid @enderror " id="field_{{$DynamicFormsId}}_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{$DynamicFormsId}}][{{$field->id}}]" >{{ old("dynamicForms.{$DynamicFormsId}.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) }}</textarea>
            </div>
            @error($field->label)
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
            @if($field->description != '')<div id="field_{{$DynamicFormsId}}_{{$field->id}}_help" class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
        </div>
    </div>
    @elseif($field->type_variable ==  'checkbox')
        <div class="{{ $DynamicFormsStyle['Div'] }}">
            <label class="{{ $DynamicFormsStyle['Label'] }}" style="display: none;" for="field_{{$DynamicFormsId}}_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
                @foreach($field->valuesDe as $keyValue => $value)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="{{$value}}" name="dynamicForms[{{$DynamicFormsId}}][{{$field->id}}][]" @if ( in_array( $value , old("dynamicForms.{$DynamicFormsId}.{$field->id}" , ( $field->value ) ? (array)$field->value : (array)$field->values ) ) ) checked @endif > {{$value}}
                        <span class="form-check-sign"><span class="check"></span></span>
                    </label>
                </div>
                @endforeach
                @error($field->label)
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                    @if($field->description != '')<div id="field_{{$DynamicFormsId}}_{{$field->id}}_help" class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
            </div>
        </div>
    @elseif($field->type_variable ==  'radio')
        <div class="{{ $DynamicFormsStyle['Div'] }}">
            <label class="{{ $DynamicFormsStyle['Label'] }}" for="field_{{$DynamicFormsId}}_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
                @foreach($field->valuesDe as $keyValue => $value)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" value="{{$value}}" name="dynamicForms[{{$DynamicFormsId}}][{{$field->id}}]" @if (old("dynamicForms.{$DynamicFormsId}.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) == $value ) checked @endif  > {{$value}}
                        <span class="circle"><span class="check"></span></span>
                    </label>
                </div>
                @endforeach
                @error($field->label)
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                    @if($field->description != '')<div id="field_{{$DynamicFormsId}}_{{$field->id}}_help" class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
            </div>
        </div>
    @elseif($field->type_variable ==  'select')
        <div class="{{ $DynamicFormsStyle['Div'] }}">
            <label class="{{ $DynamicFormsStyle['Label'] }}" for="field_{{$DynamicFormsId}}_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
                <select class="{{ $DynamicFormsStyle['Input'] }} @error($field->label) is-invalid @enderror" id="field_{{$DynamicFormsId}}_{{$field->id}}" name="dynamicForms[{{$DynamicFormsId}}][{{$field->id}}]" @if($field->status == 'required') required @endif>
                @foreach($field->valuesDe as $keyValue => $value)
                    <option value="{{$value}}" @if (old("dynamicForms.{$DynamicFormsId}.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) == $value ) selected @endif>{{$value}}</option>
                @endforeach
                </select>
                @error($field->label)
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                @if($field->description != '')<div id="field_{{$DynamicFormsId}}_{{$field->id}}_help" class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
            </div>
        </div>


    @elseif($field->type_variable ==  'file')
        <div class="{{ $DynamicFormsStyle['Div'] }}">
            <label class="{{ $DynamicFormsStyle['Label'] }}" for="field_{{$DynamicFormsId}}_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif </label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
                @if ( $field->value != null ) <a href="{{$field->value}}" class="{{ $css_class[3] ?? "" }}" target="_blank">Download last file.</a> @endif
                @if ( $field->value != null )
                    <input type="hidden"  id="fieldHiddenHash_{{$field->id}}" name="dynamicFormsHash[{{$field->id}}]" value="{{$field->valueHash}}">
                    <input type="hidden"  id="fieldHidden_{{$field->id}}" name="dynamicForms[{{$DynamicFormsId}}][{{$field->id}}]" value="{{$field->valueFile}}">
                    <input type="{{ $field->type_variable }}" onchange="this.setAttribute('name','dynamicForms[{{$field->id}}]');document.getElementById('fieldHidden_{{$field->id}}').remove();document.getElementById('fieldHiddenHash_{{$field->id}}').remove();this.setAttribute('onchange','');"  id="field_{{$DynamicFormsId}}_{{$field->id}}" class="{{ $DynamicFormsStyle['Input'] }} @error($field->label) is-invalid @enderror">
                @else
                    <input type="{{ $field->type_variable }}"  id="field_{{$DynamicFormsId}}_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{$DynamicFormsId}}][{{$field->id}}]" class="{{ $DynamicFormsStyle['Input'] }} @error($field->label) is-invalid @enderror">
                @endif
                @error($field->label)
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                @if($field->description != '')<div id="field_{{$DynamicFormsId}}_{{$field->id}}_help" class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
            </div>
        </div>
    @else
        @if( ( $FieldTypeId = array_search($field->type_variable, array_column($DynamicFormsFieldType[$DynamicFormsId], 'name')) ) !== false and isset($DynamicFormsFieldType[$DynamicFormsId][$FieldTypeId]['view']) and $DynamicFormsFieldType[$DynamicFormsId][$FieldTypeId]['view']  != null and View::exists($DynamicFormsFieldType[$DynamicFormsId][$FieldTypeId]['view']) )
            @include( $DynamicFormsFieldType[$DynamicFormsId][$FieldTypeId]['view'],
                ["DynamicFormsId" => $DynamicFormsId ,
                 "field" => $field ,
                 "DynamicFormsFieldType" => $DynamicFormsFieldType ,
                 "DynamicFormsStyle" => [
                     'Div' => $DynamicFormsStyle['Div'],
                     'Label' => $DynamicFormsStyle['Label'],
                     'InputDiv' => $DynamicFormsStyle['InputDiv'] ,
                     'Input' => $DynamicFormsStyle['Input'] ,
                     'Description' => $DynamicFormsStyle['Description']
                     ]
                  ])
        @else
            <div class="{{ $DynamicFormsStyle['Div'] }}">
                <label class="{{ $DynamicFormsStyle['Label'] }}" for="field_{{$DynamicFormsId}}_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
                <div class="{{ $DynamicFormsStyle['InputDiv'] }}">
                    <input type="{{ $field->type_variable }}"  id="field_{{$DynamicFormsId}}_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{$DynamicFormsId}}][{{$field->id}}]" value="{{ old("dynamicForms.{$DynamicFormsId}.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) }}" class="{{ $DynamicFormsStyle['Input'] }} @error($field->label) is-invalid @enderror">
                    @error($field->label)
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    @if($field->description != '')<div id="field_{{$DynamicFormsId}}_{{$field->id}}_help" class="{{ $DynamicFormsStyle['Description'] }}">{{$field->description}}</div>@endif
                </div>
            </div>
        @endif
    @endif
@endforeach

