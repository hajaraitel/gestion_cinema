<template>
  <v-data-table :headers="headers"  :items="salles" sort-by="capacite" class="elevation-1">
    <template v-slot:top>
      <v-alert v-for="(msg, idx) in messages" :key="idx" :type="type"
      
      
      dismissible
      border="left"
      elevation="2"
      
      >
          <span >{{ msg }} </span>
        </v-alert>
      <v-toolbar flat>
        <v-toolbar-title>Les salles</v-toolbar-title>
        
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
<!--Ajouter salle from-->
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              Ajouter Salle
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>
            
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.idSalle"
                      label="ID"
                      disabled
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.nom"
                      label="Nom"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.capacite"
                      label="Capacite"
                    ></v-text-field>
                  </v-col>
                 
                  
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close" >
                Cancel
              </v-btn>
              <v-btn color="blue darken-1" text  @click="save" >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

<!-- End Ajouter salle from-->
<!-- Start supprimer salle -->

        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Etes vous sur de vouloir supprimer cet element?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Annuler</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
<!-- End supprimer salle -->
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
    
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        {{ icons.mdiPencil }}
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
      >
        {{ icons.mdiDelete }}
      </v-icon>
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
import { validate } from 'json-schema';
import { ref } from '@vue/composition-api'
export default {
    data: () => ({
      
      dialog: false,
      dialogDelete: false,
      /* headers of table*/
      headers: [
        {
          text: 'ID',align: 'start',value: 'idSalle',
        },
        { text: 'Nom', value: 'nom' },
        { text: 'Capacite', value: 'capacite'},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      /** */
      
      messages:{},
      type:'error',
      salles: [],
      editedIndex: -1,
      editedItem: {
        nom: '',
        id: 0,
        capacite: 0,
      },
      defaultItem: {
        nom: '',
        id: 0,
        capacite: 0,
      },
      
    }),
    setup() {
        return {
        icons: {
            mdiDelete,mdiPencil
        },
        }
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Ajouter Salle' : 'Modifier Salle'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      validate () {
       this.$refs.form.validate()
      },
        isBlank(str) {
            return (!str || /^\s*$/.test(str));
        },
      initialize () {
        axiosClient.get('/salle').then(resp => {this.salles=resp.data});
      },

      editItem (item) {
        this.editedIndex = this.salles.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {

        this.editedIndex = this.salles.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        axiosClient.delete("/salle/"+this.editedItem.idSalle)
            .then(resp=>{
                if(resp.status==200)
                    console.log(resp)
                });
        
        this.closeDelete()
        this.initialize()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {
          //valider
          //modifier
          axiosClient.put("/salle/"+this.editedItem.idSalle,this.editedItem)
                .then(resp=>{
                    if(resp.status==200)
                    this.messages={text:"Salle modifiée avec succès"}
                this.type="success"
                
                }).catch(e=>{
                this.messages = e.response.data
                this.type="error"
            });
        } else {
          
          //valider

          //ajouter
          axiosClient.post('/salle',this.editedItem).then(
                resp=>{
                    if(resp.status==200)
                    this.messages={text:"Salle ajoutée avec succès"}
                this.type="success"
                
                    }
            ).catch(e=>{
                this.messages = e.response.data
                this.type="error"
            });

        }
        this.close()
        this.initialize()
      },
    },
  }
</script>