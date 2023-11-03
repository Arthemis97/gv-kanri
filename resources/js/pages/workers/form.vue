<script setup lang="ts">
import { onMounted } from "vue";
import useEmployeeStore from "../../stores/employee";
import { message } from "ant-design-vue";
import useNationStore from "../../stores/nation";
const employeeStore = useEmployeeStore();
const nationStore = useNationStore()
const { getErrors } = storeToRefs(employeeStore)
const { getList } = storeToRefs(nationStore)
const router = useRouter();
const route = useRoute();
const form = ref({})

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

const workplace = [
    { value: "1", text: "中沢乳業社" },
    { value: "2", text: "相模原" },
    { value: "3", text: "浦和美園センター" },
    { value: "4", text: "解体" },
    { value: "5", text: "引っ越し" }
]
const workplan = [
    { value: "1", text: "1年" },
    { value: "2", text: "2年" },
    { value: "3", text: "3年" },
    { value: "4", text: "3年以上" }
]
const visatype = [
    { value: "1", text: "外交 " },
    { value: "2", text: "公用" },
    { value: "3", text: "教授" },
    { value: "4", text: "芸術" },
    { value: "5", text: "宗教" },
    { value: "6", text: "報道" },
    { value: "7", text: "高度専門職" },
    { value: "8", text: "経営・管理" },
    { value: "9", text: "法律・会計業務" },
    { value: "10", text: "医療" },
    { value: "11", text: "研究" },
    { value: "12", text: "教育" },
    { value: "13", text: "技術・人文知" },
    { value: "14", text: "識・国際業務" },
    { value: "15", text: "企業内転勤" },
    { value: "16", text: "介護（※１）" },
    { value: "17", text: "興行" },
    { value: "18", text: "技能" },
    { value: "19", text: "技能実習" }
]
const advancement = [
    { value: "1", text: "就職" },
    { value: "2", text: "進学" },
    { value: "3", text: "帰国" },
    { value: "4", text: "休職" }
]
const jpnlvl = [
    { value: "1", text: "N1" },
    { value: "2", text: "N2" },
    { value: "3", text: "N3" },
    { value: "4", text: "N4" },
    { value: "5", text: "N5" },
    { value: "6", text: "NO" }
]

