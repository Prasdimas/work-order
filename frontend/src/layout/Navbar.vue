<template>
    <v-navigation-drawer
    v-model="drawer"
      :mini-variant.sync="mini"
      permanent
      app
      dark
    >
    <v-list-item two-line class="px-2">
  <v-list-item-avatar>
    <v-btn
    icon
    @click="logoutUser"
    class="ml-2"
  >
    <v-icon>mdi-logout</v-icon>
  </v-btn>
  </v-list-item-avatar>
  <v-list-item-content>
        <v-list-item-title>{{ role.role_name }} </v-list-item-title>
        <v-list-item-subtitle>{{ userdata.name }}</v-list-item-subtitle>
       
      </v-list-item-content>

  <v-btn
    icon
    @click.stop="mini = !mini"
  >
    <v-icon>mdi-chevron-left</v-icon>
  </v-btn>

  <!-- Tombol Logout -->
  
</v-list-item>

      <v-divider></v-divider>

      <v-list dense nav>
        <v-list-item
  v-for="item in filteredItems"
  :key="item.title"
  link
  @click="navigateTo(item.route)"
>
  <v-list-item-icon>
    <v-icon>{{ item.icon }}</v-icon>
  </v-list-item-icon>
  <v-list-item-content>
    <v-list-item-title>{{ item.title }}</v-list-item-title>
  </v-list-item-content>
</v-list-item>

  </v-list>
    </v-navigation-drawer>
</template>


<script>

export default {
    components: {
        },
        computed : {
          __s() {
      return this.$store.state; 
    },
    role(){
      return this.__s.role;
    },
    userdata(){
      return this.__s.userdata;
    },  filteredItems() {
    return this.items.filter(item => 
      !(this.role.role_name === 'Operator' && item.title === 'Report')
    );
  }

        },
  data() {
    return {
      navbarVisible: false,
      items: [
        { title: 'Dashboard', icon: 'mdi-view-dashboard', route: '/dashboard' },
        { title: 'Pelacakan', icon: 'mdi-nfc-search-variant', route: '/dashboard/tracking' },
        { title: 'Report', icon: 'mdi-file-chart', route: '/dashboard/report' },
      ],
      drawer: true,

mini: false,
    };
  },
  methods: {
    navigateTo(route) {
    // Cek apakah rute yang ingin dituju sama dengan rute yang sedang aktif
    if (this.$route.path !== route) {
      this.$router.push(route);
    } 
  },
    logoutUser() {
      this.$store.dispatch("logout")
  },
    toggleNavbar() {
      // Toggle the visibility of the navbar
      this.navbarVisible = !this.navbarVisible;
    }
  },
  mounted() {
  },
};
</script>

<style scoped>

</style>
