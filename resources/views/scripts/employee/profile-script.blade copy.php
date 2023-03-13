{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openPersonalInformationModal', (el, component) => {
            modalObject.openModal('modalPersonalInformation'); 
        });
        Livewire.on('closePersonalInformationModal', (el, component) => {
            modalObject.closeModal('modalPersonalInformation'); 
        });


        Livewire.on('openEmploymentDetailsModal', (el, component) => {
            modalObject.openModal('modalEmploymentDetails'); 
        });
        Livewire.on('closeEmploymentDetailsModal', (el, component) => {
            modalObject.closeModal('modalEmploymentDetails'); 
        });

        Livewire.on('openCompensationModal', (el, component) => {
            modalObject.openModal('modalCompensation'); 
        });
        Livewire.on('closeCompensationModal', (el, component) => {
            modalObject.closeModal('modalCompensation'); 
        });


        

    });
    // 


</script>