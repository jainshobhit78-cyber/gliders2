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
use App\Mail\InquiryReplyMail;
use Illuminate\Support\Facades\Mail;
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

        if ($settings && !$settings->product_slider_auto) {
            $ids = array_filter([
                $settings->homepage_product_1,
                $settings->homepage_product_2,
                $settings->homepage_product_3,
                $settings->homepage_product_4
            ]);
            if (!empty($ids)) {
                $productsMap = Product::with('images')->whereIn('id', $ids)->get()->keyBy('id');
                // Order exactly as selected by admin (1, 2, 3, 4)
                $products = collect($ids)->map(function ($id) use ($productsMap) {
                    return $productsMap->get($id);
                })->filter()->values();
            } else {
                $products = collect();
            }
        } else {
            // standard autoplay slider: fetch all products ordered by display_order
            $products = Product::with('images')
                ->orderBy('display_order', 'asc')
                ->orderBy('id', 'asc')
                ->get();
        }

        $keyOfferings = KeyOffering::with('category')
            ->where('is_home', 1)
            ->latest()
            ->get();

        $offeringImage = function (array $keywords, ?string $fallback = null) use ($keyOfferings): ?string {
            $match = $keyOfferings->first(function (KeyOffering $offering) use ($keywords): bool {
                $searchable = strtolower(strip_tags(implode(' ', [
                    $offering->title,
                    $offering->description,
                    optional($offering->category)->name,
                ])));

                foreach ($keywords as $keyword) {
                    if (str_contains($searchable, strtolower($keyword))) {
                        return true;
                    }
                }

                return false;
            });

            if ($match?->image) {
                return asset('uploads/key_offerings/'.$match->image);
            }

            return $fallback ? asset($fallback) : null;
        };

        $businessOfferings = [
            [
                'title' => 'Parachutes',
                'slug' => 'parachutes',
                'image' => $offeringImage(
                    ['parachute', 'aerial delivery'],
                    'uploads/key_offerings/1776004316_parachutes-aerial-delivery.png'
                ),
            ],
            [
                'title' => 'Rubber Inflatables',
                'slug' => 'rubber-inflatables',
                'image' => $offeringImage(
                    ['rubber', 'inflatable', 'float', 'boat'],
                    'uploads/products/km_bridge.jpg'
                ),
            ],
            [
                'title' => 'Technical Clothing and Equipments',
                'slug' => 'technical-clothing',
                'image' => $offeringImage(
                    ['technical clothing', 'clothing', 'garment', 'apparel'],
                    'uploads/products/nbc_suit.jpg'
                ),
            ],
        ];

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

        // Featured "Blogs" slider (top-right of the news/contact section): Blogs category only.
        $blogCategory = \App\Models\NewsCategory::whereRaw('LOWER(TRIM(name)) = ?', ['blogs'])->first();
        $blogArticles = collect();
        if ($blogCategory) {
            $blogQuery = NewsArticle::where('category_id', $blogCategory->id)
                ->where('status', 'Published');
            if ($isElectionMode) {
                $blogQuery->where('hide_during_election', false);
            }
            $blogArticles = $blogQuery->latest()->take(5)->get();
        }

        $partnerLogos = PartnerLogo::latest()->get();

        // Self-healing database check to automatically create our_partners table if missing
        if (!\Illuminate\Support\Facades\Schema::hasTable('our_partners')) {
            try {
                \Illuminate\Support\Facades\Schema::create('our_partners', function ($table) {
                    $table->id();
                    $table->string('image')->nullable();
                    $table->string('name')->nullable();
                    $table->timestamps();
                });
                
                // Seed initial data
                $partners = [
                    ['name' => 'India Army', 'image' => 'frontend/images/section/4.png'],
                    ['name' => 'Indian Air Force', 'image' => 'frontend/images/section/3.png'],
                    ['name' => 'DRDO', 'image' => 'frontend/images/section/2.png'],
                    ['name' => 'Vietnam Air Force', 'image' => 'frontend/images/section/1.png'],
                ];
                foreach ($partners as $partner) {
                    \App\Models\OurPartner::create($partner);
                }
            } catch (\Exception $e) {
                // Ignore or log error
            }
        }

        $ourPartners = \App\Models\OurPartner::latest()->get();

        return view('frontend.home.index', compact(
            'videoBanner',
            'tickerItems',
            'settings',
            'galleryImages',
            'stateCounter',
            'products',
            'keyOfferings',
            'businessOfferings',
            'latestNews',
            'blogArticles',
            'playlists',
            'ourUnit',
            'leaders',
            'partnerLogos',
            'ourPartners'
        ));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|integer|exists:products,id',
            'subject' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
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

        ContactMessage::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'email' => $request->email,
            'subject' => $request->subject ?? 'General Inquiry',
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Message sent successfully!');
    }

    public function adminIndex()
    {
        // Self-healing database check to automatically add missing columns
        try {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('contact_messages', 'reply_text')) {
                \Illuminate\Support\Facades\Schema::table('contact_messages', function ($table) {
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('contact_messages', 'product_id')) {
                        $table->integer('product_id')->nullable()->after('id');
                        $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('contact_messages', 'subject')) {
                        $table->string('subject')->nullable()->after('email');
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('contact_messages', 'reply_text')) {
                        $table->text('reply_text')->nullable()->after('message');
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('contact_messages', 'replied_at')) {
                        $table->timestamp('replied_at')->nullable()->after('reply_text');
                    }
                    if (!\Illuminate\Support\Facades\Schema::hasColumn('contact_messages', 'status')) {
                        $table->string('status')->default('pending')->after('replied_at');
                    }
                });
            }
        } catch (\Exception $e) {
            // Silently catch to avoid disrupting page render
        }

        try {
            ContactMessage::where('status', 'pending')->update(['status' => 'read']);
        } catch (\Exception $e) {
            // Silently catch in case table columns are still migrating
        }

        $messages = ContactMessage::with('product')->latest()->get();

        return view('backend.inquiry.index', compact('messages'));
    }

    public function replyContact(Request $request, $id)
    {
        $request->validate([
            'reply_subject' => 'required|string|max:255',
            'reply_body' => 'required|string',
        ]);

        $message = ContactMessage::findOrFail($id);

        try {
            Mail::to($message->email)->send(new InquiryReplyMail(
                $request->reply_subject,
                $request->reply_body,
                $message
            ));

            $message->update([
                'reply_text' => $request->reply_body,
                'replied_at' => now(),
                'status' => 'replied'
            ]);

            return back()->with('success', 'Reply sent successfully to ' . $message->email . '!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to send email: ' . $e->getMessage()]);
        }
    }
}
