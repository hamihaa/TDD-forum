<template>
    <div>
        <button type="submit" :class="classesUp" @click="toggleUpvote">
            <span :class="{ 'white-color': this.isUpvoted }" class="glyphicon glyphicon-thumbs-up"></span>
            <span v-text="upvotesCount"></span>
        </button>

        <button type="submit" :class="classesDown" @click="toggleDownvote">
            <span :class="{ 'white-color' : this.isDownvoted }" class="glyphicon glyphicon-thumbs-down"></span>
            <span v-text="downvotesCount"></span>
        </button>
    </div>
</template>

<script>
export default {
  props: ["reply"],

  data() {
    return {
      favoritesCount: this.reply.favoritesCount,
      upvotesCount: this.reply.upvotesCount,
      downvotesCount: this.reply.downvotesCount,
      isFavorited: this.reply.isFavorited,
      isUpvoted: this.reply.isUpvoted,
      isDownvoted: this.reply.isDownvoted
    };
  },

  computed: {
    classesUp() {
      return [
        "btn",
        this.isUpvoted ? "btn-success white-color" : "btn-default"
      ];
    },
    classesDown() {
      return [
        "btn",
        this.isDownvoted ? "btn-danger white-color" : "btn-default"
      ];
    }
  },

  methods: {
    toggleUpvote() {
      if (this.isUpvoted) {
        this.destroyVote("up");
      } else {
        this.createUpvote();
      }
    },
    toggleDownvote() {
      if (this.isDownvoted) {
        this.destroyVote("down");
      } else {
        this.createDownvote();
      }
    },
    createUpvote() {
      if (!this.isDownvoted) {
        axios.post("/replies/" + this.reply.id + "/vote/1");
      } else {
        axios.patch("/replies/" + this.reply.id + "/vote/1");
        this.downvotesCount--;
      }

      flash("Glas na komentar je bil oddan.");
      this.isDownvoted = false;
      this.isUpvoted = true;
      this.upvotesCount++;
    },

    createDownvote() {
      if (!this.isUpvoted) {
        axios.post("/replies/" + this.reply.id + "/vote/0");
      } else {
        axios.patch("/replies/" + this.reply.id + "/vote/0");
        this.upvotesCount--;
      }
      flash("Glas na komentar je bil oddan.");
      this.isUpvoted = false;
      this.isDownvoted = true;
      this.downvotesCount++;
    },

    destroyVote(type) {
      axios.delete("/replies/" + this.reply.id + "/vote");

      flash("Glas je bil odstranjen.");
      this.isDownvoted = false;
      if (type == "up") {
        this.upvotesCount--;
      } else {
        this.downvotesCount--;
      }
      this.isUpvoted = false;
      this.isDownvoted = false;
    }
  }
};
</script>
