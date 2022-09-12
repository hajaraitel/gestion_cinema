<template>
    <v-data-table :headers="headers"  :items="seances" sort-by="idSeance" class="elevation-1">
      <template v-slot:top>
        <v-alert v-for="(msg, idx) in messages" :key="idx" :type="type"
      
      
      dismissible
      border="left"
      elevation="2"
      
      >
          <span >{{ msg }} </span>
        </v-alert>
        <v-toolbar flat>
          <v-toolbar-title>Gestion Seances</v-toolbar-title>
          
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>
  <!--Ajouter seance from-->
          <v-dialog v-model="dialog" max-width="620px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                Ajouter Seance
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
                        v-model="editedItem.idSeance"
                        label="ID Seance"
                        disabled
                      ></v-text-field>
                    </v-col>
  
                     <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-select
                       v-model="editedItem.idSalle"
                      :items="salles"
                       label="Salle"
                       item-text="nom"
                       item-value="idSalle"
                       required
                       ></v-select>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                       <v-select
                      v-model="editedItem.idFilm"
                      :items="films"
                      item-text="titre"
                      item-value="idFilm"
                      label="Film"
                      required
                    ></v-select>
                    </v-col>
                    </v-row>
  
  
                    <v-row>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        v-model="editedItem.prix"
                        label="Prix"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        v-model="editedItem.version"
                        label="Version"
                        required
                      ></v-text-field>
                    </v-col>
                    </v-row>
  
  
                    <v-row>
                    <v-col
                      cols="6"
  
                    >
                      <v-date-picker
                        v-model="editedItem.date_seance"
                        label="Date Seance"
                        required
                      ></v-date-picker>
                    </v-col>
                    <v-col
                      cols="6"
  
                    >
                      <v-time-picker
                        v-model="editedItem.horaire"
                        label="Horaire"
                        required
                      ></v-time-picker>
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
  
  <!-- End Ajouter seance from-->
  <!-- Start supprimer seance -->
  
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
  <!-- End supprimer seance -->
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
         // {text: 'ID Seance',align: 'start',value: 'idSeance',},
          { text: 'Salle', value:'nom' },
          { text: 'Film', value: 'titre'},
          { text: 'Date', value: 'date_seance'},
          { text: 'Time', value: 'horaire'},
          { text: 'Prix', value: 'prix'},
          { text: 'Version', value: 'version'},
          { text: 'Actions', value: 'actions', sortable: false },
        ],
        messages:{},
        type:'error',
        /** */
        seances: [],
        salles: [],
        films: [],
        editedIndex: -1,
        editedItem: {
          nom: '',
          titre: '',
          idSeance: 0,
          idSalle: 0,
          idFilm: 0,
          date_seance: '',
          horaire: '',
          prix: 0,
          version: '',
        },
        defaultItem: {
          // idSeance: 0,
          nom: '',
          titre: '',
          idSalle: 0,
          idFilm: 0,
          date_seance: '',
          horaire: '',
          prix: 0,
          version: '',
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
          return this.editedIndex === -1 ? 'Ajouter Seance' : 'Modifier Seance'
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
          axiosClient.get('/seance').then(resp => {this.seances=resp.data});
          axiosClient.get('/salle').then(resp => {this.salles=resp.data});
          axiosClient.get('/film').then(resp => {this.films=resp.data});
        },
  
        editItem (item) {
          this.editedIndex = this.seances.indexOf(item)
          this.editedItem = Object.assign({}, item)
          this.dialog = true
        },
  
        deleteItem (item) {
  
          this.editedIndex = this.seances.indexOf(item)
          this.editedItem = Object.assign({}, item)
          this.dialogDelete = true
        },
  
        deleteItemConfirm () {
          axiosClient.delete("/seance/"+this.editedItem.idSeance)
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
            axiosClient.put("/seance/"+this.editedItem.idSeance,this.editedItem)
                  .then(resp=>{
                      if(resp.status==200)
                          //console.log("success")
                          this.messages={text:"Seance modifiée avec succès"}
                        this.type="success"
                
                }).catch(e=>{
                this.messages = e.response.data
                this.type="error"
                  });
          } else {
            
            //valider
  
            //ajouter
            axiosClient.post('/seance',this.editedItem).then(
                  resp=>{
                      if(resp.status==200)
                          //console.log("success")
                          this.messages={text:"Seance ajoutée avec succès"}
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