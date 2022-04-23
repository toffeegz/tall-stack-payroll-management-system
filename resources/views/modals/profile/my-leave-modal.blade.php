
{{-- modal notif hours --}}
<x-modal-small id="modalNotif" title="Success" wire:ignore.self>
    {{-- modal body --}}
    <div class="text-center p-5 flex-auto justify-center">
        <x-notification.success title="Great!">
            Your request has been submitted
        </x-notification.success>
    </div>
    {{-- end modal body --}}
    {{-- modal footer --}}
    {{-- end modal footer --}}
</x-modal-small>
{{--  --}}