<template>
  <v-card
    flat
    class="pa-3 mt-2"
  >
    <v-card-text>
      <v-form class="multi-col-validation mt-6" enctype="multipart/form-data" ref="form" v-model="valid">
      <!--message alert-->
        <v-alert v-for="(msg, idx) in messages" :key="idx" :type="type">
          <span >{{ msg }} </span>
        </v-alert>
      <!--End message alert-->
      <!--photo-->
      <v-card-text class="d-flex">
        <v-avatar
          rounded
          size="120"
          class="me-6"
        >
        <v-img v-bind:src="imageUrl"></v-img>
        </v-avatar>

        <!-- upload photo -->
        <div>
          <v-file-input
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
                this.messages={text:"Profile modifié avec succès"}
                this.type="success"
                localStorage.setItem('currentUser',JSON.stringify(resp.data.user))
                window.dispatchEvent(new CustomEvent('updateUser',{
                  detail:{
                    storage:localStorage.getItem('currentUser')
                  }
                }))

            }
        }).catch(e=>{
                this.messages = e.response.data
                this.type="error"
            });
            
    },
    onChange(file){
      if(file!=null)
      {
        this.accountData.photo = file.name
        this.imageUrl = URL.createObjectURL(file)
      }  
      else
      { 
        this.accountData.photo = null
        this.imageUrl=''
      } 
      
    }
    
  },  
  
  props: {
    accountData:Object
  },
  data () {
    return {
      valid: true,
      messages:{},
      type:'error',
      imageUrl:this.accountData.photo
    }
  },
watch:{
  accountData : function(newVal){
    this.imageUrl = newVal.photo
  }
},
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
