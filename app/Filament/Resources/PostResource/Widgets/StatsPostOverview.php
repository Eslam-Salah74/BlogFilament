<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Post;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsPostOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('All Post'), Post::all()->count())
            ->description( Post::all()->count().' '. __('increase'))
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Stat::make(__('Published'), Post::where('is_published',true)->count())
            ->description(__('Published'))
            // ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Stat::make(__('Draft'), Post::where('is_published',false)->count())
            ->description(__('Draft'))
            // ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('danger'),
        ];
    }
}
