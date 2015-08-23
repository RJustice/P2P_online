<?php

use Illuminate\Database\Seeder;

use App\Article;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('articles')->delete();
        for( $i=0; $i<10;$i++){
            Article::create([
                'title' => 'Title '. $i,
                'content' => 'Content '.$i,
                'alias' => 'title-'.$i,
                'introtext' => 'Content IntroText'.$i,
                'categoryid' => 1,
                'sectionid' => 1,
                'type' => 'normal',
            ]);
        }
    }
}
