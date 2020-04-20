<!DOCTYPE html>
<html>
<head>
    <title>PDF Editor</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.css">
    <link rel="stylesheet" href="{{asset('adminlte/plugins/pdfjsannotation/styles.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/plugins/pdfjsannotation/pdfannotate.css')}}">

</head>
<body>
<div class="toolbar">
    <div class="tool">
        <label for="">Brush size</label>
        <input type="number" class="form-control text-right" value="1" id="brush-size" max="50">
    </div>
    <div class="tool">
        <label for="">Font size</label>
        <select id="font-size" class="form-control">
            <option value="10">10</option>
            <option value="12">12</option>
            <option value="16" selected>16</option>
            <option value="18">18</option>
            <option value="24">24</option>
            <option value="32">32</option>
            <option value="48">48</option>
            <option value="64">64</option>
            <option value="72">72</option>
            <option value="108">108</option>
        </select>
    </div>
    <div class="tool">
        <button class="color-tool active" style="background-color: #212121;"></button>
        <button class="color-tool" style="background-color: red;"></button>
        <button class="color-tool" style="background-color:#3374ff;"></button>
        <button class="color-tool" style="background-color: blue;"></button>
        <button class="color-tool" style="background-color: green;"></button>
        <button class="color-tool" style="background-color: yellow;"></button>
    </div>
    <div class="tool">
        <button class="tool-button active"><i class="fa fa-hand-paper-o" title="Free Hand"
                                              onclick="enableSelector(event)"></i></button>
    </div>
    <div class="tool">
        <button class="tool-button"><i class="fa fa-pencil" title="Pencil" onclick="enablePencil(event)"></i></button>
    </div>
    <div class="tool">
        <button class="tool-button"><i class="fa fa-font" title="Add Text" onclick="enableAddText(event)"></i></button>
    </div>
    <div class="tool">
        <button class="tool-button"><i class="fa fa-long-arrow-right" title="Add Arrow"
                                       onclick="enableAddArrow(event)"></i></button>
    </div>
    <div class="tool">
        <button class="tool-button"><i class="fa fa-square-o" title="Add rectangle"
                                       onclick="enableRectangle(event)"></i></button>
    </div>
    <div class="tool">
        <button class="btn btn-danger btn-sm" onclick="deleteSelectedObject(event)"><i class="fa fa-trash"></i></button>
    </div>
    <div class="tool">
        <button class="btn btn-danger btn-sm" onclick="clearPage()">Clear Page</button>
    </div>
    <div class="tool">
        <button class="btn btn-warning btn-sm" onclick="closeWithoutSave()"><i class="fa fa-close"></i> Close</button>
    </div>
    <div class="tool">
        <button class="btn btn-primary btn-sm" onclick="savePDF()"><i class="fa fa-save"></i> Save and Close</button>
    </div>

    <div class="tool">
        <button class="btn btn-primary btn-sm" onclick="setValue()"><i class="fa fa-save"></i> Set</button>
    </div>

    <div class="tool">
{{--        <form class="form-horizontal file-upload" method="post" enctype="multipart/form-data">--}}
            {!! Form::open(['method' => 'POST', 'route' => ['admin.documents.save_pdf'], 'files' => true,'id'=>'form_upload']) !!}
            {{ csrf_field() }}
            <input type="text" name="media_id" value="{{$media->id}}" hidden>
            <input type="text" name="media_file" value="{{$media->file_name}}" hidden>
            <input type="text" name="document_id" value="{{$document->id}}" hidden>

            <input type="file" name="pdf" id="import_file" >

            <br>
            <button class="btn btn-primary btn-sm" type="submit" id="send_data"><i class="fa fa-save"></i> submit</button>
{{--        </form>--}}
        {!! Form::close() !!}

{{--        {!! Form::file('file[]', [--}}
{{--                        'multiple',--}}
{{--                        'class' => 'form-control file-upload',--}}
{{--                        'data-url' => route('admin.media.upload'),--}}
{{--                        'data-bucket' => 'file',--}}
{{--                        'data-filekey' => 'file',--}}
{{--                        'hidden'=>'true',--}}
{{--                        ]) !!}--}}
    </div>
