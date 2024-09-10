<?php

namespace App\Filament\Resources\WidgetResource\Widgets;


use App\Models\Comment;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class CommentsChart extends ChartWidget
{
    protected static ?string $heading = null;
    protected static string $color = 'success';

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $data = Trend::model(Comment::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();
 
        return [
            
            'datasets' => [
                [
                    'label' => __('Comments'),
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => __('Today'),
            'week' => __('Last week'),
            'month' => __('Last month'),
            'year' => __('This year'),
        ];
    }

    public function __construct()
    {
        self::$heading = __('Comments'); // تعيين الترجمة هنا
    }
}
