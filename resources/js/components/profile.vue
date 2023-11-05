<script setup>
const open = ref(false)
const record = ref({})
useEvent.on(('modal:profile:open'), (data) =>{
    open.value = true
    record.value = data
})

</script>
<template>
    <a-modal v-model:open="open" @ok="open = false">
        <div class="tw-flex tw-flex-col tw-max-w-md tw-p-6">
            <div class="tw-text-center tw-mb-5">
                <a-avatar v-if="record.picture" :size="256" :src="record.picture">
                </a-avatar>
            </div>
            <div class="tw-text-center">
                <h2 class="tw-text-xl tw-font-semibold">{{ record.name }}</h2>
                <span class="tw-block tw-pb-2 tw-text-sm"><b>フリガナ:</b> {{ record.furigana }}</span>
                <span class="tw-block tw-pb-2 tw-text-sm"><b>電話番:</b> {{ record.phone_number }}</span>
                <span class="tw-block tw-pb-2 tw-text-sm"><b>住所:</b> {{ record.address }}</span>

            </div>
        </div>
    </a-modal>
</template>
