{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        // earnings
        Livewire.on('openAdditionalEarningsModal', (el, component) => {
            modalObject.openModal('modalAdditionalEarnings'); 
        });
        Livewire.on('closeAdditionalEarningsModal', (el, component) => {
            modalObject.closeModal('modalAdditionalEarnings'); 
        });
        
        // deductions
        Livewire.on('openAdditionalDeductionsModal', (el, component) => {
            modalObject.openModal('modalAdditionalDeductions'); 
        });
        Livewire.on('closeAdditionalDeductionsModal', (el, component) => {
            modalObject.closeModal('modalAdditionalDeductions'); 
        });

    });
    // 

    window.onbeforeunload = function () {
        return 'Save important data before loading';
    }

</script>