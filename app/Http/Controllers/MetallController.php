<?php

namespace App\Http\Controllers;

use App\Models\Metall;
use App\Models\MetallCategories;
use App\Models\MetallType;
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
        $event = 'accept';
        $price_one = $categorie->price;
        $mass = $request->mass;
        $blockage = $request->blockage;
        $metall_type = $categorie->metalltypes->id;
        $categorie_id = $categorie->id;
        if ($blockage == (null || 0)){
            $blockage = 0;
            $price_all = (int)floor($mass * $price_one);
        }else{
            $price_all = (int)floor(($mass - ($mass*($blockage/100)))*$price_one);
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
        $by_date = '';
        $before_date = '';
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
//        dd($request->all());
        $result_accept = [];
        $result_ship = [];

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
        return view('dashboard.state', compact('is_categories', 'result_accept', 'result_ship', 'total_accept_p', 'total_ship_p'));
    }
}
