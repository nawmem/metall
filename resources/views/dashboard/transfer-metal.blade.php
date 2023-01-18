@extends('dashboard.home')

@section('content')
    <div class="mb-4 p-4 border-2 border-dashed rounded-md border-neutral-300">
        <label >Выбирите за какой период показать статистику </label>
        <form class="mt-2" action="{{ route('createStatTransfer') }}" method="get">
            @csrf
            <div class="flex">
                <div>
                    <label for="by_date"> от : </label>
                    <input class="boorder-solid border-2 border-indigo-600 rounded-md p-1" type="date" id="by_date" name="by_date"/>
                </div>
                <div class="ml-4">
                    <label for="before_date"> до : </label>
                    <input class="boorder-solid border-2 border-indigo-600 rounded-md p-1" type="date" id="before_date" name="before_date"/>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-4 ml-4 rounded focus:outline-none focus:shadow-outline"
                            id="state_btn"
                            type="submit">
                        применить
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="mb-4 p-4 border-2 border-dashed rounded-md border-neutral-300">
        <div>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-x-auto">
                            <table border="1" class="">
                                <caption>Статистика <b>переброски</b> металла за выбранный период</caption>
                                <tr >
                                    <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">От куда</td>
                                    <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Куда</td>
                                    <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Масса кг.</td>
                                    <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Когда</td>
                                </tr>
                                @foreach($transfers as $item_transfer)
                                    <tr class="border-b">
                                        <td scope="col" class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $item_transfer->fromCatrgorieId->name }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $item_transfer->inCatrgorieId->name }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $item_transfer->massa }} кг.</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $item_transfer->created_at->format('j.m.Y - H:i') }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
