<template>
    
</template>

<script>
export default {
    name: 'BaseForm'
}
</script>

<script setup>
const props = defineProps({
    size: {
        type: String,
        default: 'md'
    },
    block: Boolean,
    design: {
        type: String,
        default: 'primary'
    }
})
</script>
