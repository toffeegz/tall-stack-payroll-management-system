{{-- livewire modal script --}}
@section('page-script')
<script>

    document.addEventListener('livewire:load', function () {

        Livewire.on('openNotifModal', (el, component) => {
            modalObject.openModal('modalNotif'); 
        });
        Livewire.on('closeNotifModal', (el, component) => {
            modalObject.closeModal('modalNotif'); 
        });
    });
    // 
    function selectDesignation($value)
    {
        var str_id = 'radio_designation_' + $value;
        // $("#"+str_id).attr('checked', 'checked');
        document.getElementById(str_id).checked = true;
        console.log($("#"+str_id).val());
    }  

</script>
@endsection

@section('page-style')
<style>
    input.designationradio:checked + label {
        border-color: rgb(4, 127, 184);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(4, 127, 184, 0.05);
    }

</style>
@endsection