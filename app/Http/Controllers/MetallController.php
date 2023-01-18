<?php

namespace App\Http\Controllers;

use App\Models\Metall;
use App\Models\MetallCategories;
use App\Models\MetallType;
use App\Models\Remain;
use App\Models\TransferMetall;
use Illuminate\Http\Request;
use function Symfony\Component\Mime\Header\all;

class MetallController extends Controller
{
    public function home (){

        $type_metall = MetallType::all();
        $metall_categories = MetallCategories::all();
        return view('dashboard.work', compact('type_metall', 'metall_categories'));
    }

    public function addCategorie(Request $request){
        $request->validate([
            'categorie_name' => 'required|unique:App\Models\MetallType,name',
            'price_categorie' => 'required',
        ]);
        MetallCategories::create([
            'name' => $request->categorie_name,
            'price' => $request->price_categorie,
            'metall_types_id' => $request->type_metall,
        ]);

        return redirect()->back();
    }

    // принимаем металл
    public function acceptMetal(Request $request){
        $result_price = 0;
        $categorie = MetallCategories::where('id', $request->name_categorie)->first();
        $event = 'accept'; // название события
        $price_one = $categorie->price; // цена за кг
        $mass = $request->mass;// масса
        $blockage = $request->blockage; // засор
        $metall_type = $categorie->metalltypes->id; // ИД типа металла
        $categorie_id = $categorie->id; // ИД категории
        // смотрим если нет засора
        if ($blockage == (null || 0)){
            $blockage = 0;
            // то считаем без него
            $price_all = (int)floor($mass * $price_one);
        }else{
            // считаем с засором
            $price_all = (int)floor(($mass - ($mass*($blockage/100)))*$price_one);
        }

        // берем таблицу остатки и прибавляем принятый металл к остаткам
        $remains = Remain::where('metall_categories_id', $categorie_id)->first();
        if ($remains == null){
            Remain::create([
                'matall_types_id' => $metall_type,
                'metall_categories_id' => $categorie_id,
                'remains' => 0
            ]);
        }else{
//            dd($metall_type);
            $result_remains = $remains->remains + $mass;
            $remains->update([
                'metall_types_id' => $metall_type,
                'metall_categories_id' => $categorie_id,
                'remains' => $result_remains
            ]);
        }

        // сохраняем в бд
        Metall::create([
            "event" =>$event,
            "price_one" => $price_one,
            "massa" => $mass,
            "price_all" => $price_all,
            "blockage" => $blockage,
            "metall_types_id" => $metall_type,
            "metall_categories_id" => $categorie_id
        ]);

        return redirect()->back();
    }

    // отгружаем металл
    public function shipMetall(Request $request){
        $result_price = 0;
        $categorie = MetallCategories::where('id', $request->name_categorie_ship)->first();
        $event = 'ship';
        $price_one = $request->price_one_ship;
        $mass = $request->mass_ship;
        $blockage = $request->blockage_ship;
        $metall_type = $categorie->metalltypes->id;
        $categorie_id = $categorie->id;
        if($request->is_save == 'on'){
            $price_all = $request->price_all_ship;
        }else{
            if ($blockage == (null || 0)){
                $blockage = 0;
                $price_all = (int)floor($mass * $price_one);
            }else{
                $price_all = (int)floor(($mass - ($mass*($blockage/100)))*$price_one);
            }
        }

        // берем таблицу остатки и вычитаем из остатков откгруженый металл
        $remains = Remain::where('metall_categories_id', $categorie_id)->first();
        if ($remains == null){
            Remain::create([
                'matall_types_id' => $metall_type,
                'metall_categories_id' => $categorie_id,
                'remains' => 0
            ]);
        }else{
            $result_remains = $remains->remains - $mass;
            $remains->update([
                'metall_types_id' => $metall_type,
                'metall_categories_id' => $categorie_id,
                'remains' => $result_remains
            ]);
        }

        Metall::create([
            "event" =>$event,
            "price_one" => $price_one,
            "massa" => $mass,
            "price_all" => $price_all,
            "blockage" => $blockage,
            "metall_types_id" => $metall_type,
            "metall_categories_id" => $categorie_id
        ]);
        return redirect()->back();
    }



