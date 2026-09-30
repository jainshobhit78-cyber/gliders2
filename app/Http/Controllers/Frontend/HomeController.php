<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutLeadership;
use App\Models\ContactMessage;
use App\Models\ImageGallery;
use App\Models\NewsArticle;
use App\Models\PartnerLogo;
use App\Models\Product;
use App\Models\StateCounter;
use App\Models\VideoBanner;
use App\Support\VisualCaptcha;
use Illuminate\Http\Request;
use App\Mail\InquiryReplyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
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

        // Keep the homepage showcase focused and in a deliberate catalogue order.
        // Product records remain untouched; only this public-facing slider is curated.
        $productCatalog = Product::with(['images', 'category'])
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $homepageProductSequence = [
            [0, 'Man Carrying Parachutes', 'BMK-41', 'pilot-bmk41.jpg'],
            [0, 'Man Carrying Parachutes', 'Seat Mk-10', 'pilot-seat-mk10.jpg'],
            [1, 'Brake Parachutes', 'LCA (Tejas)', 'brake-tejas.jpg'],
            [1, 'Brake Parachutes', 'SU-30', 'brake-su30.jpg'],
            [2, 'Man Carrying Parachutes', 'PTA-M', 'pta-main.jpg'],
            [2, 'Man Carrying Parachutes', 'PTA-R', 'pta-reserve.jpg'],
            [3, 'Cargo Parachutes', 'P-7 Heavy Drop', 'cargo-p7.jpg'],
            [3, 'Cargo Parachutes', 'ECAD', 'cargo-ecad.jpg'],
            [4, 'Rubber Inflatables', 'BAPLW', 'inflatable-baplw.jpg'],
            [4, 'Rubber Inflatables', 'Gemini Craft', 'inflatable-gemini.jpg'],
            [5, 'Technical Clothing', 'NBC Suit', 'clothing-nbc.jpg'],
            [5, 'Technical Clothing', 'Wind Cheater', 'clothing-jacket.jpg'],
        ];

        $products = collect($homepageProductSequence)
            ->map(function (array $slot, int $fallbackOrder) use ($productCatalog) {
                [$group, $categoryName, $titleMatch, $image] = $slot;
                $product = $productCatalog->first(function (Product $candidate) use ($categoryName, $titleMatch) {
                    return strcasecmp((string) optional($candidate->category)->name, $categoryName) === 0
                        && str_contains(mb_strtolower($candidate->title), mb_strtolower($titleMatch));
                });

                if ($product) {
                    $product->setAttribute('homepage_card_image', asset('frontend/images/home-products/' . $image));
                }

                return $product ? ['group' => $group, 'fallback_order' => $fallbackOrder, 'product' => $product] : null;
            })
            ->filter()
            ->groupBy('group')
            ->sortKeys()
            ->flatMap(function ($groupSlots) {
                return $groupSlots
                    ->sort(function (array $left, array $right) {
                        $leftOrder = $left['product']->homepage_order;
                        $rightOrder = $right['product']->homepage_order;

                        if ($leftOrder !== null && $rightOrder !== null && $leftOrder !== $rightOrder) {
                            return $leftOrder <=> $rightOrder;
                        }

                        if ($leftOrder !== null && $rightOrder === null) {
                            return -1;
                        }

                        if ($leftOrder === null && $rightOrder !== null) {
                            return 1;
                        }

                        return $left['fallback_order'] <=> $right['fallback_order'];
                    })
                    ->pluck('product');
            })
            ->values();

        $isElectionMode = \App\Models\GeneralSetting::isElectionMode();

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
            'latestNews',
            'blogArticles',
            'ourUnit',
            'leaders',
            'partnerLogos',
            'ourPartners'
        ));
    }

    public function storeContact(Request $request)
    {
        // Honeypot: real users never see/fill the "website" field. If it's set,
        // silently pretend success so bots get no useful signal.
        if ($request->filled('website')) {
            return back()->with('success', 'Thank you! Your message has been sent.');
        }

        $request->validate([
            'product_id' => 'nullable|integer|exists:products,id',
            'subject' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'captcha' => 'required|string|size:' . VisualCaptcha::LENGTH,
        ]);

        $captchaKey = VisualCaptcha::limiterKey('public', $request);
        if (RateLimiter::tooManyAttempts($captchaKey, 3)) {
            return back()->withErrors([
                'captcha' => 'Too many incorrect CAPTCHA entries. Please wait ' . RateLimiter::availableIn($captchaKey) . ' seconds before trying again.',
            ])->withInput();
        }

        if (! VisualCaptcha::verify($request, 'public', $request->input('captcha'))) {
            RateLimiter::hit($captchaKey, 300);
            $attemptsRemaining = max(0, 3 - RateLimiter::attempts($captchaKey));
            $message = $attemptsRemaining > 0
                ? 'Incorrect CAPTCHA. ' . $attemptsRemaining . ' attempt(s) remaining before a 5-minute lock.'
                : 'Too many incorrect CAPTCHA entries. CAPTCHA entry is locked for 5 minutes.';

            return back()->withErrors(['captcha' => $message])->withInput();
        }
        RateLimiter::clear($captchaKey);

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
