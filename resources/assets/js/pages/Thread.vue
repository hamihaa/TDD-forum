<script>
    import Replies from '../components/Replies.vue'
    import moment from 'moment-timezone';
    import SubscribeButton from '../components/SubscribeButton.vue';


    export default {

        props: ['initialRepliesCount', 'getago'],

        components: { Replies, SubscribeButton },

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