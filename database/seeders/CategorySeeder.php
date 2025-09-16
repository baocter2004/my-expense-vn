<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Ăn uống', 'descriptions' => 'Chi phí ăn uống hàng ngày'],
            ['name' => 'Đi lại', 'descriptions' => 'Xăng xe, taxi, xe bus...'],
            ['name' => 'Nhà ở', 'descriptions' => 'Tiền thuê nhà, điện nước, internet...'],
            ['name' => 'Mua sắm', 'descriptions' => 'Quần áo, đồ dùng cá nhân...'],
            ['name' => 'Giải trí', 'descriptions' => 'Xem phim, ca nhạc, game...'],
            ['name' => 'Sức khỏe', 'descriptions' => 'Khám bệnh, thuốc men, bảo hiểm...'],
            ['name' => 'Giáo dục', 'descriptions' => 'Học phí, sách vở, khóa học...'],
            ['name' => 'Gia đình', 'descriptions' => 'Chi tiêu cho người thân, con cái...'],
            ['name' => 'Tiết kiệm', 'descriptions' => 'Tiền tiết kiệm, đầu tư...'],
            ['name' => 'Khác', 'descriptions' => 'Các chi tiêu khác chưa phân loại'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'descriptions' => $category['descriptions'],
                'is_active' => true,
                'user_id' => null,
                'group_id' => null,
                'is_system' => true
            ]);
        }
    }
}
