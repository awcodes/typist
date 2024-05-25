@props([
    'color' => null,
    'dismissible' => false,
    'message' => null
])

<div
    @class([
      'border-l-4 p-4 flex items-center gap-3 not-prose',
      match($color) {
        'success' => 'bg-success-200 text-success-900 border-success-600',
        'danger' => 'bg-danger-200 text-danger-900 border-danger-600',
        'warning' => 'bg-warning-200 text-warning-900 border-warning-600',
        default => 'bg-info-200 text-info-900 border-info-600',
      }
    ])
>
    @php
        $icon = match($color) {
            'success' => 'heroicon-o-check-circle',
            'danger' => 'heroicon-o-exclamation-circle',
            'warning' => 'heroicon-o-exclamation-triangle',
            default => 'heroicon-o-information-circle',
        };
    @endphp

    @svg($icon, 'h-6 w-6')

    <p>{{ $message }}</p>
</div>
