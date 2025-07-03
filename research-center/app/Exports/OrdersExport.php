<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\ResearchData;
use App\Models\Event;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $rows = [];

        $orders = Order::with('user')->latest()->get();

        foreach ($orders as $order) {
            $itemTypes = json_decode($order->item_type, true) ?? [];
            $itemIds = json_decode($order->item_id, true) ?? [];
            $prices = json_decode($order->totalprice, true) ?? [];

            $typeNames = [];
            $itemNames = [];

            foreach ($itemTypes as $i => $type) {
                $id = $itemIds[$i] ?? null;
                $typeNames[] = $type === 'research_data' ? 'Dataset' : 'Event';

                if ($type === 'research_data') {
                    $dataset = ResearchData::find($id);
                    $itemNames[] = $dataset ? $dataset->research_title : 'Dataset #' . $id;
                } elseif ($type === 'event') {
                    $event = Event::find($id);
                    $itemNames[] = $event ? $event->name : 'Event #' . $id;
                } else {
                    $itemNames[] = 'Item #' . $id;
                }
            }

            $total = array_sum($prices);

            $rows[] = [
                'ID'         => $order->id,
                'Nama'       => $order->nama ?? ($order->user->name ?? '-'),
                'Email'      => $order->user->email ?? '-',
                'Jenis Item' => implode(', ', $typeNames),
                'Item'       => implode(', ', $itemNames),
                'Status'     => ucfirst($order->status),
                'Tanggal'    => $order->created_at->format('d-m-Y'),
                'Total'      => $total,
            ];
        }

        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'Jenis Item',
            'Item',
            'Status',
            'Tanggal',
            'Total',
        ];
    }
}


