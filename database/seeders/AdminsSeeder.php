<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                "name" => "Suren.Ikemen",
                "password" => "Suren123",
                "real_name" => "イケメン スレン",
                "admin_type" => "admin"
            ],
            [
                "name" => "Furuhashi.Shacho",
                "password" => "Makikudasai123",
                "real_name" => "古橋 慶樹",
                "admin_type" => "ceo"
            ],
            [
                "name" => "Toba.Shisho",
                "password" => "Magarimika123",
                "real_name" => "鳥羽 晋也",
                "admin_type" => "ceo"
            ],
            [
                "name" => "Nagase.Makoto",
                "password" => "Maxmaki123",
                "real_name" => "長瀬 誠",
                "admin_type" => "ceo"
            ],
            [
                "name" => "Shouji.Kitora",
                "password" => "innamaki123",
                "real_name" => "木虎祥ニ",
                "admin_type" => "ceo"
            ],
            [
                "name" => "J.Tumurchudur",
                "password" => "Miniiduuhuurhun123",
                "real_name" => "ジグジド トムルチョドル",
                "admin_type" => "ceo"
            ],
            [
                "name" => "Nonaka.Kozue",
                "password" => "Grandvalue123",
                "real_name" => "野中梢絵",
                "admin_type" => "regular"
            ],
            [
                "name" => "Ebihara.Misuzu",
                "password" => "Grandvalue123",
                "real_name" => "海老原美寿々",
                "admin_type" => "regular"
            ],
            [
                "name" => "Maemura.Junki",
                "password" => "Maxmikakudasai123",
                "real_name" => "前村潤奎",
                "admin_type" => "regular"
            ],
            [
                "name" => "Kodama.Yudai",
                "password" => "Grandvalue123",
                "real_name" => "児玉優大",
                "admin_type" => "regular"
            ]
        ];


        foreach ($admins as $value) {
            $temp = [
                "name" => $value['name'],
                "password" => Hash::make($value["password"]),
                "real_name" => $value['real_name'],
                "admin_type" => $value['admin_type'],
                'is_employee' => 'admin',
            ];
            \App\Models\User::create($temp);
        }
    }
}
