{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openAddHolidayModal', (el, component) => {
            modalObject.openModal('modalAddHoliday'); 
        });
        Livewire.on('closeAddHolidayModal', (el, component) => {
            modalObject.closeModal('modalAddHoliday'); 
        });



        Livewire.on('openAddLeaveTypeModal', (el, component) => {
            
            modalObject.openModal('modalAddLeaveType'); 
        });
        Livewire.on('closeAddLeaveTypeModal', (el, component) => {
            modalObject.closeModal('modalAddLeaveType'); 
        });


    });
    // 

    


</script>