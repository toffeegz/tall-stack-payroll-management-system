{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openNotifModal', (el, component) => {
            modalObject.openModal('modalNotif'); 
        });
        Livewire.on('closeNotifModal', (el, component) => {
            modalObject.closeModal('modalNotif'); 
        });
        
        Livewire.on('openLeaveDetailsModal', (el, component) => {
            modalObject.openModal('modalLeaveDetails'); 
        });
        Livewire.on('closeLeaveDetailsModal', (el, component) => {
            modalObject.closeModal('modalLeaveDetails'); 
        });
        Livewire.on('openDownloadModal', (el, component) => {
            modalObject.openModal('modalDownload'); 
        });
        Livewire.on('closeDownloadModal', (el, component) => {
            modalObject.closeModal('modalDownload'); 
        });
        

    });
    // 

</script>