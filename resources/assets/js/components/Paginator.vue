<template>

        <ul class="pagination" v-if="shouldPaginate">
            <li v-show="prevUrl">
                <a href="#" aria-label="Previous" rel="prev" @click.prevent="page--">
                    <span aria-hidden="true">&laquo; Prejšnja</span>
                </a>
            </li>
            <li v-show="nextUrl">
                <a href="#" aria-label="Next" rel="next" @click.prevent="page++">
                    <span aria-hidden="true">Naslednja &raquo;</span>
                </a>
            </li>
        </ul>

</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        },

        //whenever something changes (also in parent), update
        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page() {
                this.broadcast().updateUrl();
            }
    },

        computed: {
            //display if there is previous or next
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        methods: {
            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            },

            broadcast() {
                return this.$emit('changed-page', this.page);
            }
        }
    }

</script>