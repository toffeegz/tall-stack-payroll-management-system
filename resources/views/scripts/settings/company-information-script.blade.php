{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openEditCompanyInformationModal', (el, component) => {
            modalObject.openModal('modalEditCompanyInformation'); 
        });
        Livewire.on('closeEditCompanyInformationModal', (el, component) => {
            modalObject.closeModal('modalEditCompanyInformation'); 
        });


    });
    // 


</script>