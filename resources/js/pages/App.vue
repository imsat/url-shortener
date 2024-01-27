<template>
    <Navbar/>
    <router-view />
    <Footer/>
</template>

<script>
import Navbar from "./Navbar.vue";
import Footer from "./Footer.vue";
export default {
    components: {Footer, Navbar}
}
</script>

<style scoped>

</style>
