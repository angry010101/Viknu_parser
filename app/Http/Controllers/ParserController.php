<?php

namespace App\Http\Controllers;
use App\Models\Sites;
use Validator;

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
                'sitename'                  => 'required|max:255',
                'siteurl'            => 'required|max:255',
                'sitelang'             => 'required|max:3',
                'titleelement'                 => 'required|max:255',
                'dataelement'              => 'required|max:255',
                'textelement' => 'required|max:255',
            ],
            [
                'sitename.required'       => 'Введите название источника!',
                'siteurl.required'       => 'Введите адрес источника!',
                'sitelang.required'       => 'Введите адрес источника!',
                'titleelement.required'       => 'Введите элемент заголовка!',
                'dataelement.required'       => 'Введите элемент даты!',
                'textelement.required'       => 'Введите элемент текста!',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $site = Sites::create([
            'sitename'             => $request->input('siteurl'),
            'first_name'       => $request->input('siteurl'),
            'last_name'        => $request->input('sitelang'),
            'email'            => $request->input('titleelement'),
            'email'            => $request->input('dataelement'),
            'email'            => $request->input('textelement'),
        ]);
        $site->save();

        return redirect('site')->with('success', 'Успешно!');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Sites::all();
        $data = [
            'sites'         => $sites,
        ];
        return view('pages.user.parser')->with($data);
    }

//    public function posts() {
//        // Your logic here
//        return view('posts');
//    }
}
