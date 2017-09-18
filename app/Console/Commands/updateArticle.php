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
        $id = DB::table('toutiao_article_list')->max('id');

        $xs = new XS("demo");
        $doc = new XSDocument;  // 使用默认字符集

        $das = $xs->search->setLimit(1)->setSort('article')->search("");

        $start_id = $das[0]->article_id;
        if (! is_numeric($start_id)) {
            exit('start _id 不是数字');
        }
        if ($start_id <= 10000) {
            exit('start _id 小于 10000');
        }

        $end_id = $id;

        if (! is_numeric($end_id)) {
            exit('end _id 不是数字');
        }
        if ($end_id <= 10000) {
            exit('end _id 小于 10000');
        }

        $this->info($start_id);
        $this->info($end_id);

        $update_file = base_path('update_file.log');

        if (!file_exists($update_file)) {
            exit('update_file 不存在 ！！！');
        }
        for ( $index = $start_id;$index <=$end_id; $index ++) {
            if (!file_exists($update_file)) {
                $this->info('update_file 不存在 ！！！');
                break;
            }
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
            $xs->index->update($doc, true);
            sleep(1);
        }
        $xs->index->flushIndex();
    }
}
