<template>
  <v-data-table :headers="headers"  :items="reservations" class="elevation-1">
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Les réservations</v-toolbar-title>
        
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
<!--Ajouter salle from-->
       

<!-- End Ajouter salle from-->
<!-- Start supprimer salle -->

        
<!-- End supprimer salle -->
      </v-toolbar>
    </template>
   <template #[`item.prix_total`]="{item}">
        {{ `${item.prix_total} $` }}
      </template>

    <template v-slot:item.est_annule="{ item }">
    <v-chip
        :color="getColor(item.est_annule)"
        dark
      >
       {{item.est_annule? "Annulée" : "Confirmée"}}
       </v-chip>
</template>
    <template v-slot:no-data>
      <v-btn
        color="primary"
        @click="initialize"
      >
        Reset
      </v-btn>
    </template>
  </v-data-table>
   
       
        
</template>

<script>
import axiosClient from '@/axios/index';
import {mdiDelete,mdiPencil} from '@mdi/js';

export default {
    data: () => ({
      
      dialog: false,
      dialogDelete: false,
    
      /* headers of table*/
      headers: [
        
        { text: 'Email', value: 'email', sortable: false },
        { text: 'Date Réservation', value: 'date_reservation', sortable: false},
         { text: 'Date Seance', value: 'date_seance', sortable: false},
          { text: 'Adult', value: 'nb_adult', sortable: false },
        { text: 'Enfant', value: 'nb_enfant', sortable: false },
         { text: 'Prix Total', value: 'prix_total', sortable: false },
         { text: 'Status', value: 'est_annule',sortable: false},
      ],
      /** */
      reservations: [],
     
      
      
    }),
    

    created () {
      this.initialize()
    },

    methods: {
        isBlank(str) {
            return (!str || /^\s*$/.test(str));
        },
      initialize () {
        axiosClient.get('/reservation').then(resp => {this.reservations=resp.data});
      },

   getColor (est_annule) {
        if (est_annule == 0) return 'primary'
        else if (est_annule == 1) return 'error'
        
      },



    }
  }
</script>