const save = async () => {
    if (form.value.id) {
        await employeeStore.update(form.value.id, form.value)
        message.success('Updated')
        router.push('/workers')
    } else {
        await employeeStore.storeWorker(form.value)
        // if (getErrors.value) {
        // }
        message.success('Success')
        router.push('/workers')
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

const filterOption = (input: string, option: any) => {
    return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
};

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
    <a-form class="tw-max-w-[600px]" layout="vertical">
        <a-row :gutter="14">
            <a-col :span="12">
                <a-form-item label="氏名">
                    <a-input placeholder="氏名" v-model:value="form.name"
                        :status="getErrors && getErrors.errors.name ? 'error' : ''" />
                </a-form-item>
            </a-col>
            <a-col :span="12">
                <a-form-item label="フリガナ">
                    <a-input placeholder="フリガナ" v-model:value="form.furigana"
                        :status="getErrors && getErrors.errors.furigana ? 'error' : ''" />
                </a-form-item>
            </a-col>
            <a-col :span="12">
                <a-form-item label="ID">
                    <a-input placeholder="ID" v-model:value="form.custom_id"
                        :status="getErrors && getErrors.errors.custom_id ? 'error' : ''" />
                </a-form-item>
            </a-col>
            <a-col :span="12">
                <a-form-item label="誕生日">
                    <a-date-picker valueFormat="YYYY-MM-DD" placeholder="誕生日" class="tw-w-full" v-model:value="form.dob"
                        :status="getErrors && getErrors.errors.dob ? 'error' : ''" />
                </a-form-item>
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
                <a-form-item label="性別">
                    <a-select placeholder="性別" v-model:value="form.gender"
                        :status="getErrors && getErrors.errors.gender ? 'error' : ''">
                        <a-select-option key="1" :value="1">男</a-select-option>
                        <a-select-option key="2" :value="0">女</a-select-option>
                    </a-select>
                </a-form-item>
            </a-col>



            <a-col :span="12">
                <a-form-item label="国籍">
                    <a-select placeholder="国籍" v-model:value="form.nationality" show-search :filter-option="filterOption"
                        :status="getErrors && getErrors.errors.nationality ? 'error' : ''">
                        <a-select-option v-for="(nation, nation_id) in getList" :key="nation_id" :label="nation.name_jp"
                            :value="nation.id">{{
                                nation.name_jp }}</a-select-option>
                    </a-select>
                </a-form-item>
            </a-col>

            <a-col :span="12">
                <a-form-item label="在留資格">
                    <a-select placeholder="在留資格" v-model:value="form.visa_type" show-search :filter-option="filterOption"
                        :status="getErrors && getErrors.errors.visa_type ? 'error' : ''">
                        <a-select-option v-for="(visa, visa_id) in visatype" :key="visa_id" :label="visa.text"
                            :value="visa.value">{{
                                visa.text }}</a-select-option>
                    </a-select>
                </a-form-item>
            </a-col>

            <a-col :span="12">
                <a-form-item label="就労制限">
                    <a-select placeholder="就労制限" v-model:value="form.work_restrictions"
                        :status="getErrors && getErrors.errors.work_restrictions ? 'error' : ''">
                        <a-select-option key="1" :value="1">Yes</a-select-option>
                        <a-select-option key="2" :value="0">No</a-select-option>
                    </a-select>
                </a-form-item>
            </a-col>

            <a-col :span="12">
                <a-form-item label="就職 / 進学">
                    <a-select placeholder="就職 / 進学" v-model:value="form.advancement" show-search
                        :filter-option="filterOption" :status="getErrors && getErrors.errors.advancement ? 'error' : ''">
                        <a-select-option v-for="(adv, adv_id) in advancement" :key="adv_id" :label="adv.text"
                            :value="adv.value">{{
                                adv.text }}</a-select-option>
                    </a-select>
                </a-form-item>
            </a-col>


            <a-col :span="12">
                <a-form-item label="日本語レベル">
                    <a-select placeholder="日本語レベル" v-model:value="form.japanese_level"
                        :status="getErrors && getErrors.errors.japanese_level ? 'error' : ''">
                        <a-select-option v-for="(jpn, jpn_id) in jpnlvl" :key="jpn_id" :label="jpn.text"
                            :value="jpn.value">{{
                                jpn.text }}</a-select-option>
                    </a-select>
                </a-form-item>
            </a-col>


            <a-col :span="12">
                <a-form-item label="急遽連絡先">
                    <a-input placeholder="急遽連絡先" v-model:value="form.urgent_contact"
                        :status="getErrors && getErrors.errors.urgent_contact ? 'error' : ''" />
                </a-form-item>
            </a-col>

            <a-col :span="24">
                <a-form-item label="住所">
                    <a-input placeholder="住所" v-model:value="form.address"
                        :status="getErrors && getErrors.errors.address ? 'error' : ''" />
                </a-form-item>
            </a-col>
            <a-col :span="12">
                <a-form-item label="在留期間">
                    <a-input placeholder="在留期間" v-model:value="form.pos"
                        :status="getErrors && getErrors.errors.pos ? 'error' : ''" />
                </a-form-item>
            </a-col>
            <a-col :span="12">
                <a-form-item label="終了日">
                    <a-date-picker valueFormat="YYYY-MM-DD" placeholder="終了日" class="tw-w-full"
                        v-model:value="form.pos_date" :status="getErrors && getErrors.errors.pos_date ? 'error' : ''" />
                </a-form-item>
            </a-col>
            <a-col :span="24">
                <a-form-item label="運転免許">
                    <a-select placeholder="運転免許" v-model:value="form.driver_license"
                        :status="getErrors && getErrors.errors.driver_license ? 'error' : ''">
                        <a-select-option v-for="(i, i_index) in drlc" :value="i.value" :key="i_index">{{ i.text
                        }}</a-select-option>
                    </a-select>
                </a-form-item>
            </a-col>
        </a-row>
        <a-button type="primary" @click="save">Save</a-button>
    </a-form>
</template>

