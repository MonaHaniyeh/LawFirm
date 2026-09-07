<?php

if (! function_exists('badge')) {
    /**
     * Render a colored status badge.
     */
    function badge(?string $status): string
    {
        $status = $status ?? 'unknown';

        $colors = [
            'active'    => 'bg-green-100 text-green-800',
            'pending'   => 'bg-yellow-100 text-yellow-800',
            'closed'    => 'bg-gray-100 text-gray-700',
            'cancelled' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800',
        ];

        $classes = $colors[strtolower($status)] ?? 'bg-gray-100 text-gray-700';

        return '<span class="inline-block px-2 py-1 rounded-full text-xs font-medium ' . $classes . '">'
            . e(ucfirst($status))
            . '</span>';
    }
}
