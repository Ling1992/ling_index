<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use XS;
use XSDocument;
use XSException;
use XSTokenizerScws;

class updateArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateArticle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ling';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = 103493;
//        $id = 10;
        $xs = new XS("demo");
        $doc = new XSDocument;  // 使用默认字符集

        for ($index =1; $index <=$id; $index ++) {
            $this->info($index);
            $data = DB::table('toutiao_article_list as a')
                ->leftJoin('toutiao_author as b', 'b.author_id', '=', 'a.author_id')
                ->leftJoin('toutiao_article_category as c', 'c.category_id','=', 'a.category_id')
                ->select('a.id as article_id',
                    'c.name as category',
                    'a.title',
                    'a.image_url as title_image',
                    'a.abstract',
                    'a.create_date',
                    'b.author_id',
                    'b.name as author',
                    'a.article_table_tag',
                    'a.article_id as article_table_id')
                ->where('a.id', $index)
                ->first();
            $article = DB::table("toutiao_article_0{$data->article_table_tag}")->where('id',$data->article_table_id)->first();
            $data->article=$article->article;
            $data->create_date = strtotime($data->create_date) + mt_rand(60, 1800);
            $temp = [];
            foreach ($data as $k=>$v ){
                $temp[$k] = $v;
            }
            $doc->setFields($temp);
            $xs->index->update($doc, true);
        }
        $xs->index->flushIndex();
    }
}