    public function createStatMetall(Request $request){
        $is_all = true;
        $metall_all = Metall::all();
        $metalls_accept = $metall_all->where('event', 'accept')->sortDesc(0)->take(100);
        $metalls_ship = $metall_all->where('event', 'ship')->sortDesc(0)->take(100);
        $is_metall = [
            'accept' => true,
            'ship' => true
        ];

        // для расчета итого
        // прием металла
        $total_accept = [
            'mass' => 0,
            'price_all' => 0,
            'blockage' => 0,
        ];
        // откгрузка металла
        $total_ship = [
            'mass' => 0,
            'price_all' => 0,
            'blockage' => 0,
        ];
        // считаем итого на приеме металла
        foreach ($metalls_accept as $metall_accept){
            $total_accept['price_all'] += $metall_accept->price_all; // суммируем цену общую
        }
        //считаем итого на отгрузке мателла
        foreach ($metalls_ship as $metall_ship){
            $total_ship['price_all'] += $metall_ship->price_all; // суммируем цену общую
        }
        // проверяем пришла ли дата
        if ($request->by_date != null ){
            // Проверяем есть ли конечная дата, если нет то подставляем сегодняшнюю
            if($request->before_date == null){
                // устанавливаем сегоднюшнюю дату в обьект $request->before_data
                $request->merge(['before_date' => date("Y-m-d")]);
            }
            // проверяем начальная дата больше конечной или нет
            if($request->by_date > $request->before_date){
                $by_date = $request->before_date.' 00:00:00';
                $before_date = $request->by_date.' 23:59:00';
            }else{
                $before_date = $request->before_date.' 23:59:00';
                $by_date = $request->by_date.' 00:00:00';
            }
            $metall_all = Metall::where('created_at', '>=', $by_date)
                ->where('created_at', '<=', $before_date)
                ->get();
            $metalls_accept = $metall_all->where('event', 'accept');
            $metalls_ship = $metall_all->where('event', 'ship');
            $is_metall['accept'] = $metalls_accept->first() != null;
            $is_metall['ship'] = $metalls_ship->first() != null;
        }
        return view('dashboard.state', compact(
            'metalls_accept',
            'metalls_ship',
            'is_metall',
            'total_accept',
            'total_ship',
            'is_all'
        ));
    }

