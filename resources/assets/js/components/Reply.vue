<template>
    <div class="panel-heading">
        <div :id="'reply-'+id" class="level">
            <h5 class="flex">
                <a :href="'/profiles/'+ data.owner.name"
                    v-text="data.owner.name">
                    </a>,
                <span v-text="ago"></span>
            </h5>

            <div>

            </div>
            <div v-if="signedIn">
                <favorite :reply="data"></favorite>
            </div>
        </div>

        <div class="panel-footer">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-xs btn-success" @click="update">Potrdi</button>
                <button class="btn btn-xs btn-default" @click="editing = false">Prekliči</button>
            </div>
            <div v-else v-text="body"></div>
        </div>


        <!-- @can('delete', $reply) -->
        <div class="panel-content level">
            <button class="btn btn-link btn-sm" v-if="canUpdate" @click="editing = true">
                Uredi
                <span class="glyphicon glyphicon-pencil"></span>
            </button>
        </div>
            <button class="btn btn-link btn-sm mr-1" v-if="canDelete|canUpdate" @click="destroy">
                Odstrani komentar
                <span class="glyphicon glyphicon-trash"></span>
            </button>

        <!--  @endcan> -->
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment-timezone';

    export default {
        props: ['data'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,

            };
        },
        computed: {
            ago() {
                moment.locale('sl');
                return moment(this.data.created_at).fromNow();
            },

            signedIn() {
                return window.Laravel.signedIn;
            },

            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id)
            },

            canDelete() {
                return this.authorize(user => this.data.thread.creator.id == user.id)
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                });
                this.editing = false;

                flash('Komentar je bil posodobljen.')
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);
                //child makes an event for parent to react in Replies.vue

                this.$emit('deleted', this.data.id);
                /*$(this.$el).fadeOut(300, () => {
                flash('deleted')}); */
            }
        }
    }
</script>