<template>
<v-app>
  <v-row>
  <v-form v-model="valid">
    <v-container class="pb-0">
      <v-row>
        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="titre"
            label="Titre"
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="genre"
            label="Genre"
            required
          ></v-text-field>
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="langue"
            label="Langue"
            required
          ></v-text-field>
        </v-col>
        

      </v-row>
    </v-container>
  </v-form>
  </v-row>
  <v-row>
  <film-card v-for="film in filterFilms" :filmData="film" :key="film.idFilm"></film-card>
  </v-row>

</v-app>
</template>
<script>
import { ref } from '@vue/composition-api'
import filmCard from '../cards/filmCard.vue'
import axiosClient from '@/axios'
import { mdiMagnify } from '@mdi/js';

export default {
  components:{
    filmCard
  },
  /*** */
  data(){
      return {
        filmList:{},
        valid:true,
        genre:'',
        langue:'',
        titre:'',
      }
  },
  computed:{
    filterFilms(){
      if(this.genre=="" && this.langue=="" && this.titre=="")
        return this.filmList;
      else{
        return this.filmList.filter((film)=>{
          return film.titre.match(this.titre) && film.langue.match(this.langue) && film.genre.match(this.genre)
         
        });
        
      }
    }
  },
  
  methods:{
    filtrer(){
       if(this.genre=="" && this.langue=="" && this.titre=="")
        return this.filmList;
      else if (this.titre!=""){
        console.log(this.filmList)
        return this.filmList.filter((film)=>{
          film.titre == this.titre
        });
        
      }
    },
    getFilmList(){
      axiosClient.get("/films")
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
    return {
    // icons
      icons: {
        mdiMagnify
      }
      }
  },
}
</script>
