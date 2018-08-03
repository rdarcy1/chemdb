@extends('layouts.master')

@section('head')
    <style>
        #search:focus {
            outline: none;
        }

        html, body {
            margin-bottom: 100px;
        }
    </style>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/dojo/1.11.2/dojo/dojo.js"></script>
    <script type="text/javascript" src='{{ asset('/js/JSDraw/Scilligence.JSDraw2.Pro.js') }}'></script>

@endsection

@section('content')

    <div class="pt-6">
        <div class="flex justify-center mb-6">
            <div class="w-screen flex justify-center">
                <div class="flex flex-col justify-center items-center">
                    <a href="/">
                        <img class="block mb-4"  src="{{ asset('img/logo.jpg') }}" alt="ChemDB">
                    </a>
                    <form action="/search" method="GET" autocomplete="off">
                        <div class="flex justify-center w-screen">
                            <input
                                    v-if="textSearch"
                                    id="search"
                                    class="text-grey-darkest text-lg text-center font-thin border h-12 w-4/5 sm:w-1/3 shadow hover:shadow-md px-4 py-2"
                                    type="text"
                                    name="q"
                                    value="{{ request('q') }}"
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


    @if($searchType == 'text')
        <h2 class="text-center">Search results ({{ $matches->count() }})</h2>
    @endif

    @if($searchType == 'substructure')
        <h2 class="text-center">Substructure search ({{ $matches->count() }} results)</h2>
    @endif

    <div class="mt-6 flex flex-wrap justify-center px-4">

        @forelse($matches as $match)
           <div class="justify-around w-1/6 mr-6">
                <a href="/chemicals/{{ $match->chemical->id }}" class="flex flex-col items-center justify-center mb-4 bg-white no-underline hover:underline overflow-hidden">
                    <div class="mb-3 hover:shadow-md hover:border-blue rounded-lg shadow border border-dashed border-grey-darkest">
                        <img src="{{ asset('molfiles/svg/'. $match->chemical->id .'.svg') }}">
                    </div>
                    <span class="text-center text-blue">{{ $match->chemical->name }}</span>
                </a>
           </div>

        @empty
            no results
        @endforelse

    </div>


@endsection

@section('scripts')
    <script type="text/javascript">

        function molchange(jsdraw) {
            document.getElementById("molfile").value = JSDraw.get("mobile-editor").getMolfile();
        }

    </script>
@endsection





