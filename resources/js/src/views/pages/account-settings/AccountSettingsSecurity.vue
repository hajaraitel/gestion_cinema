<template>
  <v-card flat class="mt-5">
    <v-form v-model="valid" ref="form">
      <div class="px-3">
        <v-card-text class="pt-5">
          <!--Error alert-->
        <v-alert v-for="(error, idx) in messages" :key="idx" :type="type" class="mb-5">
          <span >{{ error }} </span>
        </v-alert>
        <!--End Error alert-->
          <v-row>
            <v-col cols="12" sm="8" md="6">
              <!-- current password -->
              <v-text-field
                v-model="formData.mp_actuel"
                :type="isCurrentPasswordVisible ? 'text' : 'password'"
                :append-icon="isCurrentPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                label="Mot de passe actuel"
                outlined
                dense
                @click:append="isCurrentPasswordVisible = !isCurrentPasswordVisible"
                :rules="[v => !!v || 'Champs obligatoire']"
                required
              ></v-text-field>

              <!-- new password -->
              <v-text-field
                v-model="formData.mp_nouveau"
                :type="isNewPasswordVisible ? 'text' : 'password'"
                :append-icon="isNewPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                label="Nouveau mot de passe"
                outlined
                dense
                @click:append="isNewPasswordVisible = !isNewPasswordVisible"
                :rules="[v => !!v || 'Champs obligatoire']"
                required
              ></v-text-field>

              <!-- confirm password -->
              <v-text-field
                v-model="formData.mp_nouveau_cf"
                :type="isCPasswordVisible ? 'text' : 'password'"
                :append-icon="isCPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                label="Confirmer nouveau mot de passe"
                outlined
                dense
                class="mt-3"
                @click:append="isCPasswordVisible = !isCPasswordVisible"
                :rules="[v => !!v || 'Champs obligatoire']"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12">
            <v-btn
              color="primary"
              class="me-3"
              @click.prevent="enregistrer"
              :disabled="!valid"
            >
              Enregistrer
            </v-btn>
          </v-col>
          </v-row>
        </v-card-text>
      </div>

    </v-form>
  </v-card>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { mdiKeyOutline, mdiLockOpenOutline, mdiEyeOffOutline, mdiEyeOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'
import axiosClient from '@/axios'
export default {
  mounted(){
    this.user = JSON.parse(localStorage.getItem('currentUser'));
  },
  methods: {
    validate () {
       this.$refs.form.validate()
      },
    enregistrer()
    {
      if(this.confirmation_mp(this.formData.mp_nouveau,this.formData.mp_nouveau_cf))
      {
        axiosClient.put("/updatePassword/"+this.user.idUser,this.formData)
        .then(resp=>{
             if(resp.status==200)
            {

              this.messages={text:"Mot de passe modifié avec succès"}
              this.type="success"
            }
        }).catch(e=>{
                this.messages = e.response.data
                this.type="error"
            });
      }
      else
      {
        this.messages = {text:"Les nouveaux mots de passe ne correspondent pas"}
        this.type="error"
      }
    },
    confirmation_mp(mp,cmp)
    {
      return mp == cmp;
    }
  },
  data () {
    return {
      formData:{mp_actuel:"",mp_nouveau:"",mp_nouveau_cf:""},
      messages:{},
      user:{},
      valid:true,
      type:'error',

    }
  },
  setup() {
    const isCurrentPasswordVisible = ref(false)
    const isNewPasswordVisible = ref(false)
    const isCPasswordVisible = ref(false)

    return {
      isCurrentPasswordVisible,
      isNewPasswordVisible,
      isCPasswordVisible,
      icons: {
        mdiKeyOutline,
        mdiLockOpenOutline,
        mdiEyeOffOutline,
        mdiEyeOutline,
      },
    }
  },
}
</script>

<style lang="scss" scoped>
.two-factor-auth {
  max-width: 25rem;
}
.security-character {
  position: absolute;
  bottom: -0.5rem;
}
</style>
