@extends('dashboard.home')

@section('content')
    <div class="mb-4 p-4 border-2 border-dashed rounded-md border-neutral-300">
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
        <div class="ml-5">
            <p>Остатки с учетом переброски</p>
            <div class="flex">
                <table border="1" class="mt-6">
                    <caption></caption>
                    <tr >
                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">id</td>
                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Категория</td>
                        <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Масса кг.</td>
                    </tr>
                    @foreach($remains as $item_categorie)
                        <tr class="border-b">
                            <td scope="col" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item_categorie->metallCategories->id }}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $item_categorie->metallCategories->name }}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $item_categorie->remains }} кг.</td>
                        </tr>
                    @endforeach
                </table>
                <form class="mt-6" action="{{ route('storeRecalculateRemains') }}" method="post">
                    @csrf
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-4 ml-4 rounded focus:outline-none focus:shadow-outline"
                            id="recycle_calceulate_btn"
                            name="is_reset"
                            value="3"
                            type="submit">
                        Сбросить
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection
