<template lang="pug">
.container.p-8
  a.inline-block.border.border-gray.rounded.text-blue-500.px-4.py-2.mb-4(href="http://localhost:3000/api/flight") API Endpoint
  .flex.flex-wrap.-p-4
    .w-1_3.p-4(v-for="flight, index in flights")
      .p-2.border.border-gray.rounded.shadow
        .flex.p-2
          .font-bold.mr-2 id:
          nuxt-link.text.text-blue-500(:to="`/flight/${flight.id}`") {{ flight.id }}
        .flex.p-2
          .font-bold.mr-2 duration:
          .text {{ flight.duration | moment }}
        .flex.p-2(v-if="flight.takeOff")
          .font-bold.mr-2 take off:
          .text {{ flight.takeOff.accuracy }}
          a.mdi.mdi-map-marker.border.border-gray.px-2.self-end.ml-4.text-blue-500(
            target="_new",
            :href="`https://www.google.com/maps/place/?q=place_id:${flight.takeOff.place_id}`")
        .flex.p-2(v-if="flight.landing")
          .font-bold.mr-2 landing:
          .text {{ flight.landing.accuracy }}
          a.mdi.mdi-map-marker.border.border-gray.px-2.self-end.ml-4.text-blue-500(
            target="_new",
            :href="`https://www.google.com/maps/place/?q=place_id:${flight.landing.place_id}`")


</template>


<script>
import moment from 'moment'
export default {
  filters: {
    moment (seconds) {
      return moment.duration(seconds, 'seconds').humanize()
    }
  },
  data () {
    return {
      flights: {},
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
