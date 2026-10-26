@extends('layouts.app')

@section('title', 'Search')

@section('header', 'Search')

@section('content')
<div class="my-4 bg-white rounded-sm shadow-sm p-4 dark:bg-gray-800">
    <h3 class="font-bold text-xl">Search form</h3>
    <form action="/search" class="w-full mt-2 h-10 pl-3 pr-2 bg-white border rounded-sm flex justify-between items-center relative dark:bg-gray-900 dark:border-gray-900" method="GET">
        <label for="search" class="sr-only">Search input</label>
        <input type="search"
               name="query"
               id="search"
               placeholder="Type your text here"
               minlength="3"
               maxlength="250"
               class="appearance-none w-full outline-hidden focus:outline active:outline-hidden dark:bg-gray-900"
               value="{{ $query }}"
        />
        <button type="submit" class="ml-1 outline-hidden focus:outline-hidden active:outline-hidden">
            <span class="sr-only">Search button</span>
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                 viewBox="0 0 24 24" class="w-6 h-6">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
    </form>
</div>

@if (null !== $results && count($results) > 0)
<div class="flex justify-between sticky top-0 bg-gray-100 dark:bg-gray-700 pt-2 pb-1 z-10">
    <h3 class="font-bold text-2xl">Search results</h3>
    <div>
        <button id="enable-copy-as-batch" class="py-1 px-2 bg-gray-800 hover:bg-gray-700 text-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800">Enable batch mode</button>
        <button id="disable-copy-as-batch" class="hidden py-1 px-2 border border-gray-800 hover:bg-gray-700 text-gray-700 hover:text-gray-100 dark:text-gray-300 dark:hover:text-gray-200">Disable batch mode</button>
        <button id="clear-selected-batch" class="hidden py-1 px-2 border border-gray-800 hover:bg-gray-700 text-gray-700 hover:text-gray-100 dark:text-gray-300 dark:hover:text-gray-200 mr-2">Clear selected</button>
        <button id="copy-as-batch" class="hidden py-1 px-2 bg-gray-800 hover:bg-gray-700 text-gray-700 hover:text-gray-100 dark:text-gray-300 dark:hover:text-gray-200">Copy selected</button>
    </div>
</div>
<div class="my-4 bg-white p-0 dark:bg-gray-800">
    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative shadow-sm dark:bg-gray-800">
        <thead>
        <tr class="text-left">
            <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 rounded-tl dark:bg-gray-900">Bot</th>
            <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 dark:bg-gray-900">Pack</th>
            <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 dark:bg-gray-900">Size</th>
            <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 dark:bg-gray-900">Filename</th>
            <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 rounded-tr dark:bg-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($results as $pack)
            <tr class="text-left hover:bg-gray-100 dark:hover:bg-gray-700">
                <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">
                    <a href="/bots/{{ $pack->getBot()->getName() }}">{{ $pack->getBot() }}</a>
                </td>
                <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">{{ $pack->getNumber() }}</td>
                <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">{{ $pack->getSizeReadable() }}</td>
                <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">{{ $pack->getName() }}</td>
                <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">
                    <button class="copy-data py-1 px-2 bg-gray-300 hover:bg-gray-200 dark:bg-gray-900 dark:hover:bg-gray-800" data-botpack="{{ $pack->getNumber() }}" data-botname="{{ $pack->getBot() }}">Copy</button>
                    @if ($pack->getBot()->isBatchEnabled())
                        <label class="batch-copy-checkbox hidden items-center space-x-2">
                            <input type="checkbox"
                                   name="batch"
                                   value="1"
                                   data-botpack="{{ $pack->getNumber() }}"
                                   data-botname="{{ $pack->getBot() }}"
                                   class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-hidden dark:border-gray-600 dark:bg-gray-600">
                            <span class="text-gray-900 font-medium dark:text-gray-100">Batch</span>
                        </label>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@else
    <div class="my-4 bg-white rounded-sm shadow-sm p-4 text-center dark:bg-gray-800">
        <h3 class="text-2xl">No results</h3>
    </div>
@endif
@endsection
