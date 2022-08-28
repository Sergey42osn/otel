<?php

namespace App\Http\Controllers;
use App\Models\Hotel;
use App\Models\Accommodation;
use App\Models\Post;
use App\Models\Page;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Country;

class SiteController extends Controller
{

    public function homePage()
    {
        /*Places*/
        $places = City::whereIn('id', [118,153,954,1330330,6998])->with('accommodations')->orderByRaw("FIELD(id, 118,153,954,1330330,6998)")->get();
        $place_images = [
            118 => '/images/Moscow.png',
            153 => '/images/Sankt-Petersburg.png',
            954 => '/images/Sochi.png',
            1330330 => '/images/Sevastopol.png',
            6998 => '/images/Yerevan.png'
        ];

        $hotels = Accommodation::whereIn('accommodationable_id',['358', '361','363', '412'])->whereHasMorph('accommodationable', Hotel::class, function ($query) {
            $query->whereHas('images', function ($q) {
                $q->where('featured_image', 1);
            });
        })->with(['wishList', 'city', 'country'])->limit(10)->get();

        //var_dump($hotels);
//        $hotels = array();
//        if($accommodations->count() > 0) {
//            foreach($accommodations as $a) {
//                if(($a->hotel() ? $a->hotel()->stars_num : NULL) == 5 && count($hotels) < 10)
//                {
//                    array_push($hotels,$a->toArray());
//                }
//            }
//        }
        $favorites = \Auth::check() ? WishList::where('user_id', \Auth::user()->id)->get(['id', 'accommodation_id'])->keyBy('accommodation_id')->map(function($item) {
            return $item['id'];
        })->toArray() : [];

        /*Blogs*/
        $blogs = Post::with('categories')->latest()->take(3)->get();
        return view('home_page')->with([
            'hotels'=>$hotels,
            'favorites'=>$favorites,
            'places' => $places,
            'place_images' => $place_images,
            'blogs'=>$blogs
        ]);
    }

    public function sendMail(Request $request) {
            $details = [
                'title' => 'Mail from Ruking',
                'email' => $request->email
            ];
            \Mail::to('newfollower@ruking.ru')->send(new \App\Mail\SendMailFromHome($details));
            return response()->json(['success'=>true]);

        }

    public function privicyPage() {
        $page = Page::find(1);
        $locale = \App::getLocale();
        $title = json_decode($page->title)->$locale;
        $content = json_decode($page->content, true);
        Carbon::setLocale(app()->getLocale());
        $updated_at = Carbon::createFromFormat('Y-m-d H:i:s', $page->updated_at)->translatedFormat('F d Y');
        return view('privacy_policy')->with([
            'title' => $title,
            'content' => $content,
            'updated' => $updated_at
        ]);
    }
    public function legalPage() {
        $page = Page::find(2);
        $locale = \App::getLocale();
        $title = json_decode($page->title)->$locale;
        $content = json_decode($page->content)->ru;
        return view('legal',$page)->with([
            'title' => $title,
            'content' => $content
        ]);
    }
    public function faqPage() {
        $page = Page::find(3);
        $locale = \App::getLocale();
        $title = json_decode($page->title)->$locale;
        $content = json_decode($page->content)->ru;
        return view('faq',$page);
    }

    public function testPage() {
        $acom = Accommodation::get();
        $hotel = array();
        foreach($acom as $a) {
            if($a->hotel()->stars_num == 5)
            {
                array_push($hotel,$a->toArray());
            }
        }
    }

    public function importCountries()
    {
        $countries_json = file_get_contents(public_path('countries.json'));
        $countries_array = json_decode($countries_json, true);
        foreach ($countries_array as $country) {
            $update = Country::where('iso3', $country['country_code3'])->update(['name' => json_encode(['ru' => $country['name'], 'en' => $country['english']], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)]);
            dump($update);
        }
    }
    public function agencyContractOffer(){
        return view('agency-contract-offer');
    }
    public function aviasales(){
        return view('aviasales');
    }
}
