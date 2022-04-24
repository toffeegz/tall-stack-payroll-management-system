{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openNewProjectModal', (el, component) => {
            modalObject.openModal('modalNewProject'); 
        });
        Livewire.on('closeNewProjectModal', (el, component) => {
            modalObject.closeModal('modalNewProject'); 
        });

        Livewire.on('openNotifModal', (el, component) => {
            modalObject.openModal('modalNotif'); 
        });
        Livewire.on('closeNotifModal', (el, component) => {
            modalObject.closeModal('modalNotif'); 
        });
        

    });
    // 

</script>