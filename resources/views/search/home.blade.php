@extends('layouts.master')

@section('head')
    <style>
        #search:focus {
            outline: none;
        }
    </style>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/dojo/1.11.2/dojo/dojo.js"></script>
    <script type="text/javascript" src='{{ asset('/js/JSDraw/Scilligence.JSDraw2.Pro.js') }}'></script>

@endsection

@section('content')

    <div class="h-screen mb-10 pt-10">
        <div class="flex justify-center mb-6">
            <div class="w-screen flex justify-center">
                <div class="flex flex-col justify-center items-center">
                    <img class="block mb-4"  src="{{ asset('img/logo.jpg') }}" alt="ChemDB">
                    <form action="/search" method="GET" autocomplete="off">
                        <div class="flex justify-center w-screen">
                            <input
                                v-show="textSearch"
                                id="search"
                                class="text-grey-darkest text-lg text-center font-thin border h-12 w-4/5 sm:w-1/3 shadow hover:shadow-md px-4 py-2"
                                type="text"
                                name="q"
                                placeholder="Look up chemical"
                                autofocus
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex justify-center mb-4">
            <div class="w-screen flex justify-center">
                <substructure-search csrf-token="{{ @csrf_token() }}" @substructure-editor="toggleTextSearch" />
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script type="text/javascript">

    function molchange(jsdraw) {
        document.getElementById("molfile").value = JSDraw.get("mobile-editor").getMolfile();
    }

</script>
@endsection