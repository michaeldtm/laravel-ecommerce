<template>
    <div class="bg-white">
        <div class="mx-auto max-w-7xl overflow-hidden sm:px-6 lg:px-8 pb-32">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 py-6">Products</h2>

            <div class="-mx-px grid grid-cols-2 border-gray-200 sm:mx-0 md:grid-cols-3 lg:grid-cols-4">
                <div class="group relative border border-gray-200 p-4 sm:p-6" v-for="(product, key) in products" :key="key">
                    <div class="aspect-w-1 aspect-h-1 overflow-hidden rounded-lg bg-gray-200 group-hover:opacity-75">
                        <img :src="product.images[0].url" alt="TODO" class="h-full w-full object-cover object-center">
                    </div>
                    <div class="pt-10 pb-4 text-center">
                        <h3 class="text-sm font-medium text-gray-900">
                            <router-link :to="{name: 'ProductOverview', params: {sku: product.sku}}">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{product.name}}
                            </router-link>
                        </h3>
                        <div class="mt-3 flex flex-col items-center">
                            <p class="sr-only">{{product.stars}} out of 5 stars</p>
                            <div class="flex items-center">
                                <stars-rating :stars="product.stars" />
                            </div>
                            <p class="mt-1 text-sm text-gray-500">{{product.reviews}} reviews</p>
                        </div>
                        <p class="mt-4 text-base font-medium text-gray-900">${{product.price}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StarsRating from "../components/StarsRating.vue"

export default {
    name: "Home",
    components: {
        StarsRating
    },
    data: () => ({
        products: []
    }),
    mounted() {
        this.loadProducts()
    },
    methods: {
        loadProducts () {
            axios.get('/api/marketplace?include=features,images')
                .then(({data: res}) => {
                    this.products = res.data
                })
        }
    }
}
</script>

<style scoped>

</style>
