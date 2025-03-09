<template>
  <v-app>
    <!-- Header with a toggle button -->


    <!-- Sidebar Navbar -->
    <NavbarHeader></NavbarHeader>

    <!-- Main Content -->
      <v-container>
        <v-row>
          <v-col class="pa-2">
           
              <router-view/>
         
          </v-col>
        </v-row>
      </v-container>
  </v-app>
</template>

<script>
import NavbarHeader from '../layout/Navbar.vue';

export default {
    components: {
        NavbarHeader: NavbarHeader
        },
  data() {
    return {
      navbarVisible: false, 
      items: [
        { title: "Home", icon: "mdi-home" },
        { title: "About", icon: "mdi-information" },
        { title: "Services", icon: "mdi-cogs" },
        { title: "Contact", icon: "mdi-phone" }
      ],
      drawer: true,

mini: false,
    };
  },
  methods: {
    toggleNavbar() {
      this.navbarVisible = !this.navbarVisible;
    }
  },
  mounted() {
  },
};
</script>

<style scoped>
/* Optional custom styling */
</style>
