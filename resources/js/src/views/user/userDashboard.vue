<template>
<v-app>
  <film-card></film-card>
</v-app>
</template>
<script>
import { ref } from '@vue/composition-api'
import filmCard from '../cards/filmCard.vue'
import {} from '@mdi/js'
export default {
  components:{
    filmCard
  },
  /*** */
  data(){
      return {
      }
  },
  methods:{
  },
  mounted(){
  },
  /*** */
  setup() {
    
  },
}
</script>
