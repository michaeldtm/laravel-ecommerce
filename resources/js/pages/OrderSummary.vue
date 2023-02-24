<template>
    <div class="bg-white">
        <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="max-w-xl">
                <h1 class="text-base font-medium text-indigo-600">Thank you!</h1>
                <p class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl">It's on the way!</p>
                <p class="mt-2 text-base text-gray-500">Your order #14034056 has shipped and will be with you soon.</p>
            </div>

            <div class="mt-10 border-t border-gray-200">
                <h2 class="sr-only">Your order</h2>

                <h3 class="sr-only">Items</h3>

                <div class="flex space-x-6 border-b border-gray-200 py-10" v-for="item in items">
                    <img :src="item.images[0].url" alt="product image" class="h-20 w-20 flex-none rounded-lg bg-gray-100 object-cover object-center sm:h-40 sm:w-40">
                    <div class="flex flex-auto flex-col">
                        <div>
                            <h4 class="font-medium text-gray-900">
                                <a href="#">{{ item.name }}</a>
                            </h4>
                            <p class="mt-2 text-sm text-gray-600">{{ item.description }}</p>
                        </div>
                        <div class="mt-6 flex flex-1 items-end">
                            <dl class="flex space-x-4 divide-x divide-gray-200 text-sm sm:space-x-6">
                                <div class="flex">
                                    <dt class="font-medium text-gray-900">Quantity</dt>
                                    <dd class="ml-2 text-gray-700">1</dd>
                                </div>
                                <div class="flex pl-4 sm:pl-6">
                                    <dt class="font-medium text-gray-900">Price</dt>
                                    <dd class="ml-2 text-gray-700">${{ item.price }}.00</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="sm:ml-40 sm:pl-6">
                    <h3 class="sr-only">Summary</h3>

                    <dl class="space-y-6 border-t border-gray-200 pt-10 text-sm">
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Subtotal</dt>
                            <dd class="text-gray-700">{{ formatter?.format(subtotal) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="flex font-medium text-gray-900">
                                Discount
                            </dt>
                            <dd class="text-gray-700">$0.00</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Shipping</dt>
                            <dd class="text-gray-700">{{ formatter?.format(shipping) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Tax</dt>
                            <dd class="text-gray-700">{{ formatter?.format(tax) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Total</dt>
                            <dd class="text-gray-900">{{ formatter?.format(total) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "OrderSummary",
    data: () => ({
        items: null,
        shipping: 5,
        tax_percent: 12,
        formatter: null,
    }),
    mounted() {
        this.initialLoad()
        this.formatter = Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        })
    },
    methods: {
        initialLoad() {
            axios.get(`/api/marketplace/cart/${this.$route.params.id}`)
                .then(({data: res}) => {
                    this.items = res.items
                })
        }
    },
    computed: {
        subtotal() {
            return this.items?.reduce((carry, item) => {
                return carry + item.price
            }, 0)
        },
        tax() {
            const subtotal = this.subtotal + this.shipping
            return subtotal * (this.tax_percent / 100)
        },
        total() {
            return this.subtotal + this.tax
        }
    }
}
</script>

<style scoped>

</style>
