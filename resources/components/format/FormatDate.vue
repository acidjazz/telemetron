<template lang="pug">
time.tooltip(
  :datetime="value",
  :data-tooltip="value.format('dddd, MMM Do, `YY @ hh:mm:ss a')",
  ) {{ formatted(format) }}
</template>

<script>

export default {

  props: {
    value: {
      type: Object,
      required: true,
    },

    type: {
      type: String,
      required: false,
      default: 'fromNow',
    },
    format: {
      type: [String,Boolean],
      required: false,
      default: false,
    },
  },

  methods: {
    formatted(type) {

      if (this.format)
        return this.value.format(this.format)

      if (this.type === 'long')
        return this.value.format('dddd, MMM Do, `YY @ hh:mm:ss a')

      if (this.type === 'human')
        return this.value.format('ddd, MMM Do, h:mm a')

      if (this.type === 'time')
        return this.value.format('h:mm a')

      if (this.type === 'fromNow') {
          return this.value.fromNow()
      }
    }
  },


}

</script>
