{{-- livewire modal script --}}
@section('page-script')
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openInputEmploymentModal', (el, component) => {
            modalObject.openModal('modalInputEmployment'); 
        });
        Livewire.on('closeInputEmploymentModal', (el, component) => {
            modalObject.closeModal('modalInputEmployment'); 
        });

    });
    // 


</script>
@endsection