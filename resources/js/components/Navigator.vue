<template>
  <div class="q-pa-sm row text-right" :class="myclass">
      <q-btn label="Volver" color="primary" @click="$router.go(-1)"/>
  </div>
</template>

<script>
export default {
  name: 'Navigator',
    props:['myclass'],
  data () {
    return {}
  }
}
</script>
