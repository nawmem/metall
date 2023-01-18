@extends('dashboard.home')

@section('content')

<div>
    <table border="1" class="min-w-full">
        <caption>Все категории</caption>
        <tr >
            <td scope="col" class="w-4 text-sm font-medium text-gray-900 px-6 py-4 text-left">ID</td>
            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Название</td>
            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Цена за кг.</td>
            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Действия</td>
        </tr>
        @foreach($all_categories as $categorie)
            <form action="{{ route('storeUpdateCategories') }}" method="post">
                @csrf
                <tr class="border-b">
                    <td scope="col" class="w-4 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <input
                            class="w-4"
                            type="text"
                            readonly=""
                            name="id_categorie"
                            value="{{ $categorie->id }}"
                            placeholder="{{ $categorie->id }}">
                    </td>
                    <td scope="col" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $categorie->name }}</td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                        <input
                            class="w-32 border-2 rounded-md p-1"
                            type="text"
                            value="{{ $categorie->price }}"
                            name="price_categorie"
                            placeholder="{{ $categorie->price }}">
                    </td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $categorie->metallTypes->name }}</td>
                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                        <button name="delete" value="1">Удалить</button> /
                        <button name="update" value="2">Изменить</button>
                    </td>
                </tr>
            </form>
        @endforeach
        <tr >
            <td scope="col" class="w-4 text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
            <td scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></td>
        </tr>
    </table>
</div>

@endsection()
