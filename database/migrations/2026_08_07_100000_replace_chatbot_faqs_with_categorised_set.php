<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Replaces the Glide Bot knowledge base with the supplied question set and
     * groups it so the widget stops dumping every question at once.
     *
     * Categories are internal only - they are never rendered. They drive two
     * things: which handful of questions the widget opens with (is_starter),
     * and which questions are offered as follow-ups once an answer is given
     * (the siblings of whatever category was just answered).
     *
     * Greetings therefore stand on their own: saying "Hello" returns the
     * greeting and then offers the topic entry points, rather than listing
     * forty-two questions.
     */
    private array $faqs = [
        // ---- greeting: answered, then hands off to the topic entry points ----
        ['Hello', 'Hello! Welcome to Gliders India Limited. How may I assist you today?', 'greeting', 0],
        ['Hi', 'Hi! Welcome to Gliders India Limited (GIL). What would you like to know?', 'greeting', 0],
        ['Good Morning', 'Good morning! Welcome to Gliders India Limited. How can I help you?', 'greeting', 0],
        ['Good Afternoon', 'Good afternoon! How may I assist you regarding Gliders India Limited?', 'greeting', 0],
        ['Good Evening', 'Good evening! How can I help you today?', 'greeting', 0],
        ['Who are you?', 'I am Glide Bot, the virtual assistant for Gliders India Limited. I can answer questions about the organisation, products, contact details, and more.', 'greeting', 0],

        // ---- company ----
        ['What is Gliders India Limited?', 'Gliders India Limited (GIL) is a Government of India Undertaking under the Ministry of Defence engaged in manufacturing defence parachutes and related equipment.', 'company', 1],
        ['Is Gliders India a government company?', 'Yes. Gliders India Limited is a Government of India Undertaking under the Ministry of Defence.', 'company', 0],
        ['What does GIL stand for?', 'GIL stands for Gliders India Limited.', 'company', 0],
        ['What is your mission?', 'Information about GIL\'s mission is available under the Mission section of the official website.', 'company', 0],
        ['What is your vision?', 'The Vision section is available on the official website describing the organisation\'s goals.', 'company', 0],
        ['Do you have CSR activities?', 'Yes. Gliders India Limited undertakes Corporate Social Responsibility (CSR) initiatives.', 'company', 0],
        ['Where can I find company leadership?', 'The Leadership section is available under the About menu on the official website.', 'company', 0],
        ['Do you have HR information?', 'Yes. Human Resources information is available under the About section of the website.', 'company', 0],
        ['Where can I find the company directory?', 'The Directory is available under the About section of the website.', 'company', 0],

        // ---- products ----
        ['What products do you manufacture?', 'GIL manufactures man-carrying parachutes, cargo parachutes, brake parachutes, pilot parachutes, KM floats, inflatable boats, and other defence-related equipment.', 'products', 1],
        ['Do you manufacture military parachutes?', 'Yes. Military parachutes are among GIL\'s primary products.', 'products', 0],
        ['Do you manufacture cargo parachutes?', 'Yes. Cargo parachutes are part of GIL\'s product portfolio.', 'products', 0],
        ['Do you manufacture brake parachutes?', 'Yes. GIL manufactures brake parachutes.', 'products', 0],
        ['Do you manufacture pilot parachutes?', 'Yes. GIL manufactures pilot parachutes.', 'products', 0],
        ['Do you manufacture personal parachutes?', 'Yes. GIL manufactures personal and man-carrying parachutes.', 'products', 0],
        ['Do you manufacture inflatable boats?', 'Yes. GIL manufactures inflatable boats for defence applications.', 'products', 0],
        ['Do you manufacture air-droppable containers?', 'GIL has announced successful production and trials of the ADC-150 Air Droppable Container.', 'products', 0],
        ['Do you have a product catalogue?', 'Yes. The Products section includes a product catalogue.', 'products', 0],
        ['Can I download your catalogue?', 'Please visit the Products section on the official website for catalogue availability.', 'products', 0],

        // ---- facility ----
        ['What is OPF?', 'OPF refers to Ordnance Parachute Factory, Kanpur, a production unit of Gliders India Limited.', 'facility', 1],
        ['What does OPF manufacture?', 'OPF manufactures military parachutes, supply drop parachutes, pilot parachutes, brake parachutes, military equipment, floats, and inflatable boats.', 'facility', 0],
        ['What is your production unit?', 'The primary production unit is Ordnance Parachute Factory (OPF), Kanpur.', 'facility', 0],

        // ---- contact ----
        ['How can I contact GIL?', 'You can contact GIL via phone, email, or the contact form available on the official website.', 'contact', 1],
        ['Where is GIL located?', 'The corporate office is located at G.T. Road, DRDO, Kanpur - 208013, Uttar Pradesh, India.', 'contact', 0],
        ['What is your phone number?', 'You can contact GIL at +91 512 2984548 or +91 512 2988487.', 'contact', 0],
        ['What is your email address?', 'You can contact Gliders India Limited at corporate@glidersindia.in.', 'contact', 0],
        ['Is there a contact form?', 'Yes. The website provides a contact form where you can submit your name, email, phone number, and message.', 'contact', 0],
        ['How do I submit an enquiry?', 'Use the contact form on the official website or email corporate@glidersindia.in.', 'contact', 0],
        ['Can I visit your office?', 'Please contact GIL before planning a visit, as defence establishments may have access restrictions.', 'contact', 0],

        // ---- business ----
        ['Do you have tenders?', 'Yes. Tender and consortium-related notices are published on the website when available.', 'business', 1],
        ['How do I apply for jobs?', 'Recruitment notifications, if available, are published on the official website. Please check regularly.', 'business', 0],
        ['Can civilians buy products directly?', 'The website does not specify direct civilian purchasing. Please contact GIL for procurement-related inquiries.', 'business', 0],
        ['Do you export products?', 'Please contact the corporate office for information regarding exports and international business opportunities.', 'business', 0],
        ['Where can I find company news?', 'Recent updates and announcements are available in the What\'s New section of the official website.', 'business', 0],

        // ---- closing: answered with no follow-up options ----
        ['Thank you', 'You\'re welcome! Let me know if you need any further assistance.', 'closing', 0],
        ['Bye', 'Thank you for visiting Gliders India Limited. Have a great day!', 'closing', 0],
    ];

    public function up(): void
    {
        Schema::table('chatbot_faqs', function (Blueprint $table) {
            if (!Schema::hasColumn('chatbot_faqs', 'category')) {
                $table->string('category')->default('general')->after('answer');
            }
            if (!Schema::hasColumn('chatbot_faqs', 'is_starter')) {
                $table->boolean('is_starter')->default(false)->after('category');
            }
            if (!Schema::hasColumn('chatbot_faqs', 'position')) {
                $table->integer('position')->default(0)->after('is_starter');
            }
        });

        DB::table('chatbot_faqs')->delete();

        foreach (array_values($this->faqs) as $i => [$question, $answer, $category, $starter]) {
            DB::table('chatbot_faqs')->insert([
                'question' => $question,
                'answer' => $answer,
                'category' => $category,
                'is_starter' => (bool) $starter,
                'position' => $i + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('chatbot_faqs')->delete();

        Schema::table('chatbot_faqs', function (Blueprint $table) {
            foreach (['category', 'is_starter', 'position'] as $column) {
                if (Schema::hasColumn('chatbot_faqs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
