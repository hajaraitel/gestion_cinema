<template>
  <v-row>
    <v-col cols="12">
      <admin-dashboard-statistics-card></admin-dashboard-statistics-card>
    </v-col>

    <v-col cols="12">
      <admin-dashboard-datatable></admin-dashboard-datatable>
    </v-col>
  </v-row>
</template>

<script>
// demos
import adminDashboardStatisticsCard from '../dashboard/adminDashboardStatisticsCard.vue'
import adminDashboardDatatable from '../dashboard/adminDashboardDatatable.vue'
import axiosClient from '@/axios/index';
export default {
  components: {
    adminDashboardStatisticsCard,
    adminDashboardDatatable
  },
  /** */
  data()
  {
    return{
      salle:{idSalle:"",nom:"",capacite:"",created_at:"",updated_at:""},
    }
  },
   mounted(){
    axiosClient.get("/salle")
    .then(resp => {this.salle=resp.data})
 },
  /** */
  setup() {
   
  },
}
</script>
