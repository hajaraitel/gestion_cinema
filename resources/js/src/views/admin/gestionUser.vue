<template>
  <v-data-table :headers="headers"  :items="Users" class="elevation-1">
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Les utilisateurs</v-toolbar-title>
        
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
      </v-toolbar>
    </template>
      <template v-slot:item.update_role="{ item }">
     <v-btn
     class="my-2"
              color="primary"
              fab
              x-small
              dark
            >
               <v-icon
        small
        @click="updateRole(item)"
      >
        {{ icons.mdiPencil }}
      </v-icon>
            </v-btn>
</template>
    <template v-slot:item.photo="{ item }">
          <v-img
          :src="require(`@/assets${item.photo}`).default"
          max-height="40px"
          max-width="40px"
          alt="logo"
          contain
          eager
          class="app-logo me-3"
        ></v-img>
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
         { text: 'Photo', value: 'photo', sortable: false },
        { text: 'Email', value: 'email', sortable: false },
          { text: 'Nom', value: 'nom', sortable: false },
        { text: 'Prénom', value: 'prenom', sortable: false },
        { text: 'Sexe', value: 'sexe', sortable: false },
       { text: 'Téléphone', value: 'telephone',sortable: false},
         { text: 'Rôle', value: 'is_admin', sortable: false },
         { text: 'Modifier rôle', value: 'update_role', sortable: false },
         
          
      ],
     
      

      /** */
      Users: [],
     
      
      
    }),
    setup() {
        return {
        icons: {
           mdiPencil
        },
        }
    },

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

      updateRole($item)
      {
        axiosClient.put("/users/"+$item.idUser)
                .then(resp=>{
                    if(resp.status==200)
                        console.log("success")
                });
    window.location.reload();
      },



    }
  }
</script>