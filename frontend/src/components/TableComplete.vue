<template>
    <v-card class="pa-2">
       <v-card-title>
         <v-row>
             <v-col cols="7">
                 Work Order Complete by Operator
             </v-col>
         </v-row>
       </v-card-title>
  
       <v-data-table
         :headers="headers"
         :items="CompleteWorkOrders" 
         class="elevation-1"
       >
       </v-data-table>
    </v-card>
  </template>
  
  <script>
  export default {
   data () {
     return {
       doDel: false,
       headers: [
         {
           text: 'Nama',
           align: 'start',
           sortable: false,
            value: 'username'
         },
         { text: 'Complete',  sortable: false, value : 'complete_quantity' },
       ],
     }
   },
   computed: {
     __s() {
       return this.$store.state; 
     },
     CompleteWorkOrders() {
       return this.$store.state.CompleteWorkOrders;  
     },
   },
   methods: {
     __c(a, b) {
       return this.$store.commit("SET_OBJECT", [a, b]);  // Menyimpan data ke Vuex
     },
   }
  }
  </script>
  