
<div class="flex">
    <form class="lg:w-2/3" action="{{route('addCategorie')}}" method="post">
        <h3>Добавляем категорию металла</h3>
        @csrf
        <div class="flex flex-wrap -mx-3 mt-5 mb-6">
            <div class="w-full md:w-2/6 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="type_metall">
                    Вид металла
                </label>
                <div class="relative">
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="type_metall" name="type_metall">
                        @foreach($type_metall as $type)
                            <option value="{{$type->id}}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-2/6 px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="categorie_name">
                    Название категории
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="categorie_name" type="text" name="categorie_name" placeholder="Категория">
            </div>
            <div class="w-full md:w-2/6 px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="price_categorie">
                    Цена
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="price_categorie" type="text" name="price_categorie" placeholder="Цена">
            </div>
        </div>
        <div class="flex items-center justify-start">
            <button class="h-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Добавить
            </button>
            <div class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                <a href="{{ route('createGetAllCategories') }}">Посмотреть все категрии</a>
            </div>
        </div>
    </form>
</div>


