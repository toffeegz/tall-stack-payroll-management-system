{{-- livewire modal script --}}
@section('page-script')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('openNotifModal', (el, component) => {
            modalObject.openModal('modalNotif');
        });
    });
    // 
</script>
@endsection