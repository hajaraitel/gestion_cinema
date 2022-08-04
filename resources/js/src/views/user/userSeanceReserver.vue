<template>
<v-app>
<v-row class="mb-0">
    <v-col cols="12">
        <v-card elevation="2" shaped>
            <v-card-title> <b>{{ seanceInfo.titre }}</b> </v-card-title>
            <div class="">
                <v-card-text class="text--primary text-base">
                <span class="text--primary text-base "> {{ seanceInfo.nom_salle }} </span>
                <v-spacer></v-spacer>
                <span>Prix : {{ seanceInfo.prix }}  DH</span>
                </v-card-text>
            </div>

            <v-card-text class="text--primary text-base">
                <span>date : {{ seanceInfo.date_seance }} </span>
                <v-spacer></v-spacer>
                <span>heure : {{ seanceInfo.horaire }} </span>
            </v-card-text>
        </v-card>
    </v-col>
</v-row>
<v-row class="mt-0">
    <v-col>
        <v-card>
            <v-card-title><b>Réserver</b></v-card-title>
            <v-card-text>
<v-form>
    <v-row>
        <!---->
            <v-col
                cols="12"
                md="3"
            >
                <label for="nbAdult">Nb adult</label>
            </v-col>

            <v-col
                cols="12"
                md="9"
            >
                <v-text-field
                id="nbAdult"
                type="number"
                v-model="formData.nb_adult"
                outlined
                dense
                hide-details
                required
                :rules="[v => !!v || 'Champs obligatoire']"
                
                @focusout="handleFocusout"
                ></v-text-field>
            </v-col>
<!---->
            <v-col
                cols="12"
                md="3"
            >
                <label for="nbEnfant">Nb enfant (50% du prix)</label>
            </v-col>

            <v-col
                cols="12"
                md="9"
            >
                <v-text-field
                id="nbEnfant"
                type="number"
                v-model="formData.nb_enfant"
                outlined
                dense
                hide-details
                :rules="[v => !!v || 'Champs obligatoire']"
                required
                ></v-text-field>
            </v-col>
<!---->
            <v-col
                cols="12"
                md="3"
            >
                <label for="total">Total</label>
            </v-col>

            <v-col
                cols="12"
                md="9"
            >
                <v-text-field
                id="total"
                v-model="total"
                type="number"
                outlined
                dense
                hide-details
                readonly
                ></v-text-field>
            </v-col>
            <!---->
            <v-col
                cols="12"
                md="3"
            >
                <label for="carte">Numéro de la carte</label>
            </v-col>
            <v-col
                cols="12"
                md="9"
            >
                <v-text-field
                id="carte"
                type="number"
                outlined
                dense
                hide-details
                :rules="[v => !!v || 'Champs obligatoire']"
                required
                ></v-text-field>
            </v-col>
            <!---->
            <v-col
                cols="12"
                md="3"
            >
                <label for="cvc">CVC</label>
            </v-col>
            <v-col
                cols="12"
                md="9"
            >
                <v-text-field
                id="cvc"
                type="number"
                outlined
                dense
                hide-details
                :rules="[v => !!v || 'Champs obligatoire']"
                required 
                maxlength="3"
                ></v-text-field>
            </v-col>
            <!---->
            <v-col
                cols="12"
                md="3"
            >
            <label for="exp">Date expiration</label>
            </v-col>
            <v-col
                cols="6"
                md="4"
            >
            <v-select
            id="exp"
            :items="months"
            :rules="[v => !!v || 'champs obligatoire']"
            label="Mois"
            required
            ></v-select>
            </v-col>
            <v-col
                cols="6"
                md="4"
            >
            <!--annee-->
            
        <v-menu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        transition="scale-transition"
        offset-y
        min-width="auto"
        >
        <template v-slot:activator="{ on, attrs }">
            <v-text-field
            v-model="date"
            label="Année"
            :rules="[v => !!v || 'Champs obligatoire']"
            required
            readonly
            v-bind="attrs"
            v-on="on"
            ></v-text-field>
        </template>
        <v-date-picker
            v-model="date"
            :active-picker.sync="activePicker"
            :min="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
        ></v-date-picker>
        </v-menu>

            </v-col>
            <!---->
            <v-col
                offset-md="3"
                cols="12"
            >
            <v-btn
            color="success"
            dark
            @click.prevent="payer"
            :disabled="!valid"
            >
                Payer
            </v-btn>
            </v-col>

            </v-row>
            </v-form>
            </v-card-text>
        </v-card>
    </v-col>
   
</v-row>
</v-app>
</template>
<script>
import axiosClient from '@/axios';

export default {
  methods: {
    payer(){
        
        this.formData.idSeance = this.$route.params.idSeance;
        this.formData.idUser = this.user.idUser;
        this.formData.prix_total = total.value
        axiosClient.post('/reservation',this.formData)
                    .then(resp=>{
                        if(resp.status == 200)
                        this.$router.push('/user/reservations/'+this.user.idUser);
                    }).catch(e=>{
                        this.errors = e.response.data
                    });
    },
    getSeanceInfo(idSeance)
    {
        axiosClient.get('/seance/'+idSeance).then(resp => {this.seanceInfo=resp.data})
        .catch(err=>{ console.log(err) })
    },
    handleFocusout(e) {
      //this.total = calculerTotal()
    }
  },
  data () {
    return {
        errors:{},
        valid: true,
        activePicker: null,
        date: null,
        menu: false,
        user:{},
        months: ['1','2','3','4','5','6','7','8','9','10','11','12'],
        formData:{idSeance:"",idUser:"",nb_adult:"",nb_enfant:"",prix_total:""},
        seanceInfo:{},
        numberRule: v  => {
            if (!v.trim()) return true;
            if (!isNaN(parseFloat(v)) && v >= 0 && v <= 999) return true;
            return 'Number has to be between 0 and 999';
        },
    }
  },
    mounted(){
        this.user = JSON.parse(localStorage.getItem('currentUser'));
        this.getSeanceInfo(this.$route.params.idSeance)
        console.log(this.seanceInfo)
    },
    watch: {
      menu (val) {
        val && setTimeout(() => (this.activePicker = 'YEAR'))
      },
    },
    computed: {
        total: function() {
            let sum = 0;
            if(this.formData.nb_adult!='')
                sum+=parseInt(this.formData.nb_adult) * this.seanceInfo.prix;
            if(this.formData.nb_enfant!='')
                sum+=parseInt(this.formData.nb_enfant) * (this.seanceInfo.prix/2);
            
        return sum
    }
  }
}
</script>