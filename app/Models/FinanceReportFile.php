<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceReportFile extends Model
{
    protected $table = 'finance_report_files';

    protected $fillable = [
        'report_id',
        'pdf'
    ];

    public function report()
    {
        return $this->belongsTo(FinanceReport::class, 'report_id');
    }
}