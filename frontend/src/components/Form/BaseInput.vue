<template>
    <div>
        <BaseLabel v-if="label">{{ label }}</BaseLabel>
        <div class="mt-1">
            <input
                v-bind="$attrs"
                :placeholder="placeholder || label"
                v-model="this.username"
                class="focus:ring-0 focus:border-primary dark:focus:border-gray-200 bg-inherit block w-full sm:text-sm border-0 border-b-2 border-gray-300 dark:border-gray-700 dark:text-gray-200"
            />
        </div>
        <FormError :error="error" />
    </div>
</template>

<script>
export default {
    name: 'BaseInput',
    inheritAttrs: false,
    data(){
    return {
   
        form:{
            username: '',
            password: ''     
        }
    }
    },

    mounted() {
        console.log(this.form.username,this.form.password)
    }
}
</script>

<script setup>
console.log(props.model)
console.log(props.model)
const props = defineProps({
    label: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: ''
    },
    error: {
        type: String,
        default: ''
    },
    model: {
        type: String,
        default: ''
    }
})
</script>

