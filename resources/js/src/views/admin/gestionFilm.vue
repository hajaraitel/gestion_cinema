<template>
  <v-data-table :headers="headers"  :items="films" sort-by="idFilm" class="elevation-1">
    <template v-slot:top>
      <v-alert v-for="(msg, idx) in messages" :key="idx" :type="type"
      
      
      dismissible
      border="left"
      elevation="2"
      
      >
          <span >{{ msg }} </span>
        </v-alert>
      <v-toolbar flat>
        <v-toolbar-title>Gestion Films</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
<!--Ajouter film from-->
        <v-dialog v-model="dialog" max-width="720px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              Ajouter Film
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
<!--First row-->
                <v-row>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.idFilm"
                      label="ID Film"
                      disabled
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.titre"
                      label="Titre"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.annee_sortie"
                      label="Annee Sortie"
                      required
                    ></v-text-field>
                  </v-col>
                </v-row>
<!--Second row-->
                <v-row>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.realisateur"
                      label="Realisateur"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.acteurs"
                      label="Acteurs"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.duree"
                      label="Durée"
                      required
                    ></v-text-field>
                  </v-col>
                </v-row>
<!--Third row-->
                <v-row>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                  <v-file-input
                     ref="fileEvent"
                     name = "l'affiche"
                     @change="onChange"
                     accept="image/png, image/jpeg, image/jpg"
                     label="choisir l'affiche de film"
                   ></v-file-input>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.genre"
                      label="Genre"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.langue"
                      label="la Langue"
                      required
                    ></v-text-field>
                  </v-col>
                </v-row>
<!--Fourth row-->
                <v-row>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.description"
                      label="description"
                      required
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

<!-- End Ajouter film from-->
<!-- Start supprimer film -->

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
<!-- End supprimer film -->
      </v-toolbar>
    </template>
    
    <template v-slot:item.affiche="{ item }">
          <v-img
          :src="require(`@/assets${item.affiche}`).default"
          max-height="40px"
          max-width="40px"
          alt="logo"
          contain
          eager
          class="app-logo me-3"
        ></v-img>
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
        { text: 'Titre', value: 'titre' }, 
        { text: 'Annee de Sortie', value: 'annee_sortie'},
        { text: 'Le Realisateur', value: 'realisateur'},
        { text: 'les Acteurs', value: 'acteurs'},
        { text: 'la Durée', value: 'duree'},
        { text: 'affiche', value: 'affiche'},
        { text: 'le Genre', value: 'genre'},
        { text: 'langue', value: 'langue'},
        { text: 'description', value: 'description'},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      /** */
      messages:{},
      type:'error',
      films: [],
      editedIndex: -1,
      editedItem: {

        titre: '',
        //annee_sortie: ,
        realisateur: '',
        acteurs: '',
        duree: '',
        affiche: '',
        genre: '',
        langue: '',
        description: '',  
        
      },
      defaultItem: {
        titre: '',
        //annee_sortie: 0,
        realisateur: '',
        acteurs: '',
        duree:'',
        affiche: '',
        genre: '',
        langue: '',
        description: '',
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
        return this.editedIndex === -1 ? 'Ajouter Film' : 'Modifier Film'
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
        axiosClient.get('/film').then(resp => {this.films=resp.data});
      },

      editItem (item) {
        this.editedIndex = this.films.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {

        this.editedIndex = this.films.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        axiosClient.delete("/film/"+this.editedItem.idFilm)
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
          axiosClient.put("/film/"+this.editedItem.idFilm,this.editedItem)
                .then(resp=>{
                    if(resp.status==200)
                        //console.log("success")
                        this.messages={text:"Film modifiée avec succès"}
                        this.type="success"
                
                }).catch(e=>{
                this.messages = e.response.data
                this.type="error"
            });
              
        } else {
          
          //valider

          //ajouter
          axiosClient.post('/film',this.editedItem).then(
                resp=>{
                    if(resp.status==200)
                       // console.log("success")
                       this.messages={text:"Film ajoutée avec succès"}
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
      onChange(file){
        if(file!=null)
        {
          this.editedItem.affiche = file.name
          this.imageUrl = URL.createObjectURL(file)

        }
        else{
          this.editedItem.affiche = null
          this.imageUrl=''
        }
     
    
      },
    },
  }
</script>