{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openAddUsersModal', (el, component) => {
            modalObject.openModal('modalAddUsers'); 
        });
        Livewire.on('closeAddUsersModal', (el, component) => {
            modalObject.closeModal('modalAddUsers'); 
        });

        Livewire.on('openRemoveUsersModal', (el, component) => {
            modalObject.openModal('modalRemoveUsers'); 
        });
        Livewire.on('closeRemoveUsersModal', (el, component) => {
            modalObject.closeModal('modalRemoveUsers'); 
        });

        Livewire.on('openDeleteProjectModal', (el, component) => {
            modalObject.openModal('modalDeleteProject'); 
        });
        Livewire.on('closeDeleteProjectModal', (el, component) => {
            modalObject.closeModal('modalDeleteProject'); 
        });

        Livewire.on('openUpdateProjectModal', (el, component) => {
            modalObject.openModal('modalUpdateProject'); 
        });
        Livewire.on('closeUpdateProjectModal', (el, component) => {
            modalObject.closeModal('modalUpdateProject'); 
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