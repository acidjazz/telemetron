<template lang="pug">
#Flight.m-4.p-5
  nuxt-link(to="/").inline-block.border.border-gray.rounded.text-blue-500.px-4.py-2.mb-4.mr-4 Back
  a.inline-block.border.border-gray.rounded.text-blue-500.px-4.py-2.mb-4(:href="`http://localhost:3000/api/flight/${$route.params.id}`") API Endpoint
  .p-2.border.border-gray.rounded.shadow
    pre {{ flight }}
</template>


<script>
export default {
  data () {
    return {
      flight: {},
    }
  },
  mounted () { this.get() },
  methods: {
    async get () {
      this.flight = (await this.$axios.get(`/flight/${this.$route.params.id}`)).data.data
      console.log(this.flight)
    },
  },

}
</script>
