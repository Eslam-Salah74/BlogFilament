<?php

namespace App\Filament\Resources\WidgetResource\Widgets;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsDashboardtOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // User Widget
            Stat::make(__('All Users'), User::all()->count())
                    ->description( User::all()->count().' '.__('increase'))
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->chart([7, 2, 10, 3, 15, 4, 17])
                    ->color('success'),

            // Category Widget
            Stat::make(__('All Category'), Category::all()->count())
                    ->description( Category::all()->count().' '.__('increase'))
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->chart([7, 2, 10, 3, 15, 4, 17])
                    ->color('success'),
             
            // Post Widget
            Stat::make(__('All Post'), Post::all()->count())
                    ->description( Post::all()->count().' '.__('increase'))
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

            // Comments Widget
            Stat::make(__('All Comments'), Comment::all()->count())
                    ->description( Comment::all()->count().' '.__('increase'))
                    ->descriptionIcon('heroicon-m-arrow-trending-up')
                    ->chart([7, 2, 10, 3, 15, 4, 17])
                    ->color('success'),
        ];
    }
}
