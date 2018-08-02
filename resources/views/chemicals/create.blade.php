@extends('layouts.master')

@section('head')

    <style>
        #mobile-editor {
            width: 550px;
            height: 350px;
        }

        @media only screen and (max-width: 768px) {
            #mobile-editor {
                width: 320px;
                height: 300px;
                margin-left: 10px;
                margin-right: 10px;
            }
        }

    </style>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/dojo/1.11.2/dojo/dojo.js"></script>
    <script type="text/javascript" src='{{ asset('/js/JSDraw/Scilligence.JSDraw2.Pro.js') }}'></script>
@endsection

@section('content')
    <div class="mt-10 flex justify-center">
        <form class="flex flex-col" action="/chemicals" method="POST">
            {{ csrf_field() }}
            <input class="border mb-2" type="text" name="name" placeholder="Name of chemical">
            <input class="border mb-2" type="text" name="cas" placeholder="CAS (20-02-01)">
            <input class="border mb-2" type="hidden" name="molweight" id="molweight" placeholder="">
            <input class="border mb-2" type="hidden" name="molfile" id="molfile" value="" placeholder="">
            <input class="border mb-2" type="text" name="density" placeholder="density">
            <input class="border mb-2" type="text" name="remarks" placeholder="remarks">
            <button class="border border-green text-green rounded hover:bg-green hover:text-white">Save</button>
        </form>
    </div>

   <div class="mt-4 flex justify-center">
       <div
               class="JSDraw"
               id="mobile-editor"
               dataformat='molfile'
               data=""
               skin="w8"
               ondatachange='molchange'
       ></div>
   </div>


@endsection

@section('scripts')
    <script type="text/javascript">
        dojo.addOnLoad(function() {
            new JSDraw("mobile-editor");
        });

        function molchange(jsdraw) {
            document.getElementById("molfile").value = JSDraw.get("mobile-editor").getMolfile();
            document.getElementById("molweight").value = Math.round(JSDraw.get("mobile-editor").getMolWeight()*100)/100;
        }

    </script>
@endsection