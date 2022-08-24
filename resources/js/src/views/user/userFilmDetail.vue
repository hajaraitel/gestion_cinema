<template>
<v-app>
      <v-col sm="6" cols="12" class="col-md-12">
        <v-card>
          <div class="d-flex flex-column-reverse flex-lg-row">
            <div>
              <v-card-title class="text-uppercase"> {{ this.filmData.titre }} </v-card-title>
              <v-card-text class="d-flex align-center flex-wrap body-1">
               <span class="text-darkslategray">Réalisateur : {{ this.filmData.realisateur }} </span> 
               <v-spacer></v-spacer>
               <span class="pa-2 text-darkslategray">{{ this.filmData.annee_sortie }} </span>
              </v-card-text>
              <v-card-text class="font-weight-medium text-darkgray">
                Acteurs : {{ this.filmData.acteurs }}
              </v-card-text>
              <v-card-text class="font-weight-medium text-darkgray">
                <span>Genre : {{ this.filmData.genre }}</span> 
              </v-card-text>
              <v-card-text class="font-weight-medium text-darkgray">
               <span>Langue : {{ this.filmData.langue }}</span>
              </v-card-text>
              <v-card-text class="font-weight-medium text-darkgray">
                Durée : {{ this.filmData.duree }}</v-card-text>
              <v-card-text class="font-weight-medium text-dimgray">
                {{ this.filmData.description }}
              </v-card-text>
              <v-card-actions class="dense">
                <v-btn text color="primary" dark :to="{ name: 'user_dashboard'}"> Retour </v-btn>
                <v-btn dark text color="primary" :to="{ name: 'user_seances', params:{idFilm : this.filmData.idFilm}}"> Voir seances </v-btn>
              </v-card-actions>
            </div>
            <v-spacer></v-spacer>
            <div class="pa-4">
              <v-img
                :src="this.filmData.affiche"
                :class="$vuetify.breakpoint.mdAndUp ? 'rounded-lg' : 'rounded-0'"
                height="100%"
                :max-width="$vuetify.breakpoint.mdAndUp ? '220' : '100%'"
              ></v-img>
            </div>
          </div>
        </v-card>
      </v-col>
</v-app>
</template>
<script>
import axiosClient from '@/axios';
export default{
    data () {
    return {
        filmData:{},
        idFilm : this.$route.params.id,
    }
  },
  methods: {
    getFilm(id){
      //
      axiosClient.get("/films/"+id)
        .then(resp=>{
            if(resp.status==200)
                this.filmData = resp.data;
        })
        .catch(err=>{
          console.log(err)
        })
  }
  },
  
  mounted(){
    this.getFilm(this.idFilm)
  }

}
</script>
<style scoped>
.text-darkslategray{
  color:#2F4F4F;
}
.text-darkgray{
  color :#A9A9A9;
}
.text-dimgray{
  color: #696969;
}
</style>