    public function createStatMetallCategories(Request $request){
        $result_accept = [];
        $result_ship = [];
        $by_date = '';
        $before_date = '';
        // получаем все данные по таблице категории
        $all_categories = MetallCategories::all();
        // итоговые суммы по всем метелам
        $total_accept_p = 0;
        $total_ship_p = 0;
        // уникальные ИД категорий в приме металла
        $unique_ids_categories_for_accept = [];
        $unique_ids_categories_for_ship = [];
        // это говорим шаблону Блейд, что у нас просмотр по категориям
        $is_categories = true;
        if ($request->by_date != null ){
            // Проверяем есть ли конечная дата, если нет то подставляем сегодняшнюю
            if($request->before_date == null){
                // устанавливаем сегоднюшнюю дату в обьект $request->before_data
                $request->merge(['before_date' => date("Y-m-d")]);
            }
            // проверяем начальная дата больше конечной или нет
            if($request->by_date > $request->before_date){
                $by_date = $request->before_date.' 00:00:00';
                $before_date = $request->by_date.' 23:59:00';
            }else{
                $before_date = $request->before_date.' 23:59:00';
                $by_date = $request->by_date.' 00:00:00';
            }
            $metall_all = Metall::where('created_at', '>=', $by_date)
                ->where('created_at', '<=', $before_date)
                ->get();

        }else{
            $metall_all = Metall::all()->sortDesc(0)->take(100);
        }
        // берем прием металла
        $accept_mt = $metall_all->where('event', 'accept');

        // выбираем ИД всех категорий и записываем в массив $unique_ids_categories_for_accept
        foreach ($accept_mt as $accept){
            array_push($unique_ids_categories_for_accept, $accept->metallCategories->id);
        }
        // оставляем только уникальные ИД
        $unique_ids_categories_for_accept = array_unique($unique_ids_categories_for_accept);
        foreach ($unique_ids_categories_for_accept as $id){
            $count_accept_metall = [
                'name' => '',
                'massa' => 0,
                'price_all' => 0,
                'blockage' => 0,
                'price_all' => 0,
            ];
            $count_ba_accept = 0;
            // выбираем прием товаров по ИД категории
            $metall_count = $accept_mt->where('metall_categories_id', $id);
            foreach ($metall_count as $item_count){
                $count_accept_metall['name'] = $item_count->metallCategories->name;
                $count_accept_metall['massa'] += $item_count->massa;
                $count_accept_metall['price_all'] += $item_count->price_all;
                if ($item_count->blockage > 0){
                    $count_ba_accept ++;
                    $count_accept_metall['blockage'] += $item_count->blockage;
                }
            }
            if ($count_accept_metall['blockage'] > 0){
                $count_accept_metall['blockage'] = $count_accept_metall['blockage']/$count_ba_accept;
            }
            array_push($result_accept, $count_accept_metall);
        }

        // сичтаем отгрузку

        // берем откгрузку метала
        $ship_mt = $metall_all->where('event', 'ship');
        foreach ($ship_mt as $ship){
            array_push($unique_ids_categories_for_ship, $ship->metallCategories->id);
        }
        // оставляем только уникальные ИД
        $unique_ids_categories_for_ship = array_unique($unique_ids_categories_for_ship);
        foreach ($unique_ids_categories_for_ship as $id){
            $count_ship_metall = [
                'name' => '',
                'massa' => 0,
                'price_all' => 0,
                'blockage' => 0,
                'price_all' => 0,
            ];
            $count_ba_ship = 0;
            // выбираем отгрузку товаров по ИД категории
            $metall_count_s = $ship_mt->where('metall_categories_id', $id);
            foreach ($metall_count_s as $item_count){
                $count_ship_metall['name'] = $item_count->metallCategories->name;
                $count_ship_metall['massa'] += $item_count->massa;
                $count_ship_metall['price_all'] += $item_count->price_all;
                if ($item_count->blockage > 0){
                    $count_ba_ship ++;
                    $count_ship_metall['blockage'] += $item_count->blockage;
                }
            }
            if ($count_ship_metall['blockage'] > 0){
                $count_ship_metall['blockage'] = $count_ship_metall['blockage']/$count_ba_ship;
            }
            array_push($result_ship, $count_ship_metall);
        }
        // считаем итого на приеме металла
        foreach ($result_accept as $total_accept){
            $total_accept_p += $total_accept['price_all']; // суммируем цену общую
        }
        //считаем итого на отгрузке мателла
        foreach ($result_ship as $total_ship){
            $total_ship_p += $total_ship['price_all']; // суммируем цену общую
        }
        return view('dashboard.state', compact('is_categories', 'result_accept', 'result_ship', 'total_accept_p', 'total_ship_p', 'all_categories'));
    }

    // показываем категории металла
    public function createGetAllCategories(Request $request){
        $all_categories = MetallCategories::all();
//        dd($all_categories);
        return view('dashboard.all-categories', compact('all_categories'));
    }

    public function storeUpdateCategories(Request $request){
        $categorie = MetallCategories::where('id', (int)$request->id_categorie)->first();
        if ($request->delete == 1){
            $categorie->delete();
        }elseif($request->update == 2){
            $categorie->update(['price' => (float)$request->price_categorie]);
        }
        return redirect()->back();
    }


