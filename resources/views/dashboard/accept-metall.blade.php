<h3>Принимаем металл</h3>
<form class="w-full "
      action="{{route('acceptMetall')}}"
      method="post">
    @csrf
    <div class="w-full flex flex-wrap -mx-3 mt-5 mb-6">
        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                   for="name_categorie">
                Категория
            </label>
            <div class="relative">
                <select onclick="get_data_inputs_accept()"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="name_categorie"
                        name="name_categorie">
                    <option value="" >Выбирите категорию</option>
                    @foreach($metall_categories as $categories)
                        <option value="{{ $categories->id }}"
                                price="{{ $categories->price }}">{{ $categories->name }} : {{ $categories->metallTypes->name }} : {{ $categories->price }} руб.</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="w-1/3 md:w-1/5 px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="mass">
                Вес
            </label>
            <input oninput="get_data_inputs_accept()"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   id="mass"
                   name="mass"
                   type="text"
                   placeholder="">
            <p class="text-gray-600 text-xs italic">Общий вес принятого металла</p>
        </div>
        <div class="w-1/3 md:w-1/5 px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="blockage">
                Засор
            </label>
            <input oninput="get_data_inputs_accept()"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   id="blockage"
                   name="blockage"
                   type="text" placeholder="">
            <p class="text-gray-600 text-xs italic">Засор</p>
        </div>
    </div>
    <div class="w-full flex flex-wrap -mx-3 mt-5 mb-6">

    </div>
    <div class="w-full flex flex-wrap -mx-3 mt-5 mb-6">
        <div class="w-full md:w-1/3 px-3">
            <input class="appearance-none block w-full bg-green-50 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   id="price_all"
                   name="price_all"
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
                id="accept_btn"
                type="submit">
            Принять
        </button>
    </div>

</form>
