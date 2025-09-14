<?php

namespace App\Services\Client;

use App\Consts\TransactionConst;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class HomeService
{
    public function getDashboardCharts(int|string $userId): array
    {
        $monthlySummary = Transaction::query()
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                'transaction_type',
                DB::raw('SUM(amount) as total')
            )
            ->where('user_id', $userId)
            ->whereYear('created_at', '>=', now()->subYear()->year)
            ->groupBy('year', 'month', 'transaction_type')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->groupBy(fn($row) => $row->year . '-' . str_pad($row->month, 2, '0', STR_PAD_LEFT));

        $monthlyData = [];
        foreach (range(1, 12) as $i) {
            $dateKey = now()->subMonths(12 - $i)->format('Y-m');
            $data = $monthlySummary[$dateKey] ?? collect();

            $monthlyData[] = [
                'month'   => $dateKey,
                'income'  => $data->firstWhere('transaction_type', TransactionConst::INCOME)->total ?? 0,
                'expense' => $data->firstWhere('transaction_type', TransactionConst::EXPENSE)->total ?? 0,
            ];
        }

        $categorySummary = Transaction::query()
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->where('user_id', $userId)
            ->where('transaction_type', TransactionConst::EXPENSE)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->groupBy('category_id')
            ->get()
            ->map(function ($row) {
                $category = Category::find($row->category_id);
                return [
                    'category_id'   => $row->category_id,
                    'category_name' => $category?->name ?? 'Khác',
                    'total'         => $row->total,
                ];
            });

        return [
            'monthly_summary'   => $monthlyData,
            'category_summary'  => $categorySummary
        ];
    }
}
