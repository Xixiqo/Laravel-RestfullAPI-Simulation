<template>
    <div class="fetch">
        <h1>Fetch</h1>
        <button @click="fetchProducts">Show products</button>
        <div v-if="products.length > 0">
            <ul>
                <li v-for="p in products" :key="p.id">
                    {{ p.name }}
                </li>
            </ul>
        </div>
        <div v-else>
            <p>No products found</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            products: [],
        }
    },
    mounted() {
        this.fetchProducts()
    },
    methods: {
        fetchProducts() {
            fetch('http://localhost:8000/api/products')
                .then(response => response.json())
                .then(data => {
                    this.products = data
                })
        },
    },
}
</script>

<style scoped>

</style>