{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        // total hours
        Livewire.on('openTotalHoursModal', (el, component) => {
            modalObject.openModal('modalTotalHours'); 
        });
        Livewire.on('closeTotalHoursModal', (el, component) => {
            modalObject.closeModal('modalTotalHours'); 
        });

        // earnings
        Livewire.on('openAdditionalEarningsModal', (el, component) => {
            modalObject.openModal('modalAdditionalEarnings'); 
        });
        Livewire.on('closeAdditionalEarningsModal', (el, component) => {
            modalObject.closeModal('modalAdditionalEarnings'); 
        });
        
        // deductions
        Livewire.on('openDeductionsModal', (el, component) => {
            modalObject.openModal('modalDeductions'); 
        });
        Livewire.on('closeDeductionsModal', (el, component) => {
            modalObject.closeModal('modalDeductions'); 
        });

    });
    // 

</script>