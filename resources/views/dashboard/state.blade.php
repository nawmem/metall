@extends('dashboard.home')

@section('content')
    <div class="mb-4 p-4 border-2 border-dashed rounded-md border-neutral-300">
        <label >Выбирите за какой период показать статистику </label>
        @if(Route::currentRouteName() == 'createStatMetall')
        <form class="mt-2" action="{{ route('createStatMetall') }}" method="get">
        @elseif(Route::currentRouteName() == 'createStatMetallCategories')
                <form class="mt-2" action="{{ route('createStatMetallCategories') }}" method="get">
        @endif
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
        @isset($is_all)
        <div>
            @if($is_metall['accept'] == true)
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-x-auto">
                                <table border="1" class="min-w-full">
                                    <caption>Статистика <b>приема</b> металла за выбранный период</caption>
                                    <tr >
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Название</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Масса</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Цена за кг.</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Засор %</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Дата</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Общая цена</td>
                                    </tr>
                                    @foreach($metalls_accept as $metall_accept)
                                        <tr class="border-b">
                                            <td scope="col" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $metall_accept->metallCategories->name }}</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_accept->massa }} кг.</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_accept->price_one }} руб.</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_accept->blockage }} %</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_accept->created_at->format('j.m.Y - H:i') }}</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_accept->price_all }} руб.</td>
                                        </tr>
                                    @endforeach
                                    <tr >
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Итого</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ $total_accept['price_all'] }} руб.</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($is_metall['ship'] == true)
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-x-auto">
                                <table border="1" class="min-w-full">
                                    <caption>Статистика <b>отгрузки</b> металла за выбранный период</caption>
                                    <tr >
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Название</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Масса</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Цена за кг.</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Засор %</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Дата</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Общая цена</td>
                                    </tr>
                                    @foreach($metalls_ship as $metall_ship)
                                        <tr class="border-b">
                                            <td scope="col" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $metall_ship->metallCategories->name }}</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_ship->massa }} кг.</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_ship->price_one }} руб.</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_ship->blockage }} %</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_ship->created_at->format('j.m.Y - H:i')  }}</td>
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_ship->price_all }} руб.</td>
                                        </tr>
                                    @endforeach
                                    <tr >
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Итого</td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ $total_ship['price_all'] }} руб.</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endisset
        @isset($is_categories)
{{--                перебрасываем с одной категории на другую--}}
                <div class="w-full">
                    <div class="mb-4 p-2 border-2 border-dashed rounded-md border-neutral-300">
                        <p >Перeбросить металл между категориями</p>
                        <form class=" flex" action="{{ route('storeRecycleMetall') }}" method="post">
                            @csrf
                            <div class="w-full flex flex-wrap -mx-3 mt-3 mb-4">
                                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                           for="recycle_from_categorie">
                                        С категории :
                                    </label>
                                    <div class="relative">
                                        <select onclick="get_data_inputs_accept()"
                                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                id="recycle_from_categorie"
                                                name="recycle_from_categorie">
                                            <option value="" >Выбирите категорию</option>
                                            @foreach($all_categories as $categories_from)
                                                <option value="{{ $categories_from->id }}">{{ $categories_from->name }} : {{ $categories_from->price }} руб.</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                           for="recycle_in_categorie">
                                        На категорию :
                                    </label>
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                id="recycle_in_categorie"
                                                name="recycle_in_categorie">
                                            <option value="" >Выбирите категорию</option>
                                            @foreach($all_categories as $categories_in)
                                                <option value="{{ $categories_in->id }}">{{ $categories_in->name }} : {{ $categories_in->price }} руб.</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="w-1/3 md:w-1/4 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="recycle_mass">Вес передвигаемого металла</label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                           id="recycle_mass"
                                           name="recycle_mass"
                                           type="text"
                                           placeholder="">
                                </div>
                                <div class="w-1/3 md:w-1/4 flex items-center justify-between">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-4 ml-4 rounded focus:outline-none focus:shadow-outline"
                                            id="recycle_btn"
                                            type="submit">
                                        применить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                {{--  статистика по категориям  --}}
{{--            конец перероски категорий--}}
                <div>
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-x-auto">
                                    <table border="1" class="min-w-full">
                                        <caption>Статистика <b>приема</b> металла за выбранный период</caption>
                                        <tr >
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Название</td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Масса</td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Засор средний %</td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Общая цена</td>
                                        </tr>
                                        @foreach($result_accept as $metall_accept)
                                            <tr class="border-b">
                                                <td scope="col" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $metall_accept['name'] }}</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_accept['massa'] }} кг.</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_accept['blockage'] }} %</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_accept['price_all'] }} руб.</td>
                                            </tr>
                                        @endforeach
                                        <tr >
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Итого</td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ $total_accept_p }} руб.</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-x-auto">
                                    <table border="1" class="min-w-full">
                                        <caption>Статистика <b>отгрузки</b> металла за выбранный период</caption>
                                        <tr >
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Название</td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Масса</td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Засор средний %</td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Общая цена</td>
                                        </tr>
                                        @foreach($result_ship as $metall_ship)
                                            <tr class="border-b">
                                                <td scope="col" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $metall_ship['name'] }}</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_ship['massa'] }} кг.</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_ship['blockage'] }} %</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $metall_ship['price_all'] }} руб.</td>
                                            </tr>
                                        @endforeach
                                        <tr >
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Итого</td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
                                            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">{{ $total_ship_p }} руб.</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endisset
    </div>
@endsection
