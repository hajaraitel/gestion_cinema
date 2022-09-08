<template>
<!-- Film Card -->
      <v-col sm="6" cols="12">
        <v-card class="d-flex align-center">
          <div class="d-flex justify-space-between flex-wrap flex-md-nowrap flex-column flex-md-row">
            <div class="mx-auto">
              <v-img
                width="220"
                height="100%"
                :src="require('@/assets/images/films/cover2.jpg').default"
              ></v-img>
            </div>
            <v-divider :vertical="$vuetify.breakpoint.mdAndUp"></v-divider>
            <div>
              <v-card-title> Apple iPhone 13 Pro ! </v-card-title>
              <v-card-text>
                Apple iPhone 11 Pro smartphone. Announced Sep 2019. Features 5.8″ display Apple A13 Bionic
                
                <br>
               tttt
              </v-card-text>
              <v-card-text class="text--primary text-base">
                <span>ttttessst</span>
              </v-card-text>
              <v-card-actions class="d-flex justify-space-between dense">
                <v-btn text color="primary" dark>
                  <span class="ms-2">Voir Detail</span>
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


</style>
