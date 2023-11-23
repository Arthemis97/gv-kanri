<?php

namespace Database\Seeders;

use App\Models\Prefecture;
use App\Models\Work_place;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prefecture = [
            '愛知県',
            '秋田県',
            '青森県',
            '千葉県',
            '愛媛県',
            '福井県',
            '福岡県',
            '福島県',
            '岐阜県',
            '群馬県',
            '広島県',
            '北海道',
            '兵庫県',
            '茨城県',
            '石川県',
            '岩手県',
            '香川県',
            '鹿児島県',
            '神奈川県',
            '高知県',
            '熊本県',
            '京都府',
            '三重県',
            '宮城県',
            '宮崎県',
            '長野県',
            '長崎県',
            '奈良県',
            '新潟県',
            '大分県',
            '岡山県',
            '沖縄県',
            '大阪府',
            '佐賀県',
            '埼玉県',
            '滋賀県',
            '島根県',
            '静岡県',
            '栃木県',
            '徳島県',
            '東京都',
            '鳥取県',
            '富山県',
            '和歌山県',
            '山形県',
            '山口県',
            '山梨県'
        ];

        $work_place = [
            '丸和運輸機関　（浦和美園SC）',
            '丸和運輸機関　（相模原SC）',
            '丸和運輸機関　（MK吉川）',
            '丸和運輸機関　（野田）',
            '丸和運輸機関　（三郷）',
            '丸和運輸機関　（MK相模原）',
            '中澤乳業　（城南島）',
            '中澤乳業　（湘南工場）',
            '中澤乳業　（ドライバー）',
            'M・Ishii',
            'マルカ　（相模原営業所）',
            'マルカ　（佐江戸）',
            'マルカ　（塩浜）',
            'ファイズ　（海老名）',
            '中央環境　（産廃）',
            '京和運輸　（仕分け）',
            '鈴翔　（ドライバー）',
            '鈴翔　（仕分け）',
            '公徳運輸　（デバニング）',
            '公徳運輸　（引越し）',
            'A-YU（建築）',
            '中村梱包（ドライバー）',
            '中村梱包（仕分け）',
            'ジャパンアクセス　（ドライバー）',
            '誠建　（ドライバー）'
        ];

        foreach ($prefecture as $key => $value) {
            Prefecture::create([
                'name' => $value
            ]);
        }
        foreach ($work_place as $key => $value) {
            Work_place::create([
                'name' => $value
            ]);
        }
    }
}
