<template>
    <v-sheet>
        <v-text-field
        @click="ViewDialog = true" readonly
        label="Masukkan Rentang Waktu"
        hide-details
        outlined
        dense
        :value="formatDateRange(DateRange)"
      ></v-text-field>
       
      <v-dialog v-model="ViewDialog" persistent max-width="700">
      <v-card>
        <v-card-title class="text-h5 primary white--text">
          Masukkan Tanggal
        </v-card-title>
        <v-card-text class="py-3">
          <v-row no-gutters>
            <v-col cols="9">
              <v-row>
                <v-col cols="12">
                  <date-picker 
                    value-type="format" 
                    format="YYYY-MM-DD" 
                    placeholder="Select date" 
                    inline 
                    class="elevation-1" 
                    range  
                    :show-time-panel="showTimePanel"
                    type="datetime" 
                    @change="handlechange"
                  />
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="cancel">
            Batal
          </v-btn>
          <v-btn color="primary darken-1" dark @click="update">
            Simpan
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </v-sheet>
</template>
<script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';

  export default {
    components: { DatePicker },
    data() {
      return {
        ViewDialog : false,
        showTimePanel:false,
        date: '',
      };
    },
    computed: {
    __s() {
      return this.$store.state; 
    },

    DateRange: {
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
    cancel(){
        this.ViewDialog =false
    },
    update(){
this.ViewDialog = false
        this.__c("DateRange",this.date)
    },
    formatDateRange(dates) {
      const [startDate, endDate] = dates;
      if (startDate === endDate) {
        return startDate;
      }
      return `${startDate} ~ ${endDate}`;
    },
    handlechange(x){
        this.date = x
    },

    },
    mounted() {
        console.log(this.$store.state);
        
    },
  };
</script>