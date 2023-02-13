import { createWebHistory, createRouter } from "vue-router";
import ProductOverview from "../pages/ProductOverview.vue";
import Checkout from "../pages/Checkout.vue";
import OrderSummary from "../pages/OrderSummary.vue";

const routes = [
    {
        path: "/product",
        name: "ProductOverview",
        component: ProductOverview,
    },
    {
        path: "/checkout",
        name: "Checkout",
        component: Checkout,
    },
    {
        path: "/order",
        name: "OrderSummary",
        component: OrderSummary,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
