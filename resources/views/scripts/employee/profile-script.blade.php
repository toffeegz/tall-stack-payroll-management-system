{{-- livewire modal script --}}
@section('page-script')
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openPersonalInformationModal', (el, component) => {
            modalObject.openModal('modalPersonalInformation'); 
        });
        Livewire.on('closePersonalInformationModal', (el, component) => {
            modalObject.closeModal('modalPersonalInformation'); 
        });

    });
    // 


</script>
@endsection