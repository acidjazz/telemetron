<template lang="pug">
.container.p-8
  .m-4
    a.border.border-gray.rounded.text-blue-500.px-4.py-2.mb-4(target="_new",href="http://localhost:3000/api/flight")
      i.mdi.mdi-settings.mr-2
      span API Endpoint
      span &nbsp;
      span.font-bold /api/flight
  .flex.flex-wrap.-py-4(v-if="flights")
    .w-full.lg_w-1_3.p-4(v-for="flight, index in flights")
      .p-2.border.border-gray.rounded
        .flex.p-2
          .font-bold.mr-2 id:
          nuxt-link.text.text-blue-500(:to="`/flight/${flight.id}`") {{ flight.id }}
        .flex.p-2
          .font-bold.mr-2 duration:
          .text {{ flight.duration | moment }}
        .flex.p-2(v-if="flight.takeOff")
          .font-bold.mr-2 location:
          .text {{ flight.takeOff.accuracy }}
        a(
          v-if="flight.takeOff",
          target="_new",
          :href="`https://www.google.com/maps/place/?q=place_id:${flight.takeOff.place_id}`")
          GoogleMapImage(:lat="flight.takeOff.lat",:lng="flight.takeOff.lng")
  .p-8.m-8(v-else)
    span Loading..
  .m-4.p-4.border.border-blue-200.rounded.bg-blue-100(v-if="flights")
    pre.overflow-hidden {{ flights }}
</template>

<script>
import moment from 'moment'
import GoogleMapImage from '@/components/google/GoogleMapImage'
export default {
  components: { GoogleMapImage },
  filters: {
    moment (seconds) { return moment.duration(seconds, 'seconds').humanize() }
  },
  data () {
    return {
      api_key: process.env.GOOGLE_API_KEY,
      flights: false,
    }
  },
  mounted () { this.get() },
  methods: {
    async get () {
      this.flights = (await this.$axios.get('flight')).data.data
    },
  },
}
</script>
