@foreach($DynamicFormsField[$DynamicFormsId] as $key => $field)
    @php $css_class = explode(',', $field->css_class); @endphp
    @if($field->type_variable == 'textarea')
        <div class="{{ $DynamicFormsStyle['Div'] }} {{ $css_class[0] ?? "" }}">
        <label class="{{ $DynamicFormsStyle['Label'] }} {{ $css_class[1] ?? "" }}" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
        <div class="{{ $DynamicFormsStyle['InputDiv'] }} {{ $css_class[2] ?? "" }}">
            <div class="form-check">
                <textarea rows="4" cols="50"  class="{{ $DynamicFormsStyle['Input'] }} @error($field->label) is-invalid @enderror  {{ $css_class[3] ?? "" }}" id="field_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{$field->id}}]" >{{ old("dynamicForms.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) }}</textarea>
            </div>
            @error($field->label)
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
            @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }} {{ $css_class[4] ?? "" }}">{{$field->description}}</div>@endif
        </div>
    </div>
    @elseif($field->type_variable ==  'checkbox')
        <div class="{{ $DynamicFormsStyle['Div'] }} {{ $css_class[0] ?? "" }}">
            <label class="{{ $DynamicFormsStyle['Label'] }} {{ $css_class[1] ?? "" }}" style="display: none;" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }} {{ $css_class[1] ?? "" }}">
                @foreach($field->valuesDe as $keyValue => $value)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input {{ $css_class[3] ?? "" }}" type="checkbox" value="{{$value}}" name="dynamicForms[{{$field->id}}][]" @if ( in_array( $value , old("dynamicForms.{$field->id}" , ( $field->value ) ? (array)$field->value : (array)$field->values ) ) ) checked @endif > {{$value}}
                        <span class="form-check-sign"><span class="check"></span></span>
                    </label>
                </div>
                @endforeach
                @error($field->label)
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                    @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }} {{ $css_class[4] ?? "" }}">{{$field->description}}</div>@endif
            </div>
        </div>
    @elseif($field->type_variable ==  'radio')
        <div class="{{ $DynamicFormsStyle['Div'] }} {{ $css_class[0] ?? "" }}">
            <label class="{{ $DynamicFormsStyle['Label'] }} {{ $css_class[1] ?? "" }}" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }} {{ $css_class[2] ?? "" }}">
                @foreach($field->valuesDe as $keyValue => $value)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input {{ $css_class[3] ?? "" }}" type="radio" value="{{$value}}" name="dynamicForms[{{$field->id}}]" @if (old("dynamicForms.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) == $value ) checked @endif  > {{$value}}
                        <span class="circle"><span class="check"></span></span>
                    </label>
                </div>
                @endforeach
                @error($field->label)
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                    @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }} {{ $css_class[4] ?? "" }}">{{$field->description}}</div>@endif
            </div>
        </div>
    @elseif($field->type_variable ==  'select')
        <div class="{{ $DynamicFormsStyle['Div'] }} {{ $css_class[0] ?? "" }}">
            <label class="{{ $DynamicFormsStyle['Label'] }} {{ $css_class[1] ?? "" }}" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }} {{ $css_class[2] ?? "" }}">
                <select class="{{ $DynamicFormsStyle['Input'] }} @error($field->label) is-invalid @enderror {{ $css_class[3] ?? "" }}" id="field_{{$field->id}}" name="dynamicForms[{{$field->id}}]" @if($field->status == 'required') required @endif>
                @foreach($field->valuesDe as $keyValue => $value)
                    <option value="{{$value}}" @if (old("dynamicForms.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) == $value ) selected @endif>{{$value}}</option>
                @endforeach
                </select>
                @error($field->label)
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }} {{ $css_class[4] ?? "" }}">{{$field->description}}</div>@endif
            </div>
        </div>


    @elseif($field->type_variable ==  'file')
        <div class="{{ $DynamicFormsStyle['Div'] }} {{ $css_class[0] ?? "" }}">
            <label class="{{ $DynamicFormsStyle['Label'] }} {{ $css_class[1] ?? "" }}" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif </label>
            <div class="{{ $DynamicFormsStyle['InputDiv'] }} {{ $css_class[2] ?? "" }}">
                @if ( $field->value != null ) <a href="{{$field->value}}" class="{{ $css_class[3] ?? "" }}" target="_blank">Download last file.</a> @endif
                @if ( $field->value != null )
                    <input type="hidden"  id="fieldHiddenHash_{{$field->id}}" name="dynamicFormsHash[{{$field->id}}]" value="{{$field->valueHash}}">
                    <input type="hidden"  id="fieldHidden_{{$field->id}}" name="dynamicForms[{{$field->id}}]" value="{{$field->valueFile}}">
                    <input type="{{ $field->type_variable }}" onchange="this.setAttribute('name','dynamicForms[{{$field->id}}]');document.getElementById('fieldHidden_{{$field->id}}').remove();document.getElementById('fieldHiddenHash_{{$field->id}}').remove();this.setAttribute('onchange','');"  id="field_{{$field->id}}" class="{{ $DynamicFormsStyle['Input'] }} @error($field->label) is-invalid @enderror {{ $css_class[3] ?? "" }}">
                @else
                    <input type="{{ $field->type_variable }}"  id="field_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{$field->id}}]" class="{{ $DynamicFormsStyle['Input'] }} @error($field->label) is-invalid @enderror {{ $css_class[3] ?? "" }}">
                @endif
                @error($field->label)
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }} {{ $css_class[4] ?? "" }}">{{$field->description}}</div>@endif
            </div>
        </div>
    @else
        @if( ( $FieldTypeId = array_search($field->type_variable, array_column($DynamicFormsFieldType[$DynamicFormsId], 'name')) ) !== false and isset($DynamicFormsFieldType[$DynamicFormsId][$FieldTypeId]['view']) and $DynamicFormsFieldType[$DynamicFormsId][$FieldTypeId]['view']  != null and View::exists($DynamicFormsFieldType[$DynamicFormsId][$FieldTypeId]['view']) )
            @include( $DynamicFormsFieldType[$DynamicFormsId][$FieldTypeId]['view'],
                ["DynamicFormsId" => $DynamicFormsId ,
                 "DynamicFormsStyle" => [
                     'Div' => $DynamicFormsStyle['Div'],
                     'Label' => $DynamicFormsStyle['Label'],
                     'InputDiv' => $DynamicFormsStyle['InputDiv'] ,
                     'Input' => $DynamicFormsStyle['Input'] ,
                     'Description' => $DynamicFormsStyle['Description']
                     ]
                  ])
        @else
            <div class="{{ $DynamicFormsStyle['Div'] }} {{ $css_class[0] ?? "" }}">
                <label class="{{ $DynamicFormsStyle['Label'] }} {{ $css_class[1] ?? "" }}" for="field_{{$field->id}}">{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
                <div class="{{ $DynamicFormsStyle['InputDiv'] }} {{ $css_class[2] ?? "" }}">
                    <input type="{{ $field->type_variable }}"  id="field_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{$field->id}}]" value="{{ old("dynamicForms.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) }}" class="{{ $DynamicFormsStyle['Input'] }} @error($field->label) is-invalid @enderror {{ $css_class[3] ?? "" }}">
                    @error($field->label)
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    @if($field->description != '')<div class="{{ $DynamicFormsStyle['Description'] }} {{ $css_class[4] ?? "" }}">{{$field->description}}</div>@endif
                </div>
            </div>
        @endif
    @endif
@endforeach

