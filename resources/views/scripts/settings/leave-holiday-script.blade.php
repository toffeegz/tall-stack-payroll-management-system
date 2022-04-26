{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openAddHolidayModal', (el, component) => {
            modalObject.openModal('modalAddHoliday'); 
        });
        Livewire.on('closeAddHolidayModal', (el, component) => {
            modalObject.closeModal('modalAddHoliday'); 
        });

        Livewire.on('openEditHolidayModal', (el, component) => {
            modalObject.openModal('modalEditHoliday'); 
        });
        Livewire.on('closeEditHolidayModal', (el, component) => {
            modalObject.closeModal('modalEditHoliday'); 
        });



        Livewire.on('openAddLeaveTypeModal', (el, component) => {
            
            modalObject.openModal('modalAddLeaveType'); 
        });
        Livewire.on('closeAddLeaveTypeModal', (el, component) => {
            modalObject.closeModal('modalAddLeaveType'); 
        });

        Livewire.on('openEditLeaveTypeModal', (el, component) => {
            
            modalObject.openModal('modalEditLeaveType'); 
        });
        Livewire.on('closeEditLeaveTypeModal', (el, component) => {
            modalObject.closeModal('modalEditLeaveType'); 
        });



    });
    // 

    


</script>