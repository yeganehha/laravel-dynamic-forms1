@if($field->type_variable == 'textarea')
    <div class="form-group">
        <label for="field_{{ $DFId }}_{{$field->id}}">@if($field->font_icon != '')<i class="{{$field->font_icon}}"></i> @endif{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
        <textarea rows="4" cols="50"  class="form-control @error($field->label) is-invalid @enderror" id="field_{{ $DFId }}_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{ $DFId }}][{{$field->id}}]" >{{ old("dynamicForms.{$DFId}.{$field->id}" , $field->value ?? $field->values ) }}</textarea>
        @error($field->label)
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        @if($field->description != '')<div id="field_{{ $DFId }}_{{$field->id}}_help" class="form-text text-muted">{{$field->description}}</div>@endif
    </div>
@elseif($field->type_variable ==  'checkbox')
    <div class="form-group">
        <label for="field_{{ $DFId }}_{{$field->id}}">@if($field->font_icon != '')<i class="{{$field->font_icon}}"></i> @endif{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
        @foreach($field->valuesDe as $keyValue => $value)
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="{{$value}}" name="dynamicForms[{{ $DFId }}][{{$field->id}}][]" @if ( in_array( $value , old("dynamicForms.{$DFId}.{$field->id}" ,  (array)$field->value ?? (array)$field->values ) ) ) checked @endif >
            <label class="custom-control-label">{{$value}}</label>
        </div>
        @endforeach
        @error($field->label)
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        @if($field->description != '')<div id="field_{{ $DFId }}_{{$field->id}}_help" class="form-text text-muted">{{$field->description}}</div>@endif
    </div>
@elseif($field->type_variable ==  'radio')
    <div class="form-group">
        <label for="field_{{ $DFId }}_{{$field->id}}">@if($field->font_icon != '')<i class="{{$field->font_icon}}"></i> @endif{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
        @foreach($field->valuesDe as $keyValue => $value)
        <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" value="{{$value}}" name="dynamicForms[{{ $DFId }}][{{$field->id}}]" @if (old("dynamicForms.{$DFId}.{$field->id}" ,  $field->value ?? $field->values ) == $value ) checked @endif  >
            <label class="form-check-label">{{$value}}</label>
        </div>
        @endforeach
        @error($field->label)
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        @if($field->description != '')<div id="field_{{ $DFId }}_{{$field->id}}_help" class="form-text text-muted">{{$field->description}}</div>@endif
    </div>
@elseif($field->type_variable ==  'select')
    <div class="form-group">
        <label for="field_{{ $DFId }}_{{$field->id}}">@if($field->font_icon != '')<i class="{{$field->font_icon}}"></i> @endif{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
        <select class="custom-select @error($field->label) is-invalid @enderror" id="field_{{ $DFId }}_{{$field->id}}" name="dynamicForms[{{ $DFId }}][{{$field->id}}]" @if($field->status == 'required') required @endif>
        @foreach($field->valuesDe as $keyValue => $value)
            <option value="{{$value}}" @if (old("dynamicForms.{$DFId}.{$field->id}" , ( $field->value ) ? $field->value : $field->values ) == $value ) selected @endif>{{$value}}</option>
        @endforeach
        </select>
        @error($field->label)
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        @if($field->description != '')<div id="field_{{ $DFId }}_{{$field->id}}_help" class="form-text text-muted">{{$field->description}}</div>@endif
    </div>
@elseif($field->type_variable ==  'file')
    <div class="form-group">
        <label for="field_{{ $DFId }}_{{$field->id}}">@if($field->font_icon != '')<i class="{{$field->font_icon}}"></i> @endif{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif </label>
        <div class="custom-file">
            @if ( $field->value != null )
                <a href="{{$field->value}}" target="_blank">{{ trans('dynamicForm::form.download_file') }}</a>
                <input type="hidden"  id="fieldHiddenHash_{{ $DFId }}_{{$field->id}}" name="dynamicFormsHash[{{$field->id}}]" value="{{$field->valueHash}}">
                <input type="hidden"  id="fieldHidden_{{ $DFId }}_{{$field->id}}" name="dynamicForms[{{ $DFId }}][{{$field->id}}]" value="{{$field->valueFile}}">
                <input type="{{ $field->type_variable }}" onchange="this.setAttribute('name','dynamicForms[{{ $DFId }}][{{$field->id}}]');document.getElementById('fieldHidden_{{ $DFId }}_{{$field->id}}').remove();document.getElementById('fieldHiddenHash_{{ $DFId }}_{{$field->id}}').remove();this.setAttribute('onchange','');"  id="field_{{ $DFId }}_{{$field->id}}" class="form-control @error($field->label) is-invalid @enderror">
            @else
                <input type="{{ $field->type_variable }}"  id="field_{{ $DFId }}_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{ $DFId }}][{{$field->id}}]" class="form-control @error($field->label) is-invalid @enderror">
            @endif
            @error($field->label)
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
            @if($field->description != '')<div id="field_{{ $DFId }}_{{$field->id}}_help" class="form-text text-muted">{{$field->description}}</div>@endif
        </div>
    </div>
@else
    @if( ( $FieldTypeId = array_search($field->type_variable, array_column($fieldType, 'name')) ) !== false and isset($fieldType[$FieldTypeId]['view']) and $fieldType[$FieldTypeId]['view']  != null and View::exists($fieldType[$FieldTypeId]['view']) )
        @include( $fieldType[$FieldTypeId]['view'],
            ["DynamicFormsId" => $DFId ,
             "DynamicFormsFieldType" => [ $DFId => $fieldType] ,
             "field" => $field ,
             "DynamicFormsStyle" => [
                 'Div' => $DynamicFormsStyle['Div'] ?? "",
                 'Label' => $DynamicFormsStyle['Label'] ?? "",
                 'InputDiv' => $DynamicFormsStyle['InputDiv']  ?? "",
                 'Input' => $DynamicFormsStyle['Input'] ?? "" ,
                 'Description' => $DynamicFormsStyle['Description'] ?? ""
                 ]
              ])
    @else
        <div class="form-group">
            <label for="field_{{ $DFId }}_{{$field->id}}">@if($field->font_icon != '')<i class="{{$field->font_icon}}"></i> @endif{{$field->label}} @if ( $field->status == 'required' ) <span class="text-danger">*</span>@endif</label>
            <input type="{{ $field->type_variable }}"  id="field_{{ $DFId }}_{{$field->id}}" @if($field->status == 'required') required @endif name="dynamicForms[{{ $DFId }}][{{$field->id}}]" value="{{ old("dynamicForms.{$DFId}.{$field->id}" , $field->value  ?? $field->values ) }}" class="form-control @error($field->label) is-invalid @enderror">
            @error($field->label)
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
            @if($field->description != '')<div id="field_{{ $DFId }}_{{$field->id}}_help" class="form-text text-muted">{{$field->description}}</div>@endif
        </div>
    @endif
@endif


