<template>
    <div>
        <div id="demo" style="width: 100%; height: 200px;"></div>
    </div>
</template>


<script>
    export default {
        //get from view
        props: ['data'],

    //when page loads
    mounted:
            function() {

        var jQCloud = require('jquery');

        var words = JSON.parse(this.data);

        $("#demo").jQCloud(words, {
//            shape: "rectangular",
            delay: 0,
            autoResize:true,
        });

        setTimeout(function () {
            var obj = $("#demo").data("jqcloud");
            var data = obj.word_array;
            for (var i in data) {
                $("#" + data[i]["attr"]["id"]).css("color", data[i]["color"]);
            }
        }, 100);
    }
    }
</script>