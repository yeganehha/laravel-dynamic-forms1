@if ( isset($dynamicFormsType[$DynamicFormsId]) )
    @if ($dynamicFormsType[$DynamicFormsId] == 'editForm')
        @include("DynamicForms::editForm" , ["DynamicFormsId" => $DynamicFormsId])
    @elseif ($dynamicFormsType[$DynamicFormsId] == 'fillOut')
        @include("DynamicForms::fillOutForm" ,
                ["DynamicFormsId" => $DynamicFormsId ,
                 "DynamicFormsStyle" => [
                     'Div' => (isset($DynamicFormsStyle['Div']))  ? $DynamicFormsStyle['Div'] : "col-md-12" ,
                     'Label' => (isset($DynamicFormsStyle['Label']))  ? $DynamicFormsStyle['Label'] : "col-md-2 col-form-label" ,
                     'InputDiv' => (isset($DynamicFormsStyle['InputDiv']))  ? $DynamicFormsStyle['InputDiv'] : "col-md-10" ,
                     'Input' => (isset($DynamicFormsStyle['Input']))  ? $DynamicFormsStyle['Input'] : "form-control",
                     'Description' => (isset($DynamicFormsStyle['Description']))  ? $DynamicFormsStyle['Description'] : "small text-gray"
                     ]
                  ])
    @endif
@else
    <div class="alert alert-danger mt-1">
        <strong>Wrong Form ID!</strong> ( Id You send: {{ $DynamicFormsId }})
    </div>
@endif
