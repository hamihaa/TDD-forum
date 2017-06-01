<template>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-bell"></span>
            </a>

            <ul class="dropdown-menu" v-if="notifications.length">
                <li v-for="notification in notifications">
                    <a :href="notification.data.link"
                       v-text="notification.data.message"
                        @click="markAsRead(notification)">
                    </a>
                </li>
            </ul>
            <ul class="dropdown-menu" v-else>
                <li>
                   <span class="glyphicon glyphicon-sad"></span> Ni novih obvestil.
                </li>
            </ul>
        </li>
</template>

<script>
    export default {
        data() {
            return { notifications: false}
        },

        created() {
            axios.get("/profiles/" + window.Laravel.user.name + "/notifications")
            .then( response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                "profiles/{$user->name}/notifications/{$notificationId}"
                axios.delete("profiles/" + window.Laravel.user.name + "/notifications/" + notification.id)
            }
        }

    }
</script>

<style>

</style>