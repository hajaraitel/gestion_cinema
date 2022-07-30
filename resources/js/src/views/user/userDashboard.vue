<template>
<v-app>
  <v-row>
  <film-card v-for="film in filmList" :filmData="film" :key="film.idFilm"></film-card>
  </v-row>

</v-app>
</template>
<script>
import { ref } from '@vue/composition-api'
import filmCard from '../cards/filmCard.vue'
import {} from '@mdi/js'
import axiosClient from '@/axios'

export default {
  components:{
    filmCard
  },
  /*** */
  data(){
      return {
        filmList:{}
      }
  },
  
  methods:{
    getFilmList(){
      axiosClient.get("/film")
        .then(resp=>{
            if(resp.status==200)
                this.filmList = resp.data;
        })
        .catch(err=>{
          console.log(err)
        })
    }
  },
  mounted(){
    this.getFilmList();
  },
  /*** */
  setup() {
    
  },
}
</script>
