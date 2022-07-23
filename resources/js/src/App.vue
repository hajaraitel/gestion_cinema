<template>
  <component :is="resolveLayout">
    <router-view></router-view>
  </component>
</template>

<script>
import { computed } from '@vue/composition-api'
import { useRouter } from '@/utils'
import LayoutBlank from '@/layouts/Blank.vue'
import userContent from '@/layouts/userContent.vue'
import adminContent from '@/layouts/adminContent.vue'

export default {
  components: {
    LayoutBlank,
    userContent,adminContent
  },
  setup() {
    const { route } = useRouter()

    const resolveLayout = computed(() => {
      
      // Handles initial route
      if (route.value.name === null) return null

      if(route.value.name.includes('user')) return 'user-content'

      if(route.value.name.includes('admin')) return 'admin-content'

      return 'layout-blank'
    })

    return {
      resolveLayout,
    }
  },
}
</script>
