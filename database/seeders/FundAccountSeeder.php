<?php

namespace Database\Seeders;

use App\Models\FundAccount;
use Illuminate\Database\Seeder;

class FundAccountSeeder extends Seeder
{
    /**
     * fund_accounts ليس عليه school_id (سجل خزينة عام)، فيُعاد إنشاؤه من الصفر دون أي تصفية.
     */
    public function run(): void
    {
        FundAccount::query()->delete();

        FundAccount::create([
            'date' => now()->subDays(15)->toDateString(),
            'Debit' => 5000,
            'description' => 'إيداع نقدي في الخزينة',
        ]);

        FundAccount::create([
            'date' => now()->subDays(5)->toDateString(),
            'credit' => 1200,
            'description' => 'مصروفات تشغيلية',
        ]);
    }
}
