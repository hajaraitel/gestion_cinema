<template>
<!-- Film Card -->
 
  <v-col sm="6" cols="12">
    <v-card class="d-flex align-center">
      <div class="d-flex justify-space-between flex-wrap flex-md-nowrap flex-column flex-md-row">
        <div class="mx-auto">
          <v-img
            width="220"
            height="100%"
            
            v-bind:src="filmData.affiche"
          ></v-img>
        </div>
        <v-divider :vertical="$vuetify.breakpoint.mdAndUp"></v-divider>
        <div>
          <v-card-title > <span style="color:#FD6D81;text-transform: uppercase;">{{ filmData.titre }}</span> </v-card-title>
          <v-card-text class="text--primary text-base mb-5">
            <p>
              <span class="font-weight-regular subtitle-1 title-color">Genre :</span><br>
              <span class="font-weight-medium subtitle-1 ms-2">{{ filmData.genre }}</span>
            </p>
            <p>
              <span class="font-weight-regular subtitle-1 title-color">Réalisateur :</span> <br>
              <span class="font-weight-medium subtitle-1 ms-2">{{ filmData.realisateur }}</span>
            </p>
            <p>
              <span class="font-weight-regular subtitle-1 title-color">Acteurs :</span> <br>
              <span class="font-weight-medium subtitle-1 ms-2">{{ filmData.acteurs }}</span>
            </p>
            <p>
              <span class="font-weight-regular subtitle-1 title-color">Langue :</span> <br>
              <span class="font-weight-medium subtitle-1 ms-2 purple">{{ filmData.langue }}</span>
            </p>
          </v-card-text>
          <v-spacer></v-spacer>
          <v-card-actions class="d-flex justify-space-between dense card-actions">
            <v-btn text color="primary" dark :to="{ name: 'user_film_detail' , params: { id: filmData.idFilm }}">
              <span  class="ms-2" >
              Voir Detail
              </span>
            </v-btn>
            <v-btn text color="primary" dark>
              <span class="ms-2">Voir Seances</span>
            </v-btn>
          </v-card-actions>
        </div>
      </div>
    </v-card>
  </v-col>

</template>
<script>
import { ref } from '@vue/composition-api'
export default{
  props: {
    filmData:Object
  },
    setup(){
        const isCardDetailsVisible = false
        const rating = ref(5)

    return {
      isCardDetailsVisible,
      rating,
      // icons
      icons: {},
    }
    }
}
</script>

<style lang="scss" scoped>
@import '@resources/sass//preset/mixins.scss';

.avatar-center {
  top: -2rem;
  left: 1rem;
  border: 3px solid white;
  position: absolute;
}

// membership pricing
@include theme--child(memberpricing-bg) using ($material) {
  background-color: rgba(map-deep-get($material, 'primary-shade'), map-deep-get($material, 'states', 'hover'));
}

.card-actions{
  position: absolute;
  bottom: 0;
}

.title-color{
  color:#708090;
}
</style>
