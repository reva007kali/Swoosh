<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaffeMenuSeeder extends Seeder
{
    public function run(): void
    {
        $placeholder = 'image/menu.jpg';

        $caffeMenus = [
            // =====================
            // FOOD
            // =====================
            ['name' => 'Bakso Swoosh!', 'price' => 12000, 'category' => 'food', 'description' => 'Bakso homemade dengan kuah gurih dan topping spesial.', 'image' => null],
            ['name' => 'Siomay', 'price' => 18000, 'category' => 'food', 'description' => 'Siomay ikan khas Bandung dengan saus kacang creamy.', 'image' => null],
            ['name' => 'Beef Rice Bowl', 'price' => 22000, 'category' => 'food', 'description' => 'Nasi hangat dengan daging sapi tumis manis gurih.', 'image' => null],
            ['name' => 'Indomie Goreng', 'price' => 10000, 'category' => 'food', 'description' => 'Indomie goreng klasik yang tak pernah gagal.', 'image' => null],
            ['name' => 'Indomie Soto', 'price' => 10000, 'category' => 'food', 'description' => 'Indomie rasa soto segar dengan aroma rempah khas.', 'image' => null],
            ['name' => 'Mie Tek-tek', 'price' => 17000, 'category' => 'food', 'description' => 'Mie goreng pedas ala abang-abang dengan rasa nostalgic.', 'image' => null],
            ['name' => 'Ramyoon', 'price' => 25000, 'category' => 'food', 'description' => 'Mie pedas Korea dengan topping telur rebus.', 'image' => null],
            ['name' => 'French Fries', 'price' => 10000, 'category' => 'food', 'description' => 'Kentang goreng renyah, teman kopi yang pas.', 'image' => null],
            ['name' => 'Mixed Platter (Sosis + Mini Wonton)', 'price' => 15000, 'category' => 'food', 'description' => 'Snack campuran gurih untuk teman nongkrong.', 'image' => null],
            ['name' => 'Risol/Pastel/Kroket', 'price' => 7000, 'category' => 'food', 'description' => 'Gorengan isi lembut dengan rasa khas café.', 'image' => null],
            ['name' => 'Popmie', 'price' => 10000, 'category' => 'food', 'description' => 'Popmie instan yang selalu jadi andalan.', 'image' => null],
            ['name' => 'Cireng', 'price' => 8000, 'category' => 'food', 'description' => 'Cireng kenyal dengan sambal kacang pedas.', 'image' => null],
            ['name' => 'Donat', 'price' => 4000, 'category' => 'food', 'description' => 'Donat manis lembut dengan taburan gula halus.', 'image' => null],
            ['name' => 'Panacota (Puding)', 'price' => 15000, 'category' => 'food', 'description' => 'Puding lembut ala Italia dengan saus buah.', 'image' => null],

            // =====================
            // DRINK
            // =====================
            ['name' => 'Kopi Aren', 'price' => 18000, 'category' => 'drink', 'description' => 'Kopi susu dengan gula aren asli.', 'image' => null],
            ['name' => 'Dalgona Coffee', 'price' => 20000, 'category' => 'drink', 'description' => 'Kopi kocok lembut ala Korea.', 'image' => null],
            ['name' => 'Hazelnut Coffee', 'price' => 18000, 'category' => 'drink', 'description' => 'Kopi susu dengan aroma kacang hazelnut.', 'image' => null],
            ['name' => 'Caramel Coffee', 'price' => 18000, 'category' => 'drink', 'description' => 'Kopi manis dengan sirup karamel wangi.', 'image' => null],
            ['name' => 'Es Teh Original', 'price' => 12000, 'category' => 'drink', 'description' => 'Teh dingin segar untuk segala suasana.', 'image' => null],
            ['name' => 'Es Lychee Tea', 'price' => 14000, 'category' => 'drink', 'description' => 'Teh leci manis menyegarkan.', 'image' => null],
            ['name' => 'Es Yakult Lychee', 'price' => 16000, 'category' => 'drink', 'description' => 'Kombinasi segar Yakult dan buah leci.', 'image' => null],
            ['name' => 'Es Lemon Tea', 'price' => 14000, 'category' => 'drink', 'description' => 'Teh dingin dengan perasan lemon asli.', 'image' => null],
            ['name' => 'Milo Swoosh!', 'price' => 18000, 'category' => 'drink', 'description' => 'Milo kental ala Swoosh Café.', 'image' => null],
            ['name' => 'Es Bunga Telang', 'price' => 10000, 'category' => 'drink', 'description' => 'Teh bunga telang ungu segar alami.', 'image' => null],
            ['name' => 'Sinom', 'price' => 10000, 'category' => 'drink', 'description' => 'Minuman herbal Jawa penyegar badan.', 'image' => null],
            ['name' => 'Kopi Kapal Api Mix', 'price' => 8000, 'category' => 'drink', 'description' => 'Kopi klasik dengan rasa khas Nusantara.', 'image' => null],
            ['name' => 'White Coffee', 'price' => 8000, 'category' => 'drink', 'description' => 'Kopi ringan dengan rasa creamy.', 'image' => null],
            ['name' => 'Vanilla Milkshake', 'price' => 20000, 'category' => 'drink', 'description' => 'Milkshake vanilla lembut dan manis.', 'image' => null],
            ['name' => 'Teh Pucuk', 'price' => 8000, 'category' => 'drink', 'description' => 'Teh botol pucuk harum.', 'image' => null],
            ['name' => 'Coca Cola', 'price' => 8000, 'category' => 'drink', 'description' => 'Minuman soda klasik menyegarkan.', 'image' => null],
            ['name' => 'Ultramilk', 'price' => 5000, 'category' => 'drink', 'description' => 'Susu kotak segar siap minum.', 'image' => null],
            ['name' => 'Ichitan Tea', 'price' => 12000, 'category' => 'drink', 'description' => 'Teh dalam botol premium dari Thailand.', 'image' => null],
        ];

        foreach ($caffeMenus as &$menu) {
            $menu['image'] = $menu['image'] ?? $placeholder;
            $menu['created_at'] = now();
            $menu['updated_at'] = now();
        }

        DB::table('caffe_menus')->insert($caffeMenus);
    }
}
