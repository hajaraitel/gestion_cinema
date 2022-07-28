<template>
  <v-card id="account-setting-card">
    <!-- tabs -->
    <v-tabs v-model="tab" show-arrows>
      <v-tab v-for="tab in tabs" :key="tab.icon">
        <v-icon size="20" class="me-3">
          {{ tab.icon }}
        </v-icon>
        <span>{{ tab.title }}</span>
      </v-tab>
    </v-tabs>

    <!-- tabs item -->
    <v-tabs-items v-model="tab">
      <v-tab-item>
        <account-settings-account :accountData="userData"></account-settings-account>
      </v-tab-item>

      <v-tab-item>
        <account-settings-security :accountData="userData"></account-settings-security>
      </v-tab-item>

    </v-tabs-items>
  </v-card>
</template>

<script>
import { mdiAccountOutline, mdiLockOpenOutline, mdiInformationOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'

import AccountSettingsAccount from './AccountSettingsAccount.vue'
import AccountSettingsSecurity from './AccountSettingsSecurity.vue'
import axiosClient from '@/axios'

export default {
  data () {
    return {
      userData:{},
      userId : this.$route.params.id,
      errors:{}
    }
  },
  
  mounted(){
    this.getUser(this.userId)
  },
  methods: {
    getUser(id){
      //
      axiosClient.get("/user/"+id)
        .then(resp=>{
            if(resp.status==200)
                this.userData = resp.data;
        })
        .catch(err=>{
          console.log(err)
        })
      
    }
  },
  components: {
    AccountSettingsAccount,
    AccountSettingsSecurity,
  },
  setup() {
    const tab = ref('')

    // tabs
    const tabs = [
      { title: 'Compte', icon: mdiAccountOutline },
      { title: 'Sécurité', icon: mdiLockOpenOutline },
    ]

    return {
      tab,
      tabs,
      icons: {
        mdiAccountOutline,
        mdiLockOpenOutline,
        mdiInformationOutline,
      },
    }
  },
}
</script>
