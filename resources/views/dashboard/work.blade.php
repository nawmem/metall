@extends('dashboard.home')

@section('content')
        {{--Ошибки--}}
        @if ($errors->any())
        <div class="mb-4 p-4 border-0 rounded-md border-color-black bg-indigo-900 text-center py-4 lg:px-4">
            <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                <div class="rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">Внимание</div>
                <div class="font-semibold mr-2 text-left ">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        {{-- Добавляем категорию --}}
        <div class="mb-4 p-4 border-2 border-dashed rounded-md border-neutral-300">
            @include('dashboard.add-categorie')
        </div>
        {{-- Принимаем металл --}}
        <div class="mb-4 p-4 border-2 border-dashed rounded-md border-neutral-300">
            @include('dashboard.accept-metall')
        </div>
        {{-- Отгружаем металл --}}
        <div class="mb-4 p-4 border-2 border-dashed rounded-md border-neutral-300">
            @include('dashboard.ship-metall')
        </div>
@endsection
