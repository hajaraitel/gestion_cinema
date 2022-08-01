<template>
  <v-data-table :headers="headers"  :items="Users" class="elevation-1">
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Gestion Utilisateurs</v-toolbar-title>
        
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
    <template v-slot:item.is_admin="{ item }">
     <v-chip
        :color="getColor(item.is_admin)"
        dark
      >
       {{item.is_admin? "Admin" : "User"}}
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
          { text: 'Nom', value: 'nom', sortable: false },
        { text: 'Prénom', value: 'prenom', sortable: false },
       { text: 'Téléphone', value: 'telephone',sortable: false},
         { text: 'Photo', value: 'photo', sortable: false },
         { text: 'Role', value: 'is_admin', sortable: false },
      ],
     
      

      /** */
      Users: [],
     
      
      
    }),
    

    created () {
      this.initialize()
    },

    methods: {
        isBlank(str) {
            return (!str || /^\s*$/.test(str));
        },
      initialize () {
        axiosClient.get('/user').then(resp => {this.Users=resp.data});
      },

   getColor (is_admin) {
        if (is_admin == 0) return 'primary'
        else if (is_admin == 1) return 'error'
        
      },



    }
  }
</script>