@php
    $user = auth()->user();
    $name = $user->name ?? '';
    $title = $user->title ? " ({$user->title})" : '';
    $institution = $user->institution ? " - {$user->institution}" : '';
@endphp

<div class="fi-fo-field-wrp">
    <div class="rounded-lg bg-gray-50 dark:bg-gray-800 p-4 border border-gray-200 dark:border-gray-700">
        <div class="text-sm font-medium text-gray-900 dark:text-white">
            {{ $name }}{{ $title }}{{ $institution }}
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            ℹ️ Informasi penulis diambil dari profile Anda. Update di menu "Profile Saya" untuk mengubah.
        </div>
    </div>
</div>
