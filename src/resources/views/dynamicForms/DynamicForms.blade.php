@if ( isset($dynamicFormsType[$DynamicFormsId]) )
    @if ($dynamicFormsType[$DynamicFormsId] == 'editForm')
        @include("DynamicForms::editForm" , ["DynamicFormsId" => $DynamicFormsId])
    @elseif ($dynamicFormsType[$DynamicFormsId] == 'fillOut')
        @include("DynamicForms::fillOutForm" , ["DynamicFormsId" => $DynamicFormsId])
    @endif
@else
    <div class="alert alert-danger mt-1">
        <strong>Wrong Form ID!</strong> ( Id You send: {{ $DynamicFormsId }})
    </div>
@endif
