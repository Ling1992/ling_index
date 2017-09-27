<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use XS;
use XSDocument;

class ImportArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $xs = new XS("indexone");
        $doc = new XSDocument;  // 使用默认字符集
        $i = 0;
        for ( $index = 1;$index <= 116119; $index ++) {

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
            $data->create_date = strtotime($data->create_date) + mt_rand(60, 120);
            $temp = [];
            foreach ($data as $k=>$v ){
                $temp[$k] = $v;
            }
            $doc->setFields($temp);
            $xs->index->update($doc);

            $i += 1;

            if ($i > 10) {
                $i = 0;
                sleep(1);
            }
        }
        $xs->index->flushIndex();
    }
}
