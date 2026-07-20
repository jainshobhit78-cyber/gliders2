<?php

namespace Database\Seeders;

use App\Models\AboutLeadership;
use App\Models\LeadershipMilestone;
use Illuminate\Database\Seeder;

/**
 * Populates the Director (Finance) profile and milestones from the official
 * "DF Profile and Milestone" brief. Idempotent — safe to run more than once:
 * the leader is matched by role and milestones by heading.
 */
class DirectorFinanceProfileSeeder extends Seeder
{
    public function run(): void
    {
        $leader = AboutLeadership::whereRaw("LOWER(TRIM(role)) LIKE ?", ['%director%finance%'])->first();

        if (! $leader) {
            $this->command?->warn('Director (Finance) leadership record not found — nothing to update.');
            return;
        }

        $leader->leader_name = 'Shri Siba Prasad Patnaik';
        $leader->bio = $this->bio();
        $leader->save();

        // Refresh the current-role milestone if it already exists.
        $current = LeadershipMilestone::where('leadership_id', $leader->id)
            ->where(function ($q) {
                $q->where('heading', 'like', '%Director (Finance)%')
                  ->orWhere('heading', 'like', '%CFO%');
            })->first();

        if ($current) {
            $current->heading = 'Director (Finance) & CFO, Gliders India Limited';
            $current->description = $this->currentRoleDescription();
            $current->save();
        }

        foreach ($this->milestones() as $row) {
            $existing = LeadershipMilestone::where('leadership_id', $leader->id)
                ->where('heading', $row['heading'])
                ->first();

            $milestone = $existing ?: new LeadershipMilestone();
            $milestone->leadership_id = $leader->id;
            $milestone->heading = $row['heading'];
            $milestone->start_date = $row['start_date'];
            $milestone->end_date = $row['end_date'];
            $milestone->description = $row['description'];
            $milestone->save();
        }

        $this->command?->info('Director (Finance) profile and milestones synced.');
    }

    private function bio(): string
    {
        return <<<'HTML'
<p class="text-justify mt-3 me-2 ms-5"><strong>Current Role:</strong> Shri Siba Prasad Patnaik is the Director (Finance) &amp; Chief Financial Officer (CFO) of Gliders India Limited (GIL), a premier Defence Public Sector Undertaking (PSU) under the Ministry of Defence.</p>
<div class="text-justify mt-3 me-2 ms-5">
<p class="text-justify"><strong>Educational Background:</strong> He holds a Master of Commerce in Finance (M.Com), is a qualified Corporate Management Accountant (CMA), and possesses a Post Graduate Diploma in Personnel Management (PGDPM) alongside an L.L.B. degree.</p>
<p class="text-justify"><strong>Industry Experience:</strong> A seasoned executive with over three decades of diversified financial experience across core industries, including Power (Thermal, Hydro, Solar, Wind, and Pumped Storage), Coal Mining, Steel, and Defence Production.</p>
<p class="text-justify"><strong>Career Trajectory:</strong> Prior to joining GIL, he built a distinguished career spanning public and private enterprises, including leadership roles at Jindal Steel &amp; Power Limited, THDC India Limited, and NLC India Limited (a Navratna CPSE), where he served as Chief General Manager (Finance).</p>
<p class="text-justify"><strong>Core Competencies:</strong> His key functional competencies lie in Treasury &amp; Fund Management, Corporate Accounts &amp; Costing, Project Finance &amp; Financial Closure, Strategic Contract Management, Investor Relations, Corporate Governance, and statutory compliance.</p>
</div>
HTML;
    }

    private function currentRoleDescription(): string
    {
        return <<<'HTML'
<p>Appointed Director (Finance) &amp; Chief Financial Officer of Gliders India Limited, overseeing treasury, corporate accounts, compliance and investment strategy.</p>
<ul>
<li><strong>September 2024:</strong> Formally recommended for the top financial post at Gliders India Limited by the Public Enterprises Selection Board (PESB).</li>
<li><strong>March 2025:</strong> Received official appointment approval from the Appointments Committee of the Cabinet (ACC) to serve as Director (Finance) of GIL until his superannuation on June 30, 2029.</li>
<li><strong>April 2025:</strong> Assumed formal charge as Director (Finance) &amp; CFO at Gliders India Limited.</li>
</ul>
HTML;
    }

