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

        Livewire.on('openNotifModal', (el, component) => {
            modalObject.openModal('modalNotif'); 
        });
        Livewire.on('closeNotifModal', (el, component) => {
            modalObject.closeModal('modalNotif'); 
        });
        

    });
    // 

</script>