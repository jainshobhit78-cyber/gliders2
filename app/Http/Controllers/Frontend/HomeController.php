<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutLeadership;
use App\Models\ContactMessage;
use App\Models\ImageGallery;
use App\Models\KeyOffering;
use App\Models\NewsArticle;
use App\Models\PartnerLogo;
use App\Models\Playlist;
use App\Models\Product;
use App\Models\StateCounter;
use App\Models\VideoBanner;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $videoBanner = VideoBanner::latest()->first();
        $tickerItems = \App\Models\TickerNews::where('is_active', true)->orderBy('position', 'asc')->get();
        $settings = \App\Models\GeneralSetting::first();
        $galleryImages = ImageGallery::latest()->get();
        $stateCounter = StateCounter::latest()->first();

        $products = Product::with('images')->latest()->get();

        $keyOfferings = KeyOffering::where('is_home', 1)
            ->latest()
            ->get();

        $isElectionMode = \App\Models\GeneralSetting::isElectionMode();

        $playlistQuery = Playlist::with(['images', 'videos'])->where('status', 'Published');
        if ($isElectionMode) {
            $playlistQuery->where('hide_during_election', false);
        }
        $playlists = $playlistQuery->latest()->get();

        $leaders = AboutLeadership::with('milestones')
            ->orderBy('position', 'asc')
            ->get();

        $ourUnit = DB::table('our_units')->first();

        $newsQuery = NewsArticle::where('status', 'Published');
        if ($isElectionMode) {
            $newsQuery->where('hide_during_election', false);
        }
        $latestNews = $newsQuery->latest()->take(5)->get();


        $partnerLogos = PartnerLogo::latest()->get();

        return view('frontend.home.index', compact(
            'videoBanner',
            'tickerItems',
            'settings',
            'galleryImages',
            'stateCounter',
            'products',
            'keyOfferings',
            'latestNews',
            'playlists',
            'ourUnit',
            'leaders',
            'latestNews',
            'partnerLogos'
        ));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'captcha' => 'required|integer',
        ]);

        if ($request->captcha != (session('captcha_num1') + session('captcha_num2'))) {
            session([
                'captcha_num1' => rand(1, 10),
                'captcha_num2' => rand(1, 10)
            ]);
            return back()->withErrors(['captcha' => 'Invalid CAPTCHA answer. Please try again.'])->withInput();
        }

        session([
            'captcha_num1' => rand(1, 10),
            'captcha_num2' => rand(1, 10)
        ]);

        ContactMessage::create($request->only(['name', 'email', 'phone', 'message']));

        return back()->with('success', 'Message sent successfully!');
    }

    public function adminIndex()
    {
        $messages = ContactMessage::latest()->get();

        return view('backend.inquiry.index', compact('messages'));
    }
}