    private function milestones(): array
    {
        return [
            [
                'heading' => 'Treasury & Financing Excellence',
                'start_date' => '2017-01-01',
                'end_date' => '2025-12-31',
                'description' => <<<'HTML'
<ul>
<li><strong>Large-scale Debt Refinancing:</strong> Led a major refinancing initiative for a ₹12,531 crore loan at NUPPL (a joint venture of NLC India), negotiating a rate reduction from 11% to 8.75% p.a. to achieve substantial interest cost savings.</li>
<li><strong>Capital Mobilisation:</strong> Successfully orchestrated financial closures aggregating more than ₹17,200 crore between 2017 and 2025 utilizing mixed instruments like bonds and rupee term loans.</li>
<li><strong>Credit Rating Sustenance:</strong> Maintained NLC India&rsquo;s highest &ldquo;AAA (Stable)&rdquo; credit rating for more than seven consecutive years via strategic stakeholder and credit agency interactions.</li>
<li><strong>Bank Guarantee Optimisation:</strong> Successfully renegotiated bank guarantee commission rates down from 0.34% to 0.12% p.a., generating ₹2.35 crore in recurring annual savings.</li>
</ul>
HTML,
            ],
            [
                'heading' => 'Working Capital & Governance Improvements',
                'start_date' => null,
                'end_date' => null,
                'description' => <<<'HTML'
<ul>
<li><strong>Debtor Liquidity:</strong> Introduced a Sales Bill Discounting mechanism that successfully halved outstanding receivables from ~₹9,000 crore to ~₹4,500 crore.</li>
<li><strong>Short-Term Funding Shifts:</strong> Transitioned conventional cash credit facilities toward Commercial Papers (CPs) and optimized short-term instruments, yielding savings of roughly ₹170 crore.</li>
<li><strong>Early ESG Integration:</strong> Spearheaded the early deployment of ESG (Environmental, Social, and Governance) Reporting at NLC India during FY 2021-22 ahead of legislative mandates.</li>
<li><strong>Digital &amp; ERP Transformations:</strong> Directed the implementation of ERP Fixed Assets and Banking Modules at THDC India Limited, successfully introducing asset componentisation ahead of statutory Ind AS requirements.</li>
<li><strong>GIL Financial Frameworks:</strong> Strengthened Internal Financial Controls (IFC), compliance, and product costing at Gliders India Limited, playing a definitive role in international export price fixation to expand profitability.</li>
</ul>
HTML,
            ],
            [
                'heading' => 'Employee Welfare Initiatives',
                'start_date' => null,
                'end_date' => null,
                'description' => <<<'HTML'
<ul>
<li><strong>Corporate NPS Migration:</strong> Led the barrier-free migration of employee pension funds to the National Pension System (NPS), safely moving an initial batch of ₹96 crore for 661 employees while securing a complete waiver on the 2% withdrawal charges.</li>
<li><strong>GIL Salary Benefits:</strong> Formulated and introduced an upgraded, best-in-class Corporate Salary Package for Gliders India Limited employees at zero additional cost to either the workforce or the enterprise.</li>
</ul>
HTML,
            ],
            [
                'heading' => 'Institutional & Social Contributions',
                'start_date' => '2013-01-01',
                'end_date' => '2026-12-31',
                'description' => <<<'HTML'
<ul>
<li><strong>Disaster &amp; Emergency Service:</strong> Provided on-the-ground volunteer assistance during the 2013 Kedarnath flood crisis and served as an active panel member on the Standing Committee for Emergency Procurements during the COVID-19 pandemic.</li>
<li><strong>Academic Administration:</strong> Served for over five years as the Honorary Treasurer of the Jawahar Education Society in Neyveli, managing the financial operations of institutions catering to 10,000+ students and 500+ staff members.</li>
<li><strong>Thought Leadership:</strong> Co-authored the research paper &ldquo;Greenfield Projects in India &ndash; An Effort Driving Sustainable Development&rdquo; (published in 2026) and was featured in an exclusive interview for the October 2025 issue of The Management Accountant magazine.</li>
</ul>
HTML,
            ],
            [
                'heading' => 'Major Awards & Recognition',
                'start_date' => '2022-01-01',
                'end_date' => '2026-12-31',
                'description' => <<<'HTML'
<ul>
<li><strong>CFO of the Year Award (2026):</strong> Conferred by Indian Achievers Forum in recognition of exceptional professional excellence and transformative contributions to India&rsquo;s Viksit Bharat @2047 vision through comprehensive socio-economic development.</li>
<li><strong>NLC Excel Award (2022):</strong> Conferred in recognition of outstanding performance, innovation, and cost control improvements in Treasury &amp; Working Capital Optimization.</li>
<li><strong>Management Commendations:</strong> Received multiple official expressions of appreciation from corporate boards for landmark refinancing deals, banking charge reductions, and employee welfare fund transitions.</li>
</ul>
HTML,
            ],
        ];
    }
}
