<template>
    <div>
        <h1>Fetch Modern</h1>
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

<script setup>
import { ref, onMounted } from 'vue'

const products = ref([])

const fetchProducts = () => {
    fetch(`${import.meta.env.VITE_API_URL}products`)
        .then(response => response.json())
        .then(data => {
            products.value = data
        })
}

onMounted(() => {
    fetchProducts()
})
</script>

<style scoped>

</style>