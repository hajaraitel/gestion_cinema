<template>
<v-app>
<v-row class="mb-0">
    <v-col cols="12">
        <v-card elevation="2" shaped>
            <v-card-title> <b class="text-uppercase title">{{ seanceInfo.titre }}</b> </v-card-title>
            <table class="ml-5 mb-5">
                <tr>
                    <td class="header">Salle : </td>
                    <td class="seance-value">{{ seanceInfo.nom_salle }}</td>
                </tr>
                <tr>
                    <td  class="header">Prix : </td>
                    <td class="seance-value">{{ seanceInfo.prix }}  DH</td>
                </tr>
                <tr>
                    <td  class="header">Date seance : </td>
                    <td class="seance-value">{{ str_to_date(seanceInfo.date_seance) }}</td>
                </tr>
                <tr>
                    <td  class="header">Heure seance : </td>
                    <td class="seance-value">
                        {{ seanceInfo.horaire ? seanceInfo.horaire.substring(0, seanceInfo.horaire.length-3) : '' }}
                    </td>
                </tr>

            </table>
        </v-card>
    </v-col>
</v-row>
<v-row class="mt-0">
    <v-col>
        <v-card>
            <v-card-title ><b class="title">RESERVER</b></v-card-title>
            <!--message alert-->
        <v-alert v-for="(msg, idx) in messages" :key="idx" :type="type">
          <span >{{ msg }} </span>
        </v-alert>
      <!--End message alert-->
        <v-card-text>
    <v-form ref="form"
        v-model="valid"
    >
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
                required
                :rules="number_validation"
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
                :rules="number_validation"
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
                :rules="numberRule"
                required
                outlined
                dense
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
                :rules="cvcRules"
                required 
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
            
            <!--Annee-->
            <v-col
                cols="6"
                md="4"
            >
                <v-text-field
                id="annee"
                type="number"
                label="Annee"
                :rules="anneeRules"
                required 
                ></v-text-field>
            </v-col>
            <!---->
            <!---->
            <v-col
                offset-md="3"
                cols="12"
            >
            <v-btn
            color="success"
            @click.prevent="payer"
            :disabled="!valid">Payer</v-btn>
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
    validate () {
       this.$refs.form.validate()
      },
    payer(){
       this.formData.idSeance = this.$route.params.idSeance;
        this.formData.idUser = this.user.idUser;
        this.formData.prix_total = total.value
        axiosClient.post('/reservation',this.formData)
                    .then(resp=>{
                        if(resp.status == 200)
                        { 
                            this.$router.push('/user/reservations/'+this.user.idUser);
                        }
                    }).catch(e=>{
                        this.messages = e.response.data
                        this.type="error"
                    });
    },
    getSeanceInfo(idSeance)
    {
        axiosClient.get('/seance/'+idSeance).then(resp => {this.seanceInfo=resp.data})
        .catch(err=>{ console.log(err) })
    },
    
    str_to_date(str)
    {
    let dt = new Date(str);
    return  dt.toLocaleDateString();
    }
  },
  data () {
    return {
        messages:{},
        valid: true,
        type:'error',
        user:{},
        months: ['1','2','3','4','5','6','7','8','9','10','11','12'],
        formData:{idSeance:"",idUser:"",nb_adult:"",nb_enfant:"",prix_total:""},
        seanceInfo:{},
        numberRule: [
        v => !!v || 'Champs obligatoire',
        v => (v && v.length == 16) || 'numero doit etre composé de 16 nombre',
      ],
      cvcRules :[
        v => !!v || 'Champs obligatoire',
        v => (v && v.length == 3) || 'numero doit etre composé de 3 nombre',
      ],
      anneeRules :[
        v => !!v || 'Champs obligatoire',
        v => (v && v.length == 4) || 'l annee doit etre composé de 4 nombre',
        v => (v && v >= ((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)))
                || "la valeur mninimale est l annee suivante"
      ],
    }
  },
    mounted(){
        this.user = JSON.parse(localStorage.getItem('currentUser'));
        this.getSeanceInfo(this.$route.params.idSeance)
    },
    
    computed: {
        total: function() {
            let sum = 0;
            if(this.formData.nb_adult!='')
                sum+=parseInt(this.formData.nb_adult) * this.seanceInfo.prix;
            if(this.formData.nb_enfant!='')
                sum+=parseInt(this.formData.nb_enfant) * (this.seanceInfo.prix/2);
            
        return sum
    },
    number_validation(){
        const rules=[]
        if((this.formData.nb_adult=='' && this.formData.nb_enfant=='') || 
            (this.formData.nb_adult=='0' && this.formData.nb_enfant=='0') ||
            (this.formData.nb_adult=='0' && this.formData.nb_enfant=='') ||
            (this.formData.nb_adult=='' && this.formData.nb_enfant=='0'))
        {

            const rule = v => 'le nombre de personne est obligatoire'
            rules.push(rule);
        }
        return rules
    }
  }
}
</script>
<style scoped>
.title{
    color:slateblue !important;
}
td{
    padding:5px;

}
.header{
    color : cornflowerblue !important;
}
.seance-value{
    color: slategray !important;
}
</style>