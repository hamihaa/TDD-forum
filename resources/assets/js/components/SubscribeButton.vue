<template>
    <div>
        <button :class="classes" @click="subscribe" v-text="msg"></button>
    </div>
</template>

<script>
    export default {
        props: ['active'],


        computed: {
            msg() {
                return this.active ? 'Odjavi se' : 'Naroči se na objavo';
            },

            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            }
        },

        methods: {
            subscribe() {
                axios[
                        this.active ? 'delete' : 'post'
                        ](location.pathname + '/subscriptions');
                this.active = ! this.active;
            }
        }
    }
</script>

<style>

</style>