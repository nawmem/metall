@extends('dashboard.home')

@section('content')
    <div class="mb-4 p-4 border-2 border-dashed rounded-md border-neutral-300">
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
                <form class="mt-6" action="{{ route('storeRecalculateRemains') }}">
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
