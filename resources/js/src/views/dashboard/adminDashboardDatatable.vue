<template>
  <v-card>
    <v-data-table
      :headers="headers"
      :items="usreList"
      item-key="email"
      class="table-rounded"
      hide-default-footer
      disable-sort
    >
      <!-- name -->
      <template #[`item.total`]="{item}">
        {{ `${item.total} DH` }}
      </template>
      <!-- status -->
      <template #[`item.status`]="{item}">
        <v-chip
          small
          :color="statusColor[status[item.status]]"
          class="font-weight-medium"
        >
          {{ status[item.status] }}
        </v-chip>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
import { mdiSquareEditOutline, mdiDotsVertical } from '@mdi/js'
import data from './datatable-data'

export default {
  setup() {
    const statusColor = {
      /* eslint-disable key-spacing */
      Confirmee: 'primary',
      Annulee: 'error',
      /* eslint-enable key-spacing */
    }

    return {
      headers: [
        { text: 'EMAIL', value: 'email' },
        { text: 'DATE', value: 'reservation_date' },
        { text: 'Total', value: 'total' },
        { text: 'Adult', value: 'adult' },
        { text: 'Enfant', value: 'enfant' },
        { text: 'STATUS', value: 'status' },
      ],
      usreList: data,
      status: {
        1: 'Confirmee',
        2: 'Annulee',
      },
      statusColor,

      // icons
      icons: {
        mdiSquareEditOutline,
        mdiDotsVertical,
      },
    }
  },
}
</script>
