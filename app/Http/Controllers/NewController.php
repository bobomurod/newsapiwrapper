<?php

namespace App\Http\Controllers;

use App\Services\NewsApiService;
use App\Services\TranslateService;
use App\WebSockets\NewsWebSocket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class NewController extends Controller
{

    public function latest()
    {
        $news = NewsApiService::topHeadlines();
        $texts = [];
        $datas = [];
        if (isset($news['articles']) && is_array($news['articles'])) {
            foreach ($news['articles'] as $article) {
                $redis = Redis::get(md5($article['url']));
                if (empty($redis)) {
                    $texts[] = [
                        'id' => "title_" . md5($article['url']),
                        'name' => substr($article['title'],0,30),
                    ];
                    $texts[] = [
                        'id' => "description_" . md5($article['url']),
                        'name' => substr($article['description'],0,30),
                    ];
                } else {
                    $decode = json_decode($redis,true);
                    $datas[]=[
                        'title' => $decode['title'] ?? '',
                        'description' => $decode['description'] ?? '',
                    ];
                }
            }

            if (!empty($texts)) {
                $translates = TranslateService::translate("en", "uz", $texts);
                if (!empty($translates)) {
                    foreach ($translates as $translate) {
                        if (substr($translate['id'], 0, 5) == "title") {
                            Redis::set(
                                substr($translate['id'], 6),
                                json_encode([
                                    'title' => $translate['name'],
                                ])
                            );
                        }else{
                            $r = Redis::get(substr($translate['id'],12));
                            if (!empty($r)){
                                Redis::set(
                                    substr($translate['id'],12),
                                    json_encode([
                                        'title' => $r,
                                        'description' => $translate['name'],
                                    ]),
                                );
                                $title = json_decode($r,true);
                                $datas[] = [
                                    'title' => $title['title'] ?? '',
                                    'description' => $translate['name'],
                                ];
                            }else{
                                $datas[] = [
                                    'title' => "",
                                    'description' => $translate['name'],
                                ];
                            }
                        }
                    }
                }
            }
        }

        return view('news', [
            'datas' => $datas,
        ]);
    }

    public function createNewArticle(Request $request)
    {
        $article = [
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ];
        broadcast(new NewArticleEvent($article));
        return response()->json(['message' => 'Article created successfully']);
    }
}
