<template>
  <div class="text-xs-center">
    <v-menu offset-y>
      <v-btn icon slot="activator">
        <v-icon :color="orange">add_alert</v-icon>
        {{ unreadCount }}
      </v-btn>
      <v-list>
        <v-list-tile v-for="item in unread" :key="item.id">
          <router-link :to="item.path">
            <v-list-tile-title @click="readIt(item)">{{item.question}}</v-list-tile-title>
          </router-link>
        </v-list-tile>
        <v-divider></v-divider>
        <v-list-tile v-for="item in read" :key="item.id">
          <v-list-tile-title>{{item.question}}</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-menu>
  </div>
</template>

<script>
export default {
  data() {
    return {
      read: {},
      unread: {},
      unreadCount: 0
    };
  },
  created() {
    if (User.loggedin()) {
      this.getNotifications();
    }
    this.listen();
  },
  computed: {
    color() {
      return this.unreadCount > 0 ? "orange" : "orange lighten-4";
    }
  },
  methods: {
    listen() {
      Echo.private("App.User." + User.id()).notification(notification => {
        //console.log(notification.type);
        this.unread.unshift(notification);
        this.unreadCount++;
      });
    },
    getNotifications() {
      axios
        .post("/api/notifications")
        .then(res => {
          console.log(res);
          this.read = res.data.read;
          this.unread = res.data.unread;
          this.unreadCount = res.data.unread.length;
        })
        .catch(error => Exception.handle(error));
    },
    readIt(notification) {
      axios.post("/api/markAsRead", { id: notification.id }).then(() => {
        this.unread.splice(notification, 1);
        this.read.push(notification);
        this.unreadCount--;
      });
    }
  }
};
</script>

<style>
</style>
