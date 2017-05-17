<template>
    <div class="alert alert-success alert-flash" v-show="show" role="alert">
      <strong>{{ body }}</strong>
    </div>
</template>

<script>
    export default {
        //properties that we accept from view (in flash we have message="začasno sporočilo")
        props: ['message'],

        data() {
            return {
                body: '',
                show:false
            }
        },

        //if msg is set in session, set it into <flash> and make it visible
        created() {
            if(this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => {
               this.flash(message);
            });
        },

        //helper methods
        methods: {
            flash(message) {
                this.body = message;
                this.show = true;
                //hide it after that
                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
            }, 3000);
            }
        }
    }
</script>

<style>
.alert-flash {
    position: fixed;
    right: 25px;
    bottom: 25px;
     }
</style>