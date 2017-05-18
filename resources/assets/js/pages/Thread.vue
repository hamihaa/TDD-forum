<script>
    import Replies from '../components/Replies.vue'
    import moment from 'moment-timezone';

    export default {

        props: ['initialRepliesCount', 'getago'],

        components: { Replies },

        computed: {
            postedAt() {
                moment.locale('sl');
                return moment(this.getago).format('ll');
            },
        },

        data() {
            return {
                repliesCount: this.initialRepliesCount
            };
        }
    }
</script>