<template>
    <div>
        <div class="panel panel-default">
            <div v-for="(reply, index) in items" :key="reply.id">
                <reply :data="reply" @deleted="remove(index)"></reply>
            </div>
        </div>

        <paginator :dataSet="dataSet" @changed-page="fetch"></paginator>
        <div>
        </div>
        <new-reply @created="add"></new-reply>
    </div>
</template>

<script>
    //if not declared as global in app.js, import here
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    import collection from '../mixins/Collection';
    //paginator is imported from app.js, global level

    export default {
        components: { Reply, NewReply },
        //enherit methods from collection file
        mixins: [collection],

        data() {
            //set of items is in begining empty, when view is created, fetch fills it
            return {
                dataSet: false
            }
        },

        //when template is created, run fetch
        created() {
            this.fetch();
        },

        methods: {
            //used to get replies
            fetch(page) {
                axios.get(this.url(page)).then(this.refresh);
            },

            url(page) {
                if (! page){
                    let query = location.search.match(/page=(\d+)/);
                    page = query ? query[1] : 1;
                }
                return location.pathname + '/replies?page=' + page;
            },

            //used by fetch to refresh after fetching
            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;
                window.scrollTo(0,0);
            },

        }
    }
</script>