</div>
<div id="pdf-container"></div>

<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
        <span class="fa fa-spinner fa-pulse fa-3x fa-fw" style="color: white"></span><br>
        <span id="text_state" style="color: white">Uploading</span>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.328/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.22/fabric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
<script src="{{asset('adminlte/plugins/pdfjsannotation/arrow.fabric.js')}}"></script>
<script src="{{asset('adminlte/plugins/pdfjsannotation/pdfannotate.js')}}"></script>

<script>

    {{--$(function () {--}}
    {{--     // $('.file-upload').each(function () {--}}
    {{--        var $this = $(this);--}}
    {{--        var $parent = $(this).parent();--}}

    {{--        $('.file-upload').fileupload({--}}
    {{--            dataType: 'json',--}}
    {{--            formData: {--}}
    {{--                model_name: 'Document',--}}
    {{--                bucket: $this.data('bucket'),--}}
    {{--                file_key: $this.data('filekey'),--}}
    {{--                _token: '{{ csrf_token() }}'--}}
    {{--            },--}}
    {{--            add: function (e, data) {--}}
    {{--                data.submit();--}}
    {{--            },--}}
    {{--        });--}}

    {{--});--}}

    var pdf = new PDFAnnotate('pdf-container', '{{asset('storage').'/' .$media->id.'/'.$media->file_name}}', {
        onPageUpdated: (page, oldData, newData) => {
            console.log(page, oldData, newData);
        }
    });

    function modal(){
        // $('.modal').modal('show');
        $('.modal').modal({
            backdrop: 'static',
            keyboard: false
        });
        // setTimeout(function () {
        //     console.log('completed');
        //     $('.modal').modal('hide');
        // }, 3000);
    }

    function setValue() {

        // var blob = pdf.savePdfToServer();
        // // $('#form_upload').append('<input name="pdf" id="pdf" type="file" value="'+ blob +'" />');
        // $('#import_file').value(blob);
        // // alert($('#pdf').value());

    var blob = pdf.savePdfToServer();
            var fd = new FormData();
            fd.append('pdf', blob);
            fd.append('media_id', {!! json_encode($media->id) !!});
            fd.append('media_file', {!! json_encode($media->file_name) !!});
            fd.append('document_id', {!! json_encode($document->id) !!});
            $.ajax({
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                url: '{{ route('admin.documents.save_pdf') }}',
                type: 'POST',
                cache: false,
                data: fd,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    console.log('Uploading');
                    modal();
                    $("#text_state").html("Uploading, please wait....");
                },
                success: function () {
                    console.log('Success!');
                    $("#text_state").html("Upload success.");
                },
                complete: function (response) {
                    console.log('Complete!');
                    console.log(response);
                    $("#text_state").html("Upload complete.");
                    close();
                },
                error: function () {
                    $("#text_state").html("Upload Error!");
                    alert("ERROR in upload");
                }
            });


    }

    function uploadFile (data) {
        // define data and connections
        var blob = new Blob([JSON.stringify(data)]);
        var url = URL.createObjectURL(blob);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin/documents/save_pdf', true);

        // define new form
        var formData = new FormData();
        formData.append('someUploadIdentifier', blob, 'someFileName.json');

        // action after uploading happens
        xhr.onload = function(e) {
            console.log("File uploading completed!");
            console.log(response);
        };

        // do the uploading
        console.log("File uploading started!");
        xhr.send(formData);
    }



    function enableSelector(event) {
        event.preventDefault();
        var element = ($(event.target).hasClass('tool-button')) ? $(event.target) : $(event.target).parents('.tool-button').first();
        $('.tool-button.active').removeClass('active');
        $(element).addClass('active');
        pdf.enableSelector();
    }

    function enablePencil(event) {
        event.preventDefault();
        var element = ($(event.target).hasClass('tool-button')) ? $(event.target) : $(event.target).parents('.tool-button').first();
        $('.tool-button.active').removeClass('active');
        $(element).addClass('active');
        pdf.enablePencil();
    }

    function enableAddText(event) {
        event.preventDefault();
        var element = ($(event.target).hasClass('tool-button')) ? $(event.target) : $(event.target).parents('.tool-button').first();
        $('.tool-button.active').removeClass('active');
        $(element).addClass('active');
        pdf.enableAddText();
    }

    function enableAddArrow(event) {
        event.preventDefault();
        var element = ($(event.target).hasClass('tool-button')) ? $(event.target) : $(event.target).parents('.tool-button').first();
        $('.tool-button.active').removeClass('active');
        $(element).addClass('active');
        pdf.enableAddArrow();
    }

    function enableRectangle(event) {
        event.preventDefault();
        var element = ($(event.target).hasClass('tool-button')) ? $(event.target) : $(event.target).parents('.tool-button').first();
        $('.tool-button.active').removeClass('active');
        $(element).addClass('active');
        pdf.setColor('rgba(255, 0, 0, 0.3)');
        pdf.setBorderColor('blue');
        pdf.enableRectangle();
    }

    function deleteSelectedObject() {
        event.preventDefault();
        pdf.deleteSelectedObject();
    }

    function closeWithoutSave() {
        close();
    }

    function savePDF() {
        // modal();
        var blob = pdf.savePdfToServer();
        // var blob = pdf.serializePdf();

        var formData = new FormData();
        formData.append('pdf', blob);
        formData.append('media_id', {!! json_encode($media->id) !!});
        formData.append('media_file', {!! json_encode($media->file_name) !!});
        formData.append('document_id', {!! json_encode($document->id) !!});
        {{--formData.append('document_id', {!! json_encode($document->id) !!});--}}


        $.ajax({
            headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
            url: "{{ route('admin.documents.save_pdf') }}",
            data: formData,
            type: 'post',
            async: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                console.log('Uploading');
                modal();
                $("#text_state").html("Uploading, please wait....");
            },
            success: function () {
                console.log('Success!');
                $("#text_state").html("Upload success.");
            },
            complete: function (response) {
                console.log('Complete!');
                console.log(response);
                $("#text_state").html("Upload complete.");
                close();
            },
            error: function () {
                $("#text_state").html("Upload Error!");
                alert("ERROR in upload");
            }
            // success:function(response){
            //     console.log(response);
            //     alert('uploaded');
            // }
        });




    {{--$.ajaxSetup({--}}
        {{--    headers: {--}}
        {{--        'X-CSRF-TOKEN': "{{ csrf_token() }}"--}}
        {{--    }--}}
        {{--});--}}
        {{--$.ajax('{{ route('admin.documents.save_pdf') }}',--}}
        {{--    {--}}
        {{--        method: 'POST',--}}
        {{--        data: formData,--}}
        {{--        processData: false,--}}
        {{--        contentType: false,--}}
        {{--        success: function(data)--}}
        {{--        {--}}
        {{--            console.log(data);--}}
        {{--            --}}{{--window.location.href = "{{ route('admin.documents.show',$document->id )}}";--}}
        {{--            // close();--}}
        {{--        },--}}
        {{--        error: function(data){console.log(data)}--}}
        {{--    });--}}

    }

    function clearPage() {
        pdf.clearActivePage();
    }

    function showPdfData() {
        var string = pdf.serializePdf();
        $('#dataModal .modal-body pre').first().text(string);
        PR.prettyPrint();
        $('#dataModal').modal('show');
    }

    $(function () {
        $('.color-tool').click(function () {
            $('.color-tool.active').removeClass('active');
            $(this).addClass('active');
            color = $(this).get(0).style.backgroundColor;
            pdf.setColor(color);
        });

        $('#brush-size').change(function () {
            var width = $(this).val();
            pdf.setBrushSize(width);
        });

        $('#font-size').change(function () {
            var font_size = $(this).val();
            pdf.setFontSize(font_size);
        });
    });

</script>
</body>
</html>
