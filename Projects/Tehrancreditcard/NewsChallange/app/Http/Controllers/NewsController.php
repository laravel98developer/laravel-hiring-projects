<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\NewsAPIService;
use App\Services\GuardianService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NewsController extends Controller
{
    protected $newsAPIService;
    protected $guardianService;

    public function __construct(NewsAPIService $newsAPIService, GuardianService $guardianService)
    {
        $this->newsAPIService = $newsAPIService;
        $this->guardianService = $guardianService;
    }


    public function storeNewsFromNewsApi()
    {
        $newsData = $this->newsAPIService->fetchNews();

        foreach ($newsData as $article) {
            News::updateOrCreate(
                //  Prevent for saving dublicate news
                [
                    "title" => $article["title"],
                    "url"   => $article["url"],
                ],
                [
                    "content"      => $article["content"],
                    "external_id"  => str::random(16),
                    "source"       => "NewsApi",
                    "author"       => $article["author"],
                    "published_at" => $this->parseDataTime($article["publishedAt"]),
                ],
            );

            return response()->json(["message" => "News stored succsesfully ! ( NewsApi )"]);


        }
    }

    public function storeNewsFromGuardian()
    {
        $newsData = $this->guardianService->fetchNews();

        foreach ($newsData as $article) {
            News::updateOrCreate(
                //  Prevent for saving dublicate news
                [
                    "title" => $article["webTitle"],
                    "url"   => $article["webUrl"],
                ],
                [
                    "content"      => $article["fields"]['bodyText'],
                    "external_id"  => str::random(16),
                    "source"       => "Guardain",
                    "author"       => $article["fields"]["byline"] ?? "Unkown",
                    "published_at" => $this->parseDataTime($article["webPublicationDate"]),
                ],
            );
        }
        return response()->json(["message" => "News stored succsesfully ! ( Guardian )"]);

    }

    private function parseDataTime($dateTimeString)
    {
        return Carbon::parse($dateTimeString)->setTimezone('UTC')->format('Y-m-d H:i:s');
    }

    public function showNews(Request $request)
    {
        $query = News::orderBy('published_at', 'desc');

        if ($request->has('source') && $request->source != '') {
            $query->where('source', $request->source);

        }

        if ($request->has('published_at') && $request->published_at != '') {
            $query->whereDate('published_at', $request->published_at);

        }

        $news = $query->get();

        $sources = News::distinct()->pluck('source');
        $dates = News::orderBy('published_at')->pluck('published_at');

        return view('news.index', [

            "news"           => $news,
            "sources"        => $sources,
            "dates"          => $dates,
            "selectedSource" => $request->source,
            "selectedDate"   => $request->published_at,

        ]);
    }

    public function newsPage($externalId)
    {
        $news = News::where("external_id", $externalId)->first();
        if ($news) {
            return view('news.show', ["news" => $news]);
        } else {
            abort(404);
        }
    }
}
