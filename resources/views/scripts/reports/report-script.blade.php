{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openNotifModal', (el, component) => {
            modalObject.openModal('modalNotif'); 
        });
        Livewire.on('closeNotifModal', (el, component) => {
            modalObject.closeModal('modalNotif'); 
        });

        Livewire.on('openTaxContributionModal', (el, component) => {
            modalObject.openModal('modalTaxContribution'); 
        });
        Livewire.on('closeTaxContributionModal', (el, component) => {
            modalObject.closeModal('modalTaxContribution'); 
        });

        Livewire.on('openLoanModal', (el, component) => {
            modalObject.openModal('modalLoan'); 
        });
        Livewire.on('closeLoanModal', (el, component) => {
            modalObject.closeModal('modalLoan'); 
        });

    });
    // 


</script>