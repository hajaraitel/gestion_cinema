
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
      :items="seances"
      :search="search"
    >

    <!--affichage film-->
    <template v-slot:item.titre="{ item }"> 
        <router-link :to="{ name: 'user_film_detail', params: { id: item.idFilm } }" >
            <span>{{ item.titre }}</span>
        </router-link>
    </template>
    <!--affichage prix-->
    <template v-slot:item.prix="{ item }"> 
        {{ item.prix }} <span>DH</span>
    </template>
    <!--affichage horaire-->
    <template v-slot:item.horaire="{ item }">
        {{ item.horaire.substring(0, item.horaire.length-3) }}
    </template>
    <!--affichage reservation-->
    <template v-slot:item.reserver="{ item }"> 
        <v-btn class="ma-2"
      outlined
      color="indigo">Reserver</v-btn>
    </template>

    </v-data-table>
  </v-card>
</template>
<script>
import axiosClient from '@/axios'
  export default {
  methods: {
    getSeances(){
        axiosClient.get('/seances').then(resp => {this.seances=resp.data});
    },
    getSeancesByFilm(idFilm){
        axiosClient.get('/seances/film/'+idFilm).then(resp => {this.seances=resp.data});
    }

  },
  mounted(){
    //console.log("id",this.$route.params.id)
    if(typeof this.$route.params.id != 'undefined')
        this.getSeancesByFilm(this.$route.params.id);
    else
        this.getSeances()
  },
    data () {
      return {
        search: '',
        headers: [
          {
            text: 'Film',
            align: 'start',
            sortable: true,
            value: 'titre',
          },
          { text: 'Salle', value: 'nom_salle' },
          { text: 'Date seance', value: 'date_seance' },
          { text: 'Horaire', value: 'horaire' },
          { text: 'Prix', value: 'prix' },
          { text: 'Version', value: 'version' },
          { text: 'Capacité', value: 'capacite' },
          { text: 'Reservation', value: 'reserver' },
        ],
        seances: [],
      }
    },
  }
</script>
<style>
</style>