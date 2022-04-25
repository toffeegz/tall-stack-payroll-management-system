{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {
        Livewire.on('closeAddAttendanceModal', (el, component) => {
            modalObject.closeModal('modalAddAttendance'); 
        });
        Livewire.on('closeApproveAttendanceModal', (el, component) => {
            modalObject.closeModal('modalApproveAttendance'); 
        });
        Livewire.on('closeAttendanceDetailsModal', (el, component) => {
            modalObject.closeModal('modalAttendanceDetails'); 
        });
        Livewire.on('openNotifModal', (el, component) => {
            modalObject.openModal('modalNotif');
        });
        Livewire.on('openAttendanceDetailsModal', (el, component) => {
            modalObject.openModal('modalAttendanceDetails');
        });
        

    });
    // 

</script>