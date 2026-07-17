<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceReport extends Model
{
    protected $table = 'finance_reports';

    protected $fillable = [
        'heading',
        'description',
        'display_order'
    ];

    public function files()
    {
        return $this->hasMany(FinanceReportFile::class, 'report_id');
    }
}