<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Table lis member</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/plugins/print/style_print.css')}}">
</head>

<body style="background: rgb(204,204,204);">

<page size='A4' layout='landscape'>
    <div align="center" >
        <a class='title1'>ព្រះរាជាណាចក្រកម្ពុជា</a><br>
        <a class='title2'>ជាតិ សាសនា ព្រះមហាក្សត្រ</a><br>
        <div style="width: 120px; align-self: center">
            <hr style="border: double">
        </div>
    </div>

    <div class="mr-5 float-right">
        <a class='content'><b>លិខិតលេខៈ </b> {{$document->letter_code}}</a><br>
        <a class='content'><b>លេខលិខិតចូលៈ </b> {{$document->code_in}}</a><br>
        <a class='content'><b>លេខសំគាល់ឯកសារៈ </b> {{$document->document_code}}</a><br>
        <a class='content'><b>ចុះថ្ងៃទីៈ </b> {{$document->created_at->format('d-M-Y H:i:s')}}</a><br>
        <a class='content float-leftt'><b>អ្នកបញ្ចូលលិខិតៈ </b>{{$document->user_create->title->name_kh}} {{$document->user_create->name_kh}}</a><br>

    </div>

    <div id="logo">
        <a class='content ml-3'>ក្រសួងសុខាភិបាល</a>
        <div class="ml-3">
            <img class="ml-2" src="{{asset('Logo_Calmette_BW.jpg')}}" height="120px" width="auto" /><br>

        </div>
    </div>




    <div class="pull-right">
        <div align="center">
            <a class='title1' style="align-self: center"><u>កំណត់បង្ហាញ</u></a><br>
        </div>
    </div>

    <div class="ml-5 mr-5 mt-2" id="docinfo">
        {{--        <a class='content float-leftt'><b>លិខិតលេខៈ </b> {{$document->letter_code}}</a>--}}
        {{--        <a class='content float-right'><b>ចុះថ្ងៃទីៈ </b> {{$document->created_at->format('d-M-Y H:i:s')}}</a><br>--}}
        <a class='content float-leftt'><b>មកពីៈ </b> {{$document->oranization}}</a><br>

        <a class='content float-leftt'><b>កម្មវត្ថុៈ </b> {{$document->description}}</a>
        <hr>
    </div>

    @foreach($comments as $comment)
        <div class="ml-5 mr-5 mb-3 mt-2">
            <a class='title2 float-left'>{{$comment->user->department->name_kh}}: &nbsp; </a> <a class='content float-left'><b>{{$comment->user->title->name_kh}} {{$comment->user->name_kh}}៖ </b></a>
            <a class='content float-right'>{{$comment->updated_at->format('d-M-Y   H:i:s')}}</a><br>
            <a class='content'>{{$comment->comment}}</a><br>        </div>
    @endforeach

    <div class="ml-5 mr-5 mb-3 mt-2" align="center">
        <a class='title2'>អគ្គនាយកមន្ទីរពេទ្យ</a><br>
        {{--<a class='content'><b>ឯកឧត្តមសាស្ត្រាចារ្យ ឈាង រ៉ា ៖</b></a><br>--}}

    </div>



</page>

</body>

<script  type="text/javascript">

    window.print();

</script>
</html>
