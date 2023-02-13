<template>
    <div id="nav">
        <router-link to="/">Home</router-link> |
        <router-link to="/product">Product Overview</router-link> |
        <router-link to="/checkout">Checkout</router-link> |
        <router-link to="/order">Order Summary</router-link>
    </div>
    <router-view />
</template>

<script>
export default {
    name: "App"
}
</script>

<style scoped>

</style>
