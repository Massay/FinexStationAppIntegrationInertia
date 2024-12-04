<template>
    <span>
        {{ new Intl.NumberFormat('en-GB', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2, style: 'currency', currency: 'GMD'
        }).format(value) }}
    </span>
</template>


<script setup>

defineProps({
    value: {
        type: Number,
        required: true
    }
})
</script>