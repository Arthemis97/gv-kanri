<script setup>
const open = ref(false)
const record = ref({})
useEvent.on(('modal:black:open'), (data) =>{
    open.value = true
    record.value = data
})

</script>
<template>
    <a-modal v-model:open="open" @ok="open = false">
        <a-textarea :rows="4" class="tw-w-full tw-mt-6 tw-pointer-events-none" v-model:value="record.black_list_description"></a-textarea>
    </a-modal>
</template>
