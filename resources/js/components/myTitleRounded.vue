<template>
    <div class="q-pa-sm row flex-center">
        <q-btn :label="text" outline class="text-white q-px-lg"  size="lg" rounded
               no-caps
               :class="[active?'bg-primary':'',$q.screen.lt.md?'full-width':'']"/>

    </div>
</template>

<script>
    export default {
        name: 'MyTitleRounded',
        props: ['text', 'active'],
        data() {
            return {}
        }
    }
</script>
