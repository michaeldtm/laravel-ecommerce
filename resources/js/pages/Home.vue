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
                            <router-link to="/product">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{product.name}}
                            </router-link>
                        </h3>
                        <div class="mt-3 flex flex-col items-center">
                            <p class="sr-only">5 out of 5 stars</p>
                            <div class="flex items-center">
                                <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>

                                <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>

                                <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>

                                <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>

                                <svg class="text-yellow-400 flex-shrink-0 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
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
export default {
    name: "Home",
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
