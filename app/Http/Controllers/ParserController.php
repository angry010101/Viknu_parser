<?php

namespace App\Http\Controllers;
use App\Models\Groups;
use App\Models\Sites;
use App\Models\Posts;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Charts\PostList;
use Google\Cloud\Core\ServiceBuilder;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ParserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'sitename'      => 'required|max:255',
                'siteurl'       => 'required|max:255',
                'sitelang'      => 'required|max:3',
                'link'          => 'required|max:255',
                'title'         => 'required|max:255',
                'text'          => 'required|max:255',
            ],
            [
                'sitename.required'      => 'Укажите название источника!',
                'siteurl.required'       => 'Укажите адрес источника!',
                'sitelang.required'      => 'Укажите язык источника!',
                'link.required'          => 'Укажите элемент ссылки!',
                'title.required'         => 'Укажите элемент заголовка!',
                'text.required'          => 'Укажите элемент текста!',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $site = Sites::create([
            'name'             => $request->input('sitename'),
            'url'              => $request->input('siteurl'),
            'lang'             => $request->input('sitelang'),
            'link'             => $request->input('link'),
            'title'            => $request->input('title'),
            'text'             => $request->input('text'),
        ]);
        $site->save();

        return back()->with('success', 'Успешно!');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Sites::all();
        $groups = Groups::all();
        $groups_content = DB::table('groups_content')->get();

        $today_users = Posts::whereDate('created_at', today())->count();
        $yesterday_users = Posts::whereDate('created_at', today()->subDays(1))->count();
        $users_2_days_ago = Posts::whereDate('created_at', today()->subDays(2))->count();


        $chart1 = new PostList;
        $chart1->title('Статистика новых статей по дням');
        $chart1->labels(['Позавчера', 'Вчера', 'Сегодня']);
        $chart1->dataset('Статьи', 'line', [$users_2_days_ago, $yesterday_users, $today_users]);

        return view('pages.user.parser', compact('sites', 'chart1', 'groups', 'groups_content'));
    }

    /**
     * Parse selected sites.
     * @param Request $req
     * @return array|string|null
     */
    public function parse(Request $req)
    {
        $sites = [];

        return $req->input('groups');

        $selected = json_decode($req->getContent(), false);

        foreach ($selected as $id)
        {
            $sites[] = Sites::find($id);
        }

        $client = new Client();

        $client->setHeader('headers/User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36');

        $all = [];

        if(!empty($sites)) {
            foreach ($sites as $site) {

                $articles = [];

                $siteLink = $site->url;

                $siteCrawler = $client->request('GET', $siteLink);

                $links = $siteCrawler->filter($site->link)->extract(['href']);

                foreach ($links as $link){

                    if ($link[0] === '/' || strpos($link, $siteLink) === 0){
                        if($link[0] === '/') {
                            if($siteLink[-1] === '/'){
                                $siteLink = rtrim($siteLink, '/');
                            }
                            $link = $siteLink . $link;
                        }
                        $articleCrawler = $client->request('GET', $link);

                        $articleCrawler->filter('script')->each(function ($crawler) {
                            foreach ($crawler as $node) {
                                $node->parentNode->removeChild($node);
                            }
                        });

                        $title = $articleCrawler->filter($site->title);


                        $text = $articleCrawler->filter($site->text);


                        if($title->count() !== 0 && $text->count() !== 0){
                            $article = [$title->text(), $text->text(), $link];

                            $articles[] = $article;
                        }
                    }
                }
                foreach ($articles as $article){
                    $post = Posts::firstOrCreate([
                        'site'  => $siteLink,
                        'title' => $article[0],
                        'text'  => $article[1],
                    ]);

                    $post->save();
                }
            }
        }

        return('success');
    }


    public function sentiment(Request $req)
    {

        $tr = new GoogleTranslate();
        $tr->setSource();
        $tr->setTarget('en');

        $cloud = new ServiceBuilder([
            'keyFilePath' => base_path('public/js/Sentiment Parser-125fec859535.json'),
            'projectId' => 'sample-207012'
        ]);

        $language = $cloud->language();

        // The text to analyse
        $text = $tr->translate($req->post()['text']);

        // Detect the sentiment of the text
        $annotation = $language->analyzeSentiment($text);
        $sentiment = $annotation->sentiment();

        $post = Posts::find($req->post()['post']);

        if($sentiment['score'] === 0){
            $tonality = 1;
        }elseif ($sentiment['score'] > 0){
            $tonality = 2;
        }elseif ($sentiment['score'] < 0){
            $tonality = 3;
        }else{
            $tonality = 4;
        }

        $post->tonality = $tonality;
        $post->save();

        echo 'Source text: ' . $text . 'Sentiment Score: ' . $sentiment['score'] . ', Magnitude: ' . $sentiment['magnitude'];
    }

    public function saveGroup(Request $req){

        $validator = Validator::make($req->all(),
            [
                'groupName'      => 'required|max:255',
                'groupSites'     => 'required',
            ],
            [
                'groupName.required'      => 'Укажите название группы!',
                'groupSites.required'     => 'Не выбрано ни одного источника!',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $group = Groups::create([
            'name'    => $req->input('groupName'),
        ]);

        $group->save();


        foreach ($req->input('groupSites') as $site){
            DB::table('groups_content')->insert(
                [
                    'group_id' => $group->id,
                    'site_id'  => $site
                ]
            );
        }

        return redirect()->back();


    }

}