    // перебрасываем металл
    public function storeRecycleMetall(Request $request){
        $remains_from = Remain::where('metall_categories_id', $request->recycle_from_categorie)->first(); // данные по остаткам категории с какой нужно перекинуть
        $remains_in = Remain::where('metall_categories_id', $request->recycle_in_categorie)->first(); // данные по остаткам категории на какую нужно перекинуть
        $recycle_mass = $request->recycle_mass; // масса какую нужно перекинуть
        $remains_from_mass = (float)$remains_from->remains - (float)$recycle_mass; // уже вычли из общей массы категории откуда переносили
        $remains_in_mass = $remains_in->remains + (float)$recycle_mass; // прибавили в категорию куда переносим металл

        $remains_from->update([
            'remains' => $remains_from_mass
        ]);

        $remains_in->update([
            'remains' => $remains_in_mass
        ]);

        TransferMetall::create([
            'from_categories_id' => $remains_from->id,
            'in_categories_id' => $remains_in->id,
            'massa' => $recycle_mass
        ]);

        return redirect()->back();
    }

    // показываем остатки и пересчитываем металл по нажатию на кнопку
    public function storeRecalculateRemains(Request $request){
        $remains = Remain::all();
        if ($request->is_reset == 3){
            $categories = MetallCategories::all();
            $remains_array = [];
            foreach ($categories as $category){
                array_push($remains_array, [
                    'categorie_id' =>$category->id,
                    'type_id' => $category->metallTypes->id,
                    'remains' => 0
                ]);
            }
            for ($i=0;$i<count($remains_array);$i++){
                $item_r = $remains_array[$i];
                $metalls = Metall::where('metall_categories_id', $item_r['categorie_id'])->get();
                foreach ($metalls as $item_metall){
                    if ($item_metall->event == 'accept'){
                        $remains_array[$i]['remains'] += $item_metall->massa;
                    }elseif($item_metall->event == 'ship'){
                        $remains_array[$i]['remains'] -= $item_metall->massa;
                    }
                }
//                dd($remains_array[$i]['remains']);
                $remaint_item = Remain::where('metall_categories_id', $item_r['categorie_id'])->first();
                if ($remaint_item == null){
                    Remain::create([
                        'metall_types_id' => $remains_array[$i]['type_id'],
                        'metall_categories_id' => $remains_array[$i]['categorie_id'],
                        'remains' => 0
                    ]);
                }else{
                    $remaint_item->update([
                        'remains' => $remains_array[$i]['remains'],
                    ]);
                }
            }
        }
        return view('dashboard.recycle-metal', compact('remains'));
    }
    // статистика по оперциям переброски металла
    public function createStatTransfer(Request $request){
//        $transfers = TransferMetall::all();
        if ($request->by_date != null ){
            // Проверяем есть ли конечная дата, если нет то подставляем сегодняшнюю
            if($request->before_date == null){
                // устанавливаем сегоднюшнюю дату в обьект $request->before_data
                $request->merge(['before_date' => date("Y-m-d")]);
            }
            // проверяем начальная дата больше конечной или нет
            if($request->by_date > $request->before_date){
                $by_date = $request->before_date.' 00:00:00';
                $before_date = $request->by_date.' 23:59:00';
            }else{
                $before_date = $request->before_date.' 23:59:00';
                $by_date = $request->by_date.' 00:00:00';
            }
            $transfers = TransferMetall::where('created_at', '>=', $by_date)
                ->where('created_at', '<=', $before_date)
                ->get();

        }else{
            $transfers = TransferMetall::all()->sortDesc(0)->take(100);
        }
//        $transfers->first()->fromCatrgorieId->;
        return view('dashboard.transfer-metal', compact('transfers'));
    }
}
