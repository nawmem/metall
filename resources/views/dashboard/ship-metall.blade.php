<h3>Отгружаем металл</h3>
<form class="w-full "
      action="{{route('shipMetall')}}"
      method="post">
    @csrf
    <div class="w-full flex flex-wrap -mx-3 mt-5 mb-6">
        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                   for="name_categorie_ship">
                Категория
            </label>
            <div class="relative">
                <select onclick="get_data_inputs_ship()"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="name_categorie_ship"
                        name="name_categorie_ship">
                    <option value="" >Выбирите категорию</option>
                    @foreach($metall_categories as $categories)
                        <option value="{{ $categories->id }}" >{{ $categories->name }} : {{ $categories->metallTypes->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4"
                         xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </div>
        <div class="w-1/3 md:w-1/5 px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                   for="price_one_ship">
                Цена за кг.
            </label>
            <input oninput="get_data_inputs_ship()"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   id="price_one_ship"
                   name="price_one_ship"
                   type="text"
                   placeholder="">
            <p class="text-gray-600 text-xs italic">Цена за кг.</p>
        </div>
        <div class="w-1/3 md:w-1/5 px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                   for="mass_ship">
                Вес
            </label>
            <input oninput="get_data_inputs_ship()"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   id="mass_ship"
                   name="mass_ship"
                   type="text"
                   placeholder="">
            <p class="text-gray-600 text-xs italic">Общий вес принятого металла</p>
        </div>
        <div class="w-1/3 md:w-1/5 px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="blockage_ship">
                Засор
            </label>
            <input oninput="get_data_inputs_ship()"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   id="blockage_ship"
                   name="blockage_ship"
                   type="text" placeholder="">
            <p class="text-gray-600 text-xs italic">Засор</p>
        </div>
    </div>
    <div class="w-full flex flex-wrap -mx-3 mt-5 mb-6">

    </div>
    <div class="w-full flex flex-wrap -mx-3 mt-5 mb-6">
        <div class="w-full md:w-1/3 px-3">
            <input class="appearance-none block w-full bg-red-50 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   id="price_all_ship"
                   name="price_all_ship"
                   type="number"
                   placeholder="">

            <p class="text-gray-600 text-xs italic">Итоговая сумма</p>
        </div>
        <div class="w-full md:w-1/3 px-3">
            <input class="w-5 h-5 " type="checkbox" name="is_save">

            <p class="text-gray-600 text-xs italic">Сохранить эту сумму</p>
        </div>


    </div>
    <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                id="ship_btn"
                type="submit">
            Отгрузить
        </button>
    </div>

</form>
