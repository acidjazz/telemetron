<template lang="pug">
  img(
    :src="`https://maps.googleapis.com/maps/api/staticmap?center=${lat},${lng}&zoom=13&size=340x120&key=${api_key}`"
  )
</template>


<script>
export default {
  props: {
    lat: {
      type: Number,
      required: true,
    },
    lng: {
      type: Number,
      required: true,
    }
  },
  data () {
    return {
      api_key: process.env.GOOGLE_API_KEY,
    }
  },
}
</script>
