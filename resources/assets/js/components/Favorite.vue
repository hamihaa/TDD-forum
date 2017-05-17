<template>

        <button type="submit" :class="classes" @click="toggle">
            <span v-text="favoritesCount"></span>
            <span class="glyphicon glyphicon-thumbs-up"></span>
        </button>

</template>

<script>
    export default {
        props : ['reply'],

        data() {
            return {
                favoritesCount : this.reply.favoritesCount,
                isFavorited: this.reply.isFavorited
            }
        },

        computed: {
            classes() {
                return [
                        'btn',
                    this.isFavorited ? 'btn-success' : 'btn-default'
                ];
            }
        },

        methods : {
            toggle() {
                if (this.isFavorited) {
                    this.destroy();
                } else {
                    this.create();
                }
            },

            create() {
                axios.post('/replies/' + this.reply.id + '/favorite');

                flash('Komentar je dodan med priljubljene.')
                this.isFavorited = true;
                this.favoritesCount++;
            },

            destroy() {
                axios.delete('/replies/' + this.reply.id + '/favorite');

                flash('Komentar je odstranjen izmed priljubljenih.')
                this.isFavorited = false;
                this.favoritesCount--;
            }
        }
    }
</script>
