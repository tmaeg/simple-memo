<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { useForm, Head } from '@inertiajs/vue3';

defineProps(['memos']);

const form = useForm({
    content: '',
});
</script>

<template>
    <Head title="Simple Memo" />
    
    <AuthenticatedLayout>
        <div>
            <h2>新規登録</h2>
            <form @submit.prevent="form.post(route('memos.store'), { onSuccess: () => form.reset() })">
                <input type="text" v-model="form.content" />
                <InputError :message="form.errors.content" />
                <PrimaryButton>登録</PrimaryButton>
            </form>
            <hr />
            <h2>メモ一覧</h2>
            <table class="table-auto">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>メモ内容</td>
                        <td>作成日時</td>
                        <td>更新日時</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(memo, no) in memos" :key="memo.id">
                        <td>{{ no }}</td>
                        <td>{{ memo.content }}</td>
                        <td>{{ new Date(memo.created_at).toLocaleDateString() }}</td>
                        <td>{{ new Date(memo.updated_at).toLocaleDateString() }}</td>
                        <td><SecondaryButton @click="() => updateMemo(memo.id, no)">編集</SecondaryButton></td>
                        <td><DangerButton>削除</DangerButton></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
  methods: {
    updateMemo(memo, no) {
        this.$inertia.visit(route('memos.edit', {memo, no}));
    },
  },
};
</script>
