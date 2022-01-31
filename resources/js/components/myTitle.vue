<template>
  <div class="q-pa-sm row text-right" :class="myclass">
      <div class="col-12 text-h4 bb" >
          {{text}}
      </div>
  </div>
</template>

<script>
export default {
  name: 'MyTitle',
    props:['text','myclass'],
  data () {
    return {}
  }
}
</script>
