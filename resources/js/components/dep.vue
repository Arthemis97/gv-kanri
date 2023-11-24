<script setup>
const open = ref(false)
const record = ref({})
useEvent.on(('modal:dep:open'), (data) => {
    open.value = true
    record.value = data
})

</script>
<template>
    <a-modal v-model:open="open" @ok="open = false">
        <div class="tw-p-6">
            <table class="tw-w-full">
                <thead>
                    <tr>
                        <td>氏名</td>
                        <td>フリガナ</td>
                        <td>性別</td>
                        <td>在留カード番号</td>
                        <td>マイナンバー</td>
                        <td>扶養</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(i, index) in record" :key="index">
                        <td>{{ i.name }}</td>
                        <td>{{ i.furigana }}</td>
                        <td>
                            {{ i.gender ? '男' : '女' }}
                        </td>
                        <td>{{ i.resisdence_card_number }}</td>
                        <td>{{ i.my_number }}</td>
                        <td>{{ i.dependent }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </a-modal>
</template>

<style scoped>
table,
td,
th {
    border: 1px solid;
}

table {
    width: 100%;
    border-collapse: collapse;
}

td {
    padding: 2px;
}
</style>

