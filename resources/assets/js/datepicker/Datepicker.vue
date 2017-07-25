<template>
    <div>
        <div class="datepicker-from">
            <strong>Od:</strong>
            <datepicker language="sl-si" :format="format" id="dateFrom" name="dateFrom" :value="state.date1"></datepicker>


        </div>
        <div class="datepicker-to">
            <strong>Do:</strong>
                <datepicker language="sl-si" :format="format" name="dateTo" :value="state.date2"></datepicker>

        </div>
    </div>
</template>


<script>
    import Datepicker from 'vuejs-datepicker'

    var state = {
        date1: new Date(2017, 5, 1),
        date2: new Date()
    }

    export default {
        props: ['data'],

        components: {
            Datepicker
        },
        data () {
            return {
                format: 'yyyy-MM-dd', // 2017-06-17
                disabled: {},
                eventMsg: null,
                state: state,
                bootstrapStyling: true
            }
        }
    }
</script>

<style>


</style>