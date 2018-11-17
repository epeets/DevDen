@extends('auth.layouts.app')

@section('content')
    @auth
    <h1>WordPress Post Importer</h1>
    {!! Form::open(['action' => 'WPImportController@store', 'method' => 'POST']) !!}
    <div class='form-group'>
        {{Form::label('API Url','API Url')}}
        {{Form::text('api','', ['class' => 'form-control', 'placeholder' => 'WordPress API URL', 'required'])}}
    </div>
    <div class="progress">
        <div class="bar"></div >
        <div class="percent">0%</div >
    </div>
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    @endauth
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
 
<script type="text/javascript">
 
    function validate(formData, jqForm, options) {
        var form = jqForm[0];
        if (!form.file.value) {
            alert('File not found');
            return false;
        }
    }
 
    (function() {
 
    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');
 
    $('form').ajaxForm({
        beforeSubmit: validate,
        beforeSend: function() {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=file]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function() {
            var percentVal = 'Wait, Saving';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        complete: function(xhr) {
            status.html(xhr.responseText);
            alert('Uploaded Successfully');
            window.location.href = "/auth/tools/import/wp";
        }
    });
     
    })();
</script>