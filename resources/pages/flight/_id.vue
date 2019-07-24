<template lang="pug">
#Flight.mx-4.p-5
  .m-4
    nuxt-link(to="/").border.border-gray.rounded.text-blue-500.px-4.py-2.mb-4.mr-4 Back
    a.border.border-gray.rounded.text-blue-500.px-4.py-2.mb-4(target="_new",:href="`http://localhost:3000/api/flight/${$route.params.id}`")
      i.mdi.mdi-settings.mr-2
      span API Endpoint
      span &nbsp;
      span.font-bold {{ `/api/flight/${$route.params.id}` }}
    .my-4.p-4.border.border-gray.rounded(v-if="flight")
      .flex.p-1
        .font-bold.mr-2 distance:
        .text {{ flight.distance | numeral }} meters
      .flex.p-1
        .font-bold.mr-2 locations:
        .text {{ flight.location_count | numeral }}
      .flex.p-1
        .font-bold.mr-2 battery drains:
        .text {{ flight.drain_count }}
      .flex.p-1(v-if="flight.drain_count")
        .font-bold.mr-2 before / after percent:
        .text {{ flight.max_percent }}% / {{ flight.min_percent }}%
      .flex.p-1(v-if="flight.drain_count")
        .font-bold.mr-2 max / min temperature:
        .text {{ flight.max_temp }} / {{ flight.min_temp }}
      .flex.p-1(v-if="flight.location_first")
        .font-bold.mr-2 start:
        .text:  FormatDate(:value="moment(flight.location_first.created_at)",type="human")
      .flex.p-1(v-if="flight.location_last")
        .font-bold.mr-2 end:
        .text:  FormatDate(:value="moment(flight.location_last.created_at)",type="human")
      .flex.p-1(v-if="flight.location_first && flight.location_last")
        .font-bold.mr-2 duration:
        .text
          FormatDateRange(
            :start="moment(flight.location_first.created_at)"
            :end="moment(flight.location_last.created_at)")
  .m-4.p-4.border.border-blue-200.rounded.bg-blue-100(v-if="flight")
    pre {{ flight }}
</template>

<script>
import moment from  'moment'
import numeral from 'numeral'
import FormatDate from '@/components/format/FormatDate'
import FormatDateRange from '@/components/format/FormatDateRange'
export default {
  components: { FormatDate, FormatDateRange },
  filters: {
    numeral (value, format='0,0') {
      return numeral(value).format(format)
    },
  },
  data () {
    return {
      flight: false,
      moment: moment,
    }
  },
  mounted () { this.get() },
  methods: {
    async get () {
      this.flight = (await this.$axios.get(`/flight/${this.$route.params.id}`)).data.data
    },
  },

}
</script>
