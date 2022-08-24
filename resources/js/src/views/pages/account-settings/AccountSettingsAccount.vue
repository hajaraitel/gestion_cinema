<template>
  <v-card
    flat
    class="pa-3 mt-2"
  >
    <v-card-text>
      <v-form class="multi-col-validation mt-6" enctype="multipart/form-data" ref="form" v-model="valid">
<!--photo-->
      <v-card-text class="d-flex">
        <v-avatar
          rounded
          size="120"
          class="me-6"
        >
        <v-img v-bind:src="accountData.photo"></v-img>
        </v-avatar>

        <!-- upload photo -->
        <div>
          <v-file-input
          ref="fileEvent"
          name="photo"
          @change="onChange"
          accept="image/png, image/jpeg, image/jpg"
          placeholder="nouvelle photo"
          label="Photo"></v-file-input>
          <p class="text-sm mt-5">
            Autorisé JPG, JPEG or PNG. Max taille de 800K
          </p>
        </div>
      </v-card-text>
<!--photo-->
        <v-row>
          <v-col
            md="6"
            cols="12"
          >
            <v-text-field
              v-model="accountData.nom"
              label="Nom"
              dense
              outlined
              :rules="[v => !!v || 'Champs obligatoire']"
              required
            ></v-text-field>
          </v-col>

          <v-col
            md="6"
            cols="12"
          >
            <v-text-field
              v-model="accountData.prenom"
              label="Prenom"
              dense
              outlined
              :rules="[v => !!v || 'Champs obligatoire']"
            ></v-text-field>
          </v-col>

          <v-col
            cols="12"
            md="6"
          >
            <v-text-field
              v-model="accountData.email"
              label="E-mail"
              dense
              outlined
              readonly
            ></v-text-field>
          </v-col>

          <v-col
            cols="12"
            md="6"
          >
            <v-text-field 
              readonly
              v-model="getRole"
              dense
              label="Role"
              outlined
            ></v-text-field>
          </v-col>

          <v-col
            cols="12"
            md="6"
          >
            <v-text-field
              v-model="accountData.telephone"
              dense
              outlined
              label="Telephone"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-radio-group
              v-model="accountData.sexe"
              row
              mandatory>
              <v-radio
                name="sexe"
                label="Femme"
                value="femme" 
              ></v-radio>
              <v-radio
                name="sexe"
                label="Homme"
                value="homme"  
              ></v-radio>
            </v-radio-group>
          </v-col>
          

          <v-col cols="12">
            <v-btn
              color="primary"
              class="me-3 mt-4"
              @click.prevent="enregistrer"
              :disabled="!valid"
            >
              Enregistrer
            </v-btn>
            <v-btn
              color="secondary"
              outlined
              class="mt-4"
              type="reset"
            >
              Annuler
            </v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import { mdiAlertOutline, mdiCloudUploadOutline,mdiCamera } from '@mdi/js'
import { ref } from '@vue/composition-api'
import axiosClient from '@/axios';
import { validate } from 'json-schema';
export default {
  methods: {
    validate () {
       this.$refs.form.validate()
      },
    enregistrer(){
      axiosClient.put("/user/"+this.accountData.idUser,this.accountData)
        .then(resp=>{
             if(resp.status==200)
            {
                
            }
        }).catch(e=>{
                this.errors = e.response.data
            });
    },
    onChange(files){
      this.accountData.photo = files.name
    }
    //create image for preview
   /* createImage(file) 
    {
      const reader = new FileReader();

      reader.onload = e => {
        this.imageUrl = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    onFileChange(file) {
    if (!file) {
      return;
      //this.imageUrl = this.accountData.photo
    }
    this.createImage(file);
  },
    Preview_image(files){
      this.accountData.photo = files.name
    }*/
  },  
  
  props: {
    accountData:Object
  },
  data () {
    return {
      image: undefined,
      // to save image url
      imageUrl: "",
      valid: true,
    }
  },
 /* beforeUpdate () {
    
    this.imageUrl=this.accountData.photo
  },*/
  computed:{
    getRole(){
     return this.accountData.is_admin  ? 'admin' : 'user'
    },
  },
  setup() {
    return {
      icons: {
        mdiAlertOutline,
        mdiCloudUploadOutline,mdiCamera
      },
    }
  },
}
</script>
