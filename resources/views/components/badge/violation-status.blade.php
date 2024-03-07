<x-badge value="{{ $status }}" :options="[
    (object) [
        'type' => 'primary',
        'value' => \App\Constants\ViolationStatus::PENDING,
    ],
    (object) [
        'type' => 'success',
        'value' => \App\Constants\ViolationStatus::RESOLVED,
    ],
    (object) [
        'type' => 'warning',
        'value' => \App\Constants\ViolationStatus::SUSPENDED,
    ],
    (object) [
        'type' => 'secondary',
        'value' => \App\Constants\ViolationStatus::INVESTIGATING,
    ],
]" />
