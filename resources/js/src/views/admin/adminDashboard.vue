<template>
  <v-row>
    <v-col cols="12">
      <admin-dashboard-statistics-card></admin-dashboard-statistics-card>
    </v-col>

    <v-col cols="12">
      <admin-dashboard-reservation></admin-dashboard-reservation>
    </v-col>
  </v-row>
</template>

<script>
// demos
import adminDashboardStatisticsCard from '../dashboard/adminDashboardStatisticsCard.vue'
import adminDashboardReservation from '../admin/gestionReservation.vue'
import axiosClient from '@/axios/index';
export default {
  components: {
    adminDashboardStatisticsCard,
    adminDashboardReservation
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
