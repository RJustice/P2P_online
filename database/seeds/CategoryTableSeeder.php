<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('category')->delete();
        Category::create([
                'name' => '网站公告',
                'alias' => 'notices',
                'section_id' => 0,
                'parent_id' => 0,
                'description' => '网站公告分类',
                'ordering' => '4',
                'published' => 1,
        ]);
        Category::create([
                'name' => '公司新闻',
                'alias' => 'official-news',
                'section_id' => 0,
                'parent_id' => 0,
                'description' => '网站公告分类',
                'ordering' => '3',
                'published' => 1,
        ]);
        Category::create([
                'name' => '行业新闻',
                'alias' => 'industry-news',
                'section_id' => 0,
                'parent_id' => 0,
                'description' => '网站公告分类',
                'ordering' => '2',
                'published' => 1,
        ]);
        Category::create([
                'name' => '媒体报道',
                'alias' => 'media-reports',
                'section_id' => 0,
                'parent_id' => 0,
                'description' => '网站公告分类',
                'ordering' => '1',
                'published' => 1,
        ]);
    }
}
