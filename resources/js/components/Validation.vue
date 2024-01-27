<template>
    <span v-if="errorText" class="text-danger small" v-html="errorText"></span>
</template>

<script>
export default {
    name: "Validation",
    props: ['errorText']
}
</script>

<style scoped>

</style>
