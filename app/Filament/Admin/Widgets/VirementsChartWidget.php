<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Virement;
use Illuminate\Support\Facades\DB;

class VirementsChartWidget extends ChartWidget
{
    protected ?string $heading = 'Virements par type';

    protected function getData(): array
    {
        $data = Virement::select('type', DB::raw('SUM(montant) as total'))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();

        return [
            'labels' => array_keys($data),
            'datasets' => [
                [
                    'label' => 'Montant total des virements',
                    'data' => array_values($data),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
