<template>
  <v-card
    flat
    class="pa-3 mt-2"
  >
    <v-card-text>
      <v-form class="multi-col-validation mt-6" enctype="multipart/form-data">
<!--photo-->
      <v-card-text class="d-flex">
        <v-avatar
          rounded
          size="120"
          class="me-6"
        ><!--:src="require('@/'+getPhoto).default"
        :src="require('@/assets/images/avatars/1.png').default"
        require('@/'+getPhoto).default
        -->
          <v-img :src="require('@/assets/images/avatars/1.png').default"></v-img>
        </v-avatar>

        <!-- upload photo -->
        <div>
          <v-file-input
          name="photo"
          @change="onChange"
          accept="image/png, image/jpeg, image/jpg"
          placeholder="nouvelle photo"
          label="Photo"></v-file-input>
         <!-- <v-btn
            color="primary"
            class="me-3 mt-5"
            @click="$refs.refInputEl.click()"
            
          >
            <v-icon class="d-sm-none">
              {{ icons.mdiCloudUploadOutline }}
            </v-icon>
            <span class="d-none d-sm-block">Nouvelle photo</span>
          </v-btn>

          <input
            @change="onChange"
            ref="refInputEl"
            type="file"
            accept=".jpeg,.png,.jpg"
            :hidden="true"
          />

          <v-btn
            color="error"
            outlined
            class="mt-5"
          >
            Reset
          </v-btn>-->
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
export default {
  methods: {
    enregistrer(){
      axiosClient.put("/user/"+this.accountData.idUser,this.accountData)
                .then(resp=>{
                  console.log(resp)
                   /* if(resp.status==200)
                    {
                        
                    }*/
                }).catch(e=>{
                        this.errors = e.response.data
                    });
    },
    onChange(files){
      this.accountData.photo = files.name
    }
  },
  
  
  props: {
    accountData:Object
  },
  data () {
    return {
    }
  },
  computed:{
    getRole(){
     return this.accountData.is_admin  ? 'admin' : 'user'
    },
    getPhoto(){
      return this.accountData.photo
     //return 'assets/images/avatars/1.png'
    }
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
