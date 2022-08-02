
<template>
  <v-card>
    <v-card-title>
      Seances
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="desserts"
      :search="search"
    ></v-data-table>
  </v-card>
</template>
<script>
import axiosClient from '@/axios'
  export default {
  methods: {
    getSeances(){
        axiosClient.get('/seances').then(resp => {this.seances=resp.data});
    }

  },
    data () {
      return {
        search: '',
        headers: [
          {
            text: 'Film',
            align: 'start',
            sortable: true,
            value: 'name',
          },
          { text: 'Salle', value: 'calories' },
          { text: 'Date seance', value: 'fat' },
          { text: 'Horaire', value: 'carbs' },
          { text: 'Prix', value: 'protein' },
          { text: 'Version', value: 'iron' },
          { text: 'Capacité', value: 'iron' },
          { text: 'Reservation', value: 'iron' },
        ],
        seances: [],
      }
    },
  }
</script>