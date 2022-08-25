
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
    <!--affichage version-->
    <template v-slot:item.version="{ item }">
        <span class="text-uppercase">{{ item.version }}</span>  
    </template>
    <!--affichage reservation-->
    <template v-slot:item.reserver="{ item }"> 

      <v-btn class="ma-2"
      outlined
      color="primary" :to="{name :'user_seance_reserver', params:{idSeance:item.idSeance}}"
      v-if="!item.is_full">
      Reserver 
      </v-btn>
      
      <v-chip
      class="ma-2 disponibilite-chip"
      v-else
     
      >
      Non disponible
    </v-chip>
      
    </template>

    </v-data-table>
  </v-card>
</template>
<script>
import axiosClient from '@/axios'
  export default {
  methods: {
    getSeances(){
        axiosClient.get('/seances').then(resp => {
          this.seances=resp.data
          });
    },
    //à revoir
    getSeancesByFilm(idFilm){
        axiosClient.get('/seances/film/'+idFilm).then(resp => {this.seances=resp.data});
    },

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
        is_full:false,
        search: '',
        headers: [
          {
            text: 'Film',
            align: 'start',
            sortable: true,
            value: 'titre',
          },
          { text: 'Salle', value: 'nom_salle',},
          { text: 'Date seance', value: 'date_seance', },
          { text: 'Horaire', value: 'horaire', },
          { text: 'Prix', value: 'prix', },
          { text: 'Version', value: 'version', },
          { text: 'Reservation', value: 'reserver', },
         
        ],
        seances: [],
      }
    },
  }
</script>
<style scoped>
.disponibilite-chip{
  color:white !important;
  background-color: red !important;
}
</style>