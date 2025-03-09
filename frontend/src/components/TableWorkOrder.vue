<template>
     <v-card class="pa-2">
      <v-card-title>
        <v-row>
            <v-col cols="7">
                Work Order List 
            </v-col>
            <v-col cols="2">
                <DateRange></DateRange>
            </v-col>
            <v-col cols="3">
               <SearchBar></SearchBar>
            </v-col>
        </v-row>
        </v-card-title>
        <v-data-table
    :headers="headers"
    :items="WorkOrders"
    class="elevation-1"
  >

    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
        v-if="role.role_id == 1"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        class="mr-2"
        @click="ProgressItem(item)"
        v-if="role.role_id !== 1"
      >
        mdi-plus
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
        v-if="role.role_id == 1"
      >
        mdi-delete
      </v-icon>
    </template>
  </v-data-table>
  <v-dialog
      v-model="doDel"
      max-width="400"
    >
      <v-card class="pink">
        <v-card-title class="white--text caption">
Apakah Anda akan menghapus data ?
        </v-card-title>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="green darken-1"
            dark small
            @click="doDel = false"
          >
            Batal
          </v-btn>

          <v-btn
            color="pink darken-1"
            dark small
            @click="del"
          >
            Hapus
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </v-card>
</template>

<script>
import DateRange from '../common/DateRange.vue'
import SearchBar from '../common/SearchBar.vue'

  export default {
    components:{
        DateRange,SearchBar
    },
    data () {
      return {
        doDel: false,
        headers: [
          {
            text: 'Number',
            align: 'start',
            sortable: false,
            value: 'work_order_number',
          },
          { text: 'Operator', value: 'assigned_to_name',sortable: false },
          { text: 'Nama', value: 'product_name',sortable: false },
          { text: 'Quantity', value: 'quantity',sortable: false },
          { text: 'Tanggal', value: 'due_date',sortable: false },
          { text: 'Status', value: 'status',sortable: false },
          { text: 'Action', value: 'actions' },
        ],
      }
    },
    computed: {
    __s() {
      return this.$store.state; 
    },
    role() {
      return this.$store.state.role; 
    },
    WorkOrders() {
    return this.$store.state.WorkOrders.filter(order => {
      const matchesSearch = this.$store.state.search
        ? order.product_name.toLowerCase().includes(this.$store.state.search.toLowerCase())
        : true;

      const matchesDate = this.$store.state.DateRange[0] && this.$store.state.DateRange[1]
        ? new Date(order.due_date) >= new Date(this.$store.state.DateRange[0]) &&
          new Date(order.due_date) <= new Date(this.$store.state.DateRange[1])
        : true;

      return matchesSearch && matchesDate;
    });
  },
    parentDateRange: {
      get() {
        return this.__s.DateRange;
      },
      set(v) {
        this.__c("DateRange", v);
      },
    },

  },

    methods: {
        __c(a, b) {
      return this.$store.commit("SET_OBJECT", [a, b]);
    },
      editItem(x){
            this.__c("dialog", true);
            this.__c("edit", true);
            this.__c("NumberWO", x.work_order_number);
            this.__c("WOid", x.work_order_id);
            this.__c("NameProduct", x.product_name);
            this.__c("duedate", x.due_date);
            this.__c("qty", x.quantity);
            this.__c("selectedSatus", x.status);
            this.__c("selectedOperator", x.assigned_to_id);
            this.__c("currentStatus", x.status);
      },
      ProgressItem(x){
            this.__c("dialog", true);
            this.__c("Progress", true);
            this.__c("NumberWO", x.work_order_number);
            this.__c("WOid", x.work_order_id);
            this.__c("NameProduct", x.product_name);
            this.__c("duedate", x.due_date);
            this.__c("qty",0);
            this.__c("Note","");
            this.__c("selectedSatus", x.status);
            this.__c("selectedOperator", x.assigned_to_id);
            this.__c("currentStatus", x.status);
            if (x.status == 'Pending') {
              this.__c("status", [
      {"name": 'Pending', 'id': 'Pending' },
      {"name": 'In Progress', 'id': 'Progress' }
    ]);
            }
            if(x.status == 'Progress'){
              this.__c("status", [
      {"name": 'In Progress', 'id': 'Progress' },
      {"name": 'Completed', 'id': 'Completed' },
    ]);
            }
      },
      deleteItem(x){
        this.__c("WOid", x.work_order_id);
        this.doDel = true;
      },
      del(){
        this.$store.dispatch('deleteWorkOrder').then(()=>{
          this.$store.dispatch('WorkOrder');          
          this.doDel = false;
        });
      }
      
    },
    mounted() {
      if(this.role.role_id == 1 ){
           this.$store.dispatch('WorkOrder');
          }else{
           this.$store.dispatch('SearchWorkOrder');
         }
         this.$store.dispatch('SearchOperator');
    },
  }
</script>