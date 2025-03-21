<template>
  <v-card class="pa-2">
     <v-card-title>
       <v-row>
           <v-col cols="7">
               Work Order Rekapitulasi 
           </v-col>
       </v-row>
     </v-card-title>

     <v-data-table
       :headers="headers"
       :items="RekapWorkOrders" 
       class="elevation-1"
     >
       <template v-slot:item="{ item }">
         <tr>
           <td>{{ item.work_order_name }}</td>
           <td v-for="(status, index) in item.work_order_status" :key="index">
              {{ status.total_quantity }}
            </td>
         </tr>
       </template>
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
       
       },
       { text: 'Pending',sortable: false },
       { text: 'Progress', sortable: false },
       { text: 'Complete',  sortable: false },
       { text: 'Cancelled', sortable: false },
     ],
   }
 },
 computed: {
   __s() {
     return this.$store.state; 
   },
   RekapWorkOrders() {
     return this.$store.state.RekapWorkOrders;  
   },
 },
 methods: {
   __c(a, b) {
     return this.$store.commit("SET_OBJECT", [a, b]);  // Menyimpan data ke Vuex
   },
 }
}
</script>
