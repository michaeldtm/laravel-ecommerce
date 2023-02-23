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

                <div class="flex space-x-6 border-b border-gray-200 py-10">
                    <img src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-01.jpg" alt="Glass bottle with black plastic pour top and mesh insert." class="h-20 w-20 flex-none rounded-lg bg-gray-100 object-cover object-center sm:h-40 sm:w-40">
                    <div class="flex flex-auto flex-col">
                        <div>
                            <h4 class="font-medium text-gray-900">
                                <a href="#">Organize Basic Set (Walnut)</a>
                            </h4>
                            <p class="mt-2 text-sm text-gray-600">Gather adapts to your workspace and workflow to make sure the tools you need are always within reach and is flexible enough to use in any space.</p>
                        </div>
                        <div class="mt-6 flex flex-1 items-end">
                            <dl class="flex space-x-4 divide-x divide-gray-200 text-sm sm:space-x-6">
                                <div class="flex">
                                    <dt class="font-medium text-gray-900">Quantity</dt>
                                    <dd class="ml-2 text-gray-700">1</dd>
                                </div>
                                <div class="flex pl-4 sm:pl-6">
                                    <dt class="font-medium text-gray-900">Price</dt>
                                    <dd class="ml-2 text-gray-700">$149.00</dd>
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
                            <dd class="text-gray-700">$149.00</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="flex font-medium text-gray-900">
                                Discount
                            </dt>
                            <dd class="text-gray-700">$0.00</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Shipping</dt>
                            <dd class="text-gray-700">$5.00</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Tax</dt>
                            <dd class="text-gray-700">$18.48</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Total</dt>
                            <dd class="text-gray-900">$172.48</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "OrderSummary"
}
</script>

<style scoped>

</style>
