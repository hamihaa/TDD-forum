// mixin is same as trait

export default {
    data() {
      return {
          items: []
      };
    },

    methods : {
        //removes 1 from collection
        remove(index) {
            this.items.splice(index, 1);
            this.$emit('removed');
        },
        //adds an item
        add(item) {
            this.items.push(item);

            this.$emit('added');
        }
    }
}