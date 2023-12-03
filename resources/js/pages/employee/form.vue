<script setup lang="ts">
import { PlusOutlined, DeleteOutlined } from "@ant-design/icons-vue"
import { onMounted } from "vue";
import useEmployeeStore from "../../stores/employee";
import { message } from "ant-design-vue";
const employeeStore = useEmployeeStore();
const router = useRouter();
const route = useRoute();
const form = ref({})
const loading = ref(false)
const errors = ref({})

const drlc = [
    { value: "1", text: "普通免許(AT、MT、第一種、第二種)" },
    { value: "2", text: "準中型免許" },
    { value: "3", text: "中型免許(第一種、第二種)" },
    { value: "4", text: "大型免許(第一種、第二種)" },
    { value: "5", text: "小型特殊免許" },
    { value: "6", text: "大型特殊免許(第一種、第二種)" },
    { value: "7", text: "牽引免許(第一種、第二種)" },
    { value: "8", text: "普通二輪免許(AT、MT)" },
    { value: "9", text: "大型二輪免許" },
    { value: "10", text: "原付免許" },
    { value: "11", text: "運転免許証なし" }
]

const managers = [
    { value: "1", text: 'モンスタースレン' },
    { value: "2", text: '前村潤奎' },
    { value: "3", text: '海老原美寿々' },
    { value: "4", text: '野中梢絵' },
    { value: "5", text: '鈴木孝之' },
    { value: "6", text: '土屋佑}太' }
]

const workplace = [
    { value: '1', text: "事務" },
    { value: '2', text: "中沢乳業社" },
    { value: '3', text: "相模原" },
    { value: '4', text: "浦和美園センター" },
    { value: '5', text: "太田市場" },
    { value: '6', text: "運転者" },
    { value: '7', text: "公徳" },
    { value: '8', text: "その他" },
]
const workplan = [
    { value: "1", text: "1年" },
    { value: "2", text: "2年" },
    { value: "3", text: "3年" },
    { value: "4", text: "3年以上" }
]

const pos = [
    { value: "1", text: "1年3ヶ月" },
    { value: "2", text: "3年" },
    { value: "3", text: "5年" },
    { value: "4", text: "5年以降" }
]

const save = async () => {
    loading.value = true
    if (form.value.id) {
        const resp = await employeeStore.update(form.value.id, form.value)
        if (resp.data.errors) {
            errors.value = resp.data.errors
            loading.value = false
        } else {
            message.success('Updated')
            router.push('/employee')
        }
    } else {
        const resp = await employeeStore.store(form.value)
        if (resp.data.errors) {
            errors.value = resp.data.errors
            loading.value = false
        } else {
            message.success('Success')
            router.push('/employee')
        }
    }
}

const handleImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = (e) => {
            form.value.picture = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

const addDependent = () => {
    if (!form.value.relation) {
        form.value.relation = []
    }
    form.value.relation.push({})
}

const removeDependent = (index) => {
    form.value.relation.splice(index, 1)
}

onMounted(async () => {
    if (route.params.id) {
        const data = await employeeStore.fetchOne(route.params.id)
        if (data && data.id) {
            form.value = data
        }
    }
})
</script>
<template>
    <div class="tw-flex tw-space-x-4">
        <a-form class="tw-max-w-[600px] tw-flex-1" layout="vertical">
            <a-row :gutter="14">
                <a-col :span="12">
                    <a-form-item label="氏名">
                        <a-input placeholder="氏名" v-model:value="form.name" :status="errors.name ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="フリガナ">
                        <a-input placeholder="フリガナ" v-model:value="form.furigana"
                            :status="errors.furigana ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="呼ぶ名">
                        <a-input placeholder="呼ぶ名" v-model:value="form.nick_name"
                            :status="errors.nick_name ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="誕生日">
                        <a-date-picker valueFormat="YYYY-MM-DD" placeholder="誕生日" class="tw-w-full" v-model:value="form.dob"
                            :status="errors.dob ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="性別">
                        <a-select placeholder="性別" v-model:value="form.gender" :status="errors.gender ? 'error' : ''">
                            <a-select-option key="1" :value="1">男</a-select-option>
                            <a-select-option key="2" :value="0">女</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="電話番号">
                        <a-input placeholder="電話番号" v-model:value="form.phone_number"
                            :status="errors.phone_number ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="24">
                    <a-form-item label="住所">
                        <a-input placeholder="住所" v-model:value="form.address" :status="errors.address ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="在留カード番号">
                        <a-input placeholder="在留カード番号" v-model:value="form.resisdence_card_number"
                            :status="errors.resisdence_card_number ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="マイナンバー">
                        <a-input placeholder="マイナンバー" v-model:value="form.my_number"
                            :status="errors.my_number ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="扶養">
                        <a-select placeholder="扶養" v-model:value="form.dependent" :status="errors.dependent ? 'error' : ''">
                            <a-select-option key="1" :value="1">います</a-select-option>
                            <a-select-option key="2" :value="0">いません</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="12">

                </a-col>
                <a-col :span="12">
                    <a-form-item label="写真">
                        <input type="file" accept="image/*" @change="handleImage">
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-avatar v-if="form.picture" :size="128" :src="form.picture">
                    </a-avatar>
                </a-col>
                <a-col :span="12">

                    <a-form-item label="在留期間">
                        <a-select placeholder="在留期間" v-model:value="form.pos" :status="errors.pos ? 'error' : ''">
                            <a-select-option v-for="(i, i_index) in pos" :value="i.value" :key="i_index">{{ i.text
                            }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="終了日">
                        <a-date-picker valueFormat="YYYY-MM-DD" placeholder="終了日" class="tw-w-full"
                            v-model:value="form.pos_date" :status="errors.pos_date ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="24">
                    <a-form-item label="運転免許">
                        <a-select placeholder="運転免許" v-model:value="form.driver_license"
                            :status="errors.driver_license ? 'error' : ''">
                            <a-select-option v-for="(i, i_index) in drlc" :value="i.value" :key="i_index">{{ i.text
                            }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="職場名">
                        <a-select placeholder="職場名" v-model:value="form.working_place"
                            :status="errors.working_place ? 'error' : ''">
                            <a-select-option v-for="(i, i_index) in workplace" :value="i.value" :key="i_index">{{ i.text
                            }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="入社日">
                        <a-date-picker valueFormat="YYYY-MM-DD" placeholder="入社日" class="tw-w-full"
                            v-model:value="form.start_date" :status="errors.start_date ? 'error' : ''" />
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="働く期間（プラン）">
                        <a-select placeholder="働く期間（プラン）" v-model:value="form.working_plan"
                            :status="errors.working_plan ? 'error' : ''">
                            <a-select-option v-for="(i, i_index) in workplan" :value="i.value" :key="i_index">{{ i.text
                            }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="12">
                    <a-form-item label="担当者">
                        <a-select placeholder="担当者" v-model:value="form.manager" :status="errors.manager ? 'error' : ''">
                            <a-select-option v-for="(i, i_index) in managers" :value="i.value" :key="i_index">{{ i.text
                            }}</a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="24">
                    <a-form-item label="自己PR">
                        <a-input placeholder="自己PR" v-model:value="form.introduce"
                            :status="errors.introduce ? 'error' : ''" />
                    </a-form-item>
                </a-col>
            </a-row>
            <a-button :disabled="loading" type="primary" @click="save">Save</a-button>
        </a-form>
        <div class="tw-flex-1">
            <template v-if="form.dependent">
                <div class="tw-flex tw-space-x-4 tw-mb-2">
                    <a-button size="small" @click="addDependent">
                        <PlusOutlined #icon />
                    </a-button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <td>氏名</td>
                            <td>フリガナ</td>
                            <td>性別</td>
                            <td>在留カード番号</td>
                            <td>マイナンバー</td>
                            <td>扶養</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(i, index) in form.relation" :key="index">
                            <td><a-input size="small" v-model:value="i.name" /></td>
                            <td><a-input size="small" v-model:value="i.furigana" /></td>
                            <td>
                                <a-select size="small" placeholder="性別" v-model:value="i.gender">
                                    <a-select-option key="1" :value="1">男</a-select-option>
                                    <a-select-option key="2" :value="0">女</a-select-option>
                                </a-select>
                            </td>
                            <td><a-input size="small" v-model:value="i.resisdence_card_number" /></td>
                            <td><a-input size="small" v-model:value="i.my_number" /></td>
                            <td><a-input size="small" v-model:value="i.dependent" /></td>
                            <td>
                                <a-button danger size="small" @click="removeDependent(index)">
                                    <DeleteOutlined #icon />
                                </a-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <div class="tw-flex tw-flex-col tw-space-y-2 tw-mt-4">
                <a-alert v-for="(i, index) in Object.keys(errors)" :key="index" :message="errors[i][0]" type="error"
                    show-icon />
            </div>
        </div>
    </div>
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

