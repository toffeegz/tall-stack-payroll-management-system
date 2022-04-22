{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openLoanDetailsModal', (el, component) => {
            modalObject.openModal('modalLoanDetails'); 
        });
        Livewire.on('closeLoanDetailsModal', (el, component) => {
            modalObject.closeModal('modalLoanDetails'); 
        });

        Livewire.on('openGrantLoanModal', (el, component) => {
            modalObject.openModal('modalGrantLoan'); 
        });
        Livewire.on('closeGrantLoanModal', (el, component) => {
            modalObject.closeModal('modalGrantLoan'); 
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