{{-- livewire modal script --}}
<script>

    document.addEventListener('livewire:load', function () {

        // total hours
        Livewire.on('openEditTaxContributionsModal', (el, component) => {
            modalObject.openModal('modalEditTaxContributions'); 
        });
        Livewire.on('closeEditTaxContributionsModal', (el, component) => {
            modalObject.closeModal('modalEditTaxContributions'); 
        });


    });
    // 

    window.onbeforeunload = function () {
        return 'Save important data before loading';
    }

</script>