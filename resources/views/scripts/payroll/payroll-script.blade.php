{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        // total hours
        Livewire.on('openPreviousPayrollModal', (el, component) => {
            modalObject.openModal('modalPreviousPayroll'); 
        });
        Livewire.on('closePreviousPayrollModal', (el, component) => {
            modalObject.closeModal('modalPreviousPayroll'); 
        });
    });
    // 


</script>