{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openPayLoanModal', (el, component) => {
            modalObject.openModal('modalPayLoan'); 
        });
        Livewire.on('closePayLoanModal', (el, component) => {
            modalObject.closeModal('modalPayLoan'); 
        });

        Livewire.on('openLoanDetailsModal', (el, component) => {
            modalObject.openModal('modalLoanDetails'); 
        });
        Livewire.on('closeLoanDetailsModal', (el, component) => {
            modalObject.closeModal('modalLoanDetails'); 
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