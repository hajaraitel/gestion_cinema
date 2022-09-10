<template>
  <v-card>
    <v-card-title class="align-start">
      <span class="font-weight-semibold">Satistiques</span>
      <v-spacer></v-spacer>
      
    </v-card-title>

    <v-card-text>
      <v-row>
        <v-col
          v-for="data in statisticsData"
          :key="data.title"
          cols="6"
          md="3"
          class="d-flex align-center"
        >
          <v-avatar
            size="44"
            :color="resolveStatisticsIconVariation (data.title).color"
            rounded
            class="elevation-1"
          >
            <v-icon
              dark
              color="white"
              size="30"
            >
              {{ resolveStatisticsIconVariation (data.title).icon }}
            </v-icon>
          </v-avatar>
          <div class="ms-3">
            <p class="text-xs mb-0">
              {{ data.title }}
            </p>
            <h3 class="text-xl font-weight-semibold" v-if="data.title=='Films'">
              {{ countFilms }}
            </h3>
            <h3 class="text-xl font-weight-semibold" v-else-if="data.title=='Utilisateurs'">
              {{ countUser }}
            </h3>
            <h3 class="text-xl font-weight-semibold" v-else-if="data.title=='Reservations'">
              {{ countReservation }}
            </h3>
            <h3 class="text-xl font-weight-semibold" v-else-if="data.title=='Revenue'">
              {{ sumReservation }}
            </h3>
          </div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { 
  mdiAccountOutline, mdiCurrencyUsd, mdiTrendingUp, mdiDotsVertical, mdiLabelOutline,
  mdiMovieOpenOutline 

} from '@mdi/js'
import axiosClient from '@/axios/index';
import data from './datatable-data';
//import { count } from 'console';

export default {
   data () {
    return {
        countUser:null,
        countFilms:null,
        countReservation:null,
        sumReservation:null,
    }
  },
   mounted(){
    axiosClient.get('/countUser').then(resp => {this.countUser=resp.data.users_count});
     axiosClient.get('/countFilm').then(resp => {this.countFilms=resp.data.films_count});
     axiosClient.get('/countReservation').then(resp => {this.countReservation=resp.data.reservations_count});
    axiosClient.get('/sumReservation').then(resp => {this.sumReservation=resp.data.reservations_sum});

 },

  setup() {
    const statisticsData = [
      {
        title: 'Films',
        total: '',
        
      },
      {
        title: 'Utilisateurs',
        total: '',
      },
      {
        title: 'Reservations',
        total: '',
      },
      {
        title: 'Revenue',
        total: '',
      },
    ]
   
    const resolveStatisticsIconVariation = data => {
      if (data === 'Films') return {icon: mdiMovieOpenOutline , color: 'primary' }
      if (data === 'Utilisateurs') return { icon: mdiAccountOutline, color: 'success' }
      if (data === 'Reservations') return { icon: mdiLabelOutline, color: 'warning' }
      if (data === 'Revenue') return { icon: mdiCurrencyUsd, color: 'info' }

      return { icon: mdiAccountOutline, color: 'success' }
    }

    return {
      statisticsData,
      resolveStatisticsIconVariation,

      // icons
      icons: {
        mdiDotsVertical,
        mdiTrendingUp,
        mdiAccountOutline,
        mdiLabelOutline,
        mdiCurrencyUsd,
        mdiMovieOpenOutline
      },
    }
  },
}
</script>
