<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="mb-4">
    @include('menu')
    <div class="flex">
        <div class="md:w-1/6 w-6 "></div>
        <div class="w-full">
            @yield('content')
        </div>
        <div class="md:w-1/6 w-6 "></div>
    </div>
    <script>
        // accept
        let name_categorie = document.getElementById('name_categorie');
        let price_one = name_categorie.options[name_categorie.selectedIndex].getAttribute('price') / 1; //цена за кг
        let price_all = document.getElementById("price_all");
        let mass = document.getElementById('mass').value / 1;
        let blockage = document.getElementById('blockage').value / 100;
        let accept_btn = document.getElementById('accept_btn');
        let result_price;
        let count_del_categorie_accept = 0;

        if (name_categorie.selectedIndex == 0) {
            accept_btn.setAttribute("disabled", true);
        }

        function get_data_inputs_accept() {
            if (count_del_categorie_accept == 0) {
                console.log(count_del_categorie_accept);
                name_categorie.options[0].remove();
                count_del_categorie_accept = 1;
            }
            accept_btn.removeAttribute("disabled");
            name_categorie = document.getElementById('name_categorie');
            price_one = name_categorie.options[name_categorie.selectedIndex].getAttribute('price') / 1; //цена за кг
            mass = document.getElementById('mass').value / 1;
            blockage = document.getElementById('blockage').value / 100;
            if (blockage == 0) {
                price_all.value = '';
                price_all.value = Math.floor((mass) * price_one);
            } else {
                price_all.value = '';
                price_all.value = Math.floor((mass - (mass * blockage)) * price_one);
            }
        }

        // ship
        let name_categorie_ship = document.getElementById('name_categorie_ship');
        let price_one_ship;
        let price_all_ship = document.getElementById('price_all_ship');
        let mass_ship;
        let blockage_ship;
        let result_price_ship;
        let ship_btn = document.getElementById('ship_btn');
        let count_del_categorie_ship = 0;

        if (name_categorie_ship.selectedIndex == 0) {
            ship_btn.setAttribute("disabled", true);
        }

        function get_data_inputs_ship() {
            if (count_del_categorie_ship == 0) {
                name_categorie_ship.options[0].remove();
                count_del_categorie_ship = 1;
            }
            ship_btn.removeAttribute("disabled");
            mass_ship = document.getElementById('mass_ship').value / 1;
            price_one_ship = document.getElementById('price_one_ship').value / 1;
            blockage_ship = document.getElementById('blockage_ship').value / 100;
            console.log()
            if (blockage_ship == 0) {
                price_all_ship.value = '';
                price_all_ship.value = Math.floor((mass_ship) * price_one_ship);
            } else {
                price_all_ship.value = '';
                price_all_ship.value = Math.floor((mass_ship - (mass_ship * blockage_ship)) * price_one_ship);
            }
        }
    </script>
</body>
</html>
