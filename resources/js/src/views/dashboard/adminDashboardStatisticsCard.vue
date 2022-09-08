<template>
  <v-card>
    <v-card-title class="align-start">
      <span class="font-weight-semibold">Satistiques</span>
      <v-spacer></v-spacer>
      
    </v-card-title>

    <v-card-text>
      <v-row>
        <v-col
          v-for="data in statisticsData"
          :key="data.title"
          cols="6"
          md="3"
          class="d-flex align-center"
        >
          <v-avatar
            size="44"
            :color="resolveStatisticsIconVariation (data.title).color"
            rounded
            class="elevation-1"
          >
            <v-icon
              dark
              color="white"
              size="30"
            >
              {{ resolveStatisticsIconVariation (data.title).icon }}
            </v-icon>
          </v-avatar>
          <div class="ms-3">
            <p class="text-xs mb-0">
              {{ data.title }}
            </p>
            <h3 class="text-xl font-weight-semibold">
              {{ data.total }}
            </h3>
          </div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { 
  mdiAccountOutline, mdiCurrencyUsd, mdiTrendingUp, mdiDotsVertical, mdiLabelOutline,
  mdiMovieOpenOutline 

} from '@mdi/js'

export default {
  setup() {
    const statisticsData = [
      {
        title: 'Films',
        total: '50',
      },
      {
        title: 'Utilisateurs',
        total: '20',
      },
      {
        title: 'Reservations',
        total: '15',
      },
      {
        title: 'Revenue',
        total: '$88',
      },
    ]

    const resolveStatisticsIconVariation = data => {
      if (data === 'Films') return { icon: mdiMovieOpenOutline , color: 'primary' }
      if (data === 'Utilisateurs') return { icon: mdiAccountOutline, color: 'success' }
      if (data === 'Reservations') return { icon: mdiLabelOutline, color: 'warning' }
      if (data === 'Revenue') return { icon: mdiCurrencyUsd, color: 'info' }

      return { icon: mdiAccountOutline, color: 'success' }
    }

    return {
      statisticsData,
      resolveStatisticsIconVariation,

      // icons
      icons: {
        mdiDotsVertical,
        mdiTrendingUp,
        mdiAccountOutline,
        mdiLabelOutline,
        mdiCurrencyUsd,
        mdiMovieOpenOutline
      },
    }
  },
}
</script>
