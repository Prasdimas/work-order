<template>
    <v-row>
      <v-col cols="12">
        <v-tabs v-model="activeTab" background-color="primary" dark>
          <v-tab v-for="tab in tabs" :key="tab">
            {{ tab }}
          </v-tab>
        </v-tabs>
  
        <v-tabs-items v-model="activeTab">
          <v-tab-item>
            <TableProgressWorkOrder />
          </v-tab-item>
          <v-tab-item>
            <TableComplete />
          </v-tab-item>
        </v-tabs-items>
      </v-col>
    </v-row>
  </template>
  
  <script>
  import TableComplete from '../components/TableComplete.vue';
  import TableProgressWorkOrder from '../components/TableProgressWorkOrder.vue';
  
  export default {
    data() {
      return {
        activeTab: '0',
        tabs: ['Rekapitulasi', 'Operator'], // Daftar nama tab
      };
    },
    components: {
    TableProgressWorkOrder,
    TableComplete,
    },
    computed: {
      dialog() {
        return this.$store.state.dialog;
      },
    },
    mounted() {
         this.$store.dispatch('SearchRekap');
         this.$store.dispatch('SearchComplete');
    },
  };
  </script>
  