<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Styles -->
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
        <script type="text/javascript" src='/js/JSDraw/Scilligence.JSDraw2.Pro.js'></script>

    </head>
    <body>
       <center>
           <h2 class="text-green">Search</h2> 

                <div class="JSDraw" id="mobile-editor" dataformat='molfile' skin="w8" ondatachange='molchange'></div>
                
                <form action="/search" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="molfile" id="molfile" value="">
                
                    <button class="mt-4 rounded bg-blue-dark px-4 py-2 text-white shadow-lg hover:bg-blue">Search</button>
                </form>

       </center>


        <script type="text/javascript">
            dojo.addOnLoad(function() {
                var jsd2 = new JSDraw("mobile-editor");
            });
            function molchange(jsdraw) {
                document.getElementById("molfile").value = JSDraw.get("mobile-editor").getMolfile();
            }
        </script>

    </body>
</html>
