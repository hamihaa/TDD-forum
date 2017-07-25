<template>

    <!-- Facebook social -->
    <div>
        <div id="fb-root">
        </div>
        <div class="fb-like"
             data-href="http://localhost/learn-vue/tab/test.html#"
             data-send="false"
             data-layout="button_count"
             data-width="100"
             data-show-faces="false">
        </div>

        <div class="fb-share-button"
             data-href="http://localhost/learn-vue/tab/test.html"
             data-layout="button_count">
        </div>
    </div>
    <!-- /Facebook social -->
</template>

<script>
    export default{
        mounted(){
                    (function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'cript', 'facebook-jssdk'));

        }
    }
</script>