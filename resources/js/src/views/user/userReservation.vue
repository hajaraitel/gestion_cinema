<template>
  <v-card>
    <v-card-title>
      Mes réservations
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
      :items="reserv"
      :search="search"
    >
         <!--affichage film-->
        <template v-slot:item.titre="{ item }"> 
            <router-link :to="{ name: 'user_film_detail', params: { id: item.idFilm } }" >
                <span>{{ item.titre }}</span>
            </router-link>
        </template>
        <!--affichage prix-->
        <template v-slot:item.prix_total="{ item }"> 
            {{ item.prix_total }} <span>DH</span>
        </template>
        <!--affichage horaire-->
        <template v-slot:item.horaire="{ item }">
            {{ item.horaire.substring(0, item.horaire.length-3) }}
        </template>
        <!--affichage status-->
        <template v-slot:item.est_annule="{ item }">
            
             <v-chip
             width="90"
                v-if="item.est_annule"
                color="error"
            >
            annulée
            </v-chip>
            <v-chip
            width="90"
                v-else
                color="success"
            >
            confirmée
            </v-chip>
    <!-- Start annulee res -->

        <v-dialog v-model="dialogCancel" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Etes vous sur de vouloir annuler cette  réservation?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeCancel">Annuler</v-btn>
              <v-btn color="blue darken-1" text @click="cancelItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
    <!-- End annulee res -->
    
    </template>
    <template v-slot:item.actions="{ item }">
      <v-btn
        width="90"
        dark
        small
        @click="cancelItem(item)"
      >
        <v-icon
          dark
          left
        >
          {{ icons.mdiCancel }}
        </v-icon>Cancel
      </v-btn>
    </template>
    </v-data-table>
  </v-card>
</template>
<script>
import axiosClient from '@/axios'
import { mdiCancel } from '@mdi/js';
  export default {
    mounted(){
        if(typeof this.$route.params.id != 'undefined')
            this.getReserv(this.$route.params.id);
    },
  methods: {
    getReserv(idUser)
    {
        axiosClient.get('/reservations/user/'+idUser)
        .then(resp=>{
            if(resp.status==200)
                this.reserv = resp.data;
        })
        .catch(err=>{
          console.log(err)
        })
    },
    cancelItem (item) {
        this.canceledIndex = this.reserv.indexOf(item)
        this.canceledItem = Object.assign({}, item)
        this.dialogCancel = true
      },
      cancelItemConfirm () {
        axiosClient.put("/reservation/"+this.canceledItem.idReservation)
            .then(resp=>{
                if(resp.status==200)
                    console.log(resp)
                });
        
        this.closeCancel()
        this.getReserv(this.$route.params.id)
      },

      closeCancel () {
        this.dialogCancel = false
        this.$nextTick(() => {
          //this.canceledItem = Object.assign({}, this.defaultItem)
          this.canceledIndex = -1
        })
      },

  },
    data () {
      return {
        search: '',
        headers: [
            
          {text: 'Film',align: 'start',value: 'titre',class:"purple darken-4",},
          { text: 'Salle', value: 'nom_salle' ,class:"purple darken-4",},
          { text: 'Date seance', value: 'date_seance' ,class:"purple darken-4",},
          { text: 'Heure', value: 'horaire' ,class:"purple darken-4",},
          { text: 'Nb adult', value: 'nb_adult', class:"purple darken-4",},
          { text: 'Nb enfant', value: 'nb_enfant' ,class:"purple darken-4",},
          { text: 'Total', value: 'prix_total' ,class:"purple darken-4",},
          { text: 'Date réservation', value: 'date_reservation', class:"purple darken-4",},
          { text: 'status', value: 'est_annule' ,class:"purple darken-4",},
          { text: 'Actions', value: 'actions', sortable: false },
        ],
        reserv: [],
        icons: {
            mdiCancel
        },
        dialogCancel: false,
        canceledItem:{},
        canceledIndex:-1,
      }
    },
  }
</script>
<style scoped>

</style>