<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Seeds the Glide Bot knowledge base.
     *
     * ChatbotController runs five keyword handlers before it ever reaches this
     * table, and the widget sends a suggested question verbatim when it is
     * clicked. A question containing any of those trigger words - product,
     * parachute, make, contact, address, where, office, news, latest, leader,
     * cmd, message and so on - would therefore be answered by a handler and
     * never reach its own answer. These questions are deliberately worded to
     * avoid every trigger, including substring matches such as "officer"
     * containing "office", and to avoid sharing any word longer than three
     * characters with a product title, which handler two also matches on.
     */
    private array $faqs = [
        [
            'What is Gliders India Limited?',
            'Gliders India Limited (GIL) is a Government of India defence public sector undertaking based in Kanpur, Uttar Pradesh. It was formed in 2021 when the Ordnance Parachute Factory was corporatised, and it supplies parachute systems, inflatable craft and technical textiles to the armed forces.<br>There is more under <strong>About &rarr; History</strong>.',
        ],
        [
            'When did the Kanpur factory begin operations?',
            'The Ordnance Parachute Factory, Kanpur, has been in operation since 1941 &mdash; its recorded leadership begins with an Officer-in-Charge appointed on 01 October 1941. The full list of everyone who has headed the Factory since then is under <strong>About &rarr; Legacy</strong>.',
        ],
        [
            'How can I apply for a job at Gliders India Limited?',
            'Current openings and recruitment notifications are published on our <strong>Careers</strong> page. Each notification sets out the eligibility criteria, the closing date and how to submit an application.',
        ],
        [
            'Are internships available for students?',
            'Yes. Internship notifications are published alongside recruitment notices on the <strong>Careers</strong> page, with the discipline, duration and application process for each.',
        ],
        [
            'How do I register as a vendor or supplier?',
            'Registration requirements and the forms you need are on the <strong>Vendors</strong> page.',
        ],
        [
            'How can I find current tenders and EOI notices?',
            'Tenders and Expression of Interest notices are published in the <strong>Finance</strong> section, together with the closing dates for each.',
        ],
        [
            'How do I file an RTI application?',
            'The <strong>RTI</strong> section lists the designated authorities along with the procedure and fees prescribed under the Right to Information Act, 2005.',
        ],
        [
            'How can I submit a vigilance complaint?',
            'The <strong>Vigilance</strong> section carries the Chief Vigilance Officer&rsquo;s details, the procedure for lodging a complaint, and the manuals and policies that govern the process.',
        ],
        [
            'Is the website available in Hindi?',
            'Yes. The <strong>Rajbhasha</strong> section carries Hindi content including the Niyam Pustak and Rajbhasha rules, and a language selector in the header translates the rest of the site.',
        ],
        [
            'What accessibility features does the website provide?',
            'An accessibility toolbar is available on every page, and the header carries text-size controls, so you can adjust the display to suit your needs.',
        ],
    ];

    public function up(): void
    {
        // Placeholder rows left over from testing; they surface in the widget
        // as clickable suggestions labelled "hello".
        DB::table('chatbot_faqs')->where('question', 'hello')->delete();

        foreach ($this->faqs as [$question, $answer]) {
            DB::table('chatbot_faqs')->where('question', $question)->delete();

            DB::table('chatbot_faqs')->insert([
                'question' => $question,
                'answer' => $answer,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        foreach ($this->faqs as [$question]) {
            DB::table('chatbot_faqs')->where('question', $question)->delete();
        }
    }
};
