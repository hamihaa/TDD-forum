<template>
    <div>
        <div v-if="signedIn">
        <div class="panel-heading">Dodaj komentar</div>
               <div class="form-group">
                    <textarea class="form-control"
                              name="body"
                              id="body"
                              rows="3"
                              placeholder="Vsebina komentarja..."
                              v-model='body'
                              required>
                    </textarea>
            </div>

          <div class="form-group">
                <button type="submit"
                        class="btn btn-primary"
                        @click="addReply">
                    Objavi
                </button>
            </div>
        </div>
        <div v-else>
            <p>Za komentiranje se je potrebno <a href="/login"> prijaviti.</a></p>
        </div>
    </div>

</template>


<script>
    export default {

        data() {
            return {
                body: ''
            }
        },

        computed: {
            signedIn() {
                return window.Laravel.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies'
                        , {body: this.body})
                        .then(response => {
                            this.body = '';

                            flash('Objva uspešno dodana.');

                            this.$emit('created', response.data);

                        });
            }
        }
    }
</script>