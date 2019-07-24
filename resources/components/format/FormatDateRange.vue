<template lang="pug">
p
  FormatDate(:value="start",type="human")
  span &nbsp;
  span.icon: i.mdi.mdi-arrow-right-bold
  span &nbsp;
  FormatDate(:value="end",:type="same_day ? 'time' : 'human'")
</template>

<script>
import FormatDate from '@/components/format/FormatDate'
export default {
  components: { FormatDate },
  props: {
    start: {
      type: Object,
      required: true,
    },
    end: {
      type: Object,
      required: true,
    }
  },
  computed: {
    same_day () {
      return this.start.isSame(this.end, 'date')
    },
  },
}
</script>
