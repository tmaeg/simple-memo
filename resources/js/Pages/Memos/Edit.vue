<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps(['memo', 'no']);

const form = useForm({
    content: props.memo.content,
});
const title = computed(() => {
    return `No${props.no} メモ編集`;
});
</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <h2>{{ title }}</h2>
        <div>
            <h3>メモ内容</h3>
            <form @submit.prevent="form.put(route('memos.update', memo.id))">
                <input type="text" v-model="form.content" />
                <InputError :message="form.errors.content" />
                <div>
                    <SecondaryButton @click="moveToDashboard">戻る</SecondaryButton>
                    <PrimaryButton>修正</PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
  methods: {
    moveToDashboard() {
        this.$inertia.visit(route('dashboard'));
    },
  },
};
</script>
