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

        if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'homepage_order')) {
            $products = Product::with('images')
                ->whereNotNull('homepage_order')
                ->orderBy('homepage_order')
                ->orderBy('id')
                ->get();
        } elseif ($settings && !$settings->product_slider_auto) {
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
