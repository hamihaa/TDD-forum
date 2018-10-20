<script>
import Replies from "../components/Replies.vue";
import moment from "moment-timezone";
import SubscribeButton from "../components/SubscribeButton.vue";
import DoughnutChart from "../charts/newChart.js";
import FacebookButtons from "../components/FacebookButtons.vue";

export default {
  props: ["initialRepliesCount", "getago"],

  components: { Replies, SubscribeButton, DoughnutChart },

  computed: {
    postedAt() {
      moment.locale("sl");
      return moment(this.getago).format("ll");
    }
  },

  data() {
    return {
      repliesCount: this.initialRepliesCount
    };
  }
};